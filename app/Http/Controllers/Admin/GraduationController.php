<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graduation;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GraduationExport;

class GraduationController extends Controller
{
    /**
     * Halaman Penetapan / Evaluasi Kelulusan Siswa Kelas Tingkat Akhir (Kelas XII).
     */
    public function index(Request $request)
    {
        $query = Graduation::active();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('class_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->filled('sort')) {
            if ($request->sort == 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort == 'name_desc') {
                $query->orderBy('name', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $graduations = $query->paginate(20)->withQueryString();
        $archivedCount = Graduation::archived()->count();
        $lulusCount = Graduation::active()->where('status', 'Lulus')->count();
        $pendingCount = Graduation::active()->where('status', 'Pending')->count();

        // Ambil kelas tingkat akhir (Kelas XII atau semua kelas)
        $classes = SchoolClass::orderBy('name')->get();
        $angkatanList = Graduation::distinct()->whereNotNull('angkatan')->pluck('angkatan')->toArray();
        if (empty($angkatanList)) {
            $angkatanList = [date('Y'), date('Y') - 1];
        }

        return view('admin.kelulusan.index', compact('graduations', 'archivedCount', 'lulusCount', 'pendingCount', 'classes', 'angkatanList'));
    }

    /**
     * Tarik siswa kelas tingkat akhir (Kelas XII) ke daftar evaluasi kelulusan.
     */
    public function pullKelas(Request $request)
    {
        $request->validate([
            'class_id'     => 'required|string',
            'angkatan'     => 'required|string|max:10',
            'tahun_ajaran' => 'required|string|max:20',
        ]);

        $classId     = $request->class_id;
        $angkatan    = $request->angkatan;
        $tahunAjaran = $request->tahun_ajaran;

        $studentQuery = User::where('role', 'student')->where('is_graduated', false);

        if ($classId === 'all_xii') {
            // Tarik semua kelas yang namanya diawali 'XII' atau '12'
            $xiiClassIds = SchoolClass::where(function($q) {
                $q->where('name', 'like', 'XII%')->orWhere('name', 'like', '12%');
            })->pluck('id')->toArray();

            if (empty($xiiClassIds)) {
                return redirect()->back()->with('error', 'Tidak ditemukan data kelas XII / tingkat akhir.');
            }
            $studentQuery->whereIn('class_id', $xiiClassIds);
        } else {
            $studentQuery->where('class_id', $classId);
        }

        $students = $studentQuery->with('class')->get();

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada siswa aktif pada kelas yang dipilih.');
        }

        $count = 0;
        foreach ($students as $siswa) {
            $nisn = $siswa->nis ?: ($siswa->nik ?: $siswa->email);
            $className = $siswa->class ? $siswa->class->name : 'Kelas XII';

            Graduation::updateOrCreate(
                ['nisn' => $nisn],
                [
                    'user_id'      => $siswa->id,
                    'name'         => $siswa->name,
                    'status'       => 'Pending',
                    'angkatan'     => $angkatan,
                    'class_name'   => $className,
                    'tahun_ajaran' => $tahunAjaran,
                    'is_archived'  => false,
                    'archived_at'  => null,
                ]
            );
            $count++;
        }

        return redirect()->route('admin.kelulusan.index')
            ->with('success', "Berhasil menarik {$count} data siswa Kelas XII untuk evaluasi kelulusan Angkatan {$angkatan}.");
    }

    /**
     * Set Status Kelulusan (Lulus / Tidak Lulus) secara individual.
     */
    public function setStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Lulus,Tidak Lulus,Pending',
        ]);

        $grad = Graduation::findOrFail($id);
        $status = $request->status;
        $now = now();

        if ($status === 'Lulus') {
            $grad->update([
                'status'      => 'Lulus',
                'is_archived' => true,
                'archived_at' => $now,
            ]);

            // Cari user siswa
            $user = null;
            if ($grad->user_id) {
                $user = User::find($grad->user_id);
            }
            if (!$user) {
                $user = User::where('role', 'student')
                    ->where(function ($q) use ($grad) {
                        $q->where('nis', $grad->nisn)
                          ->orWhere('name', $grad->name);
                    })->first();
            }

            if ($user) {
                $user->update([
                    'is_graduated'      => true,
                    'graduated_at'      => $now,
                    'angkatan'          => $grad->angkatan ?? date('Y'),
                    'previous_class_id' => $user->class_id ?: $user->previous_class_id,
                    'class_id'          => null, // Dilepas dari rombel kelas aktif
                ]);
            }

            return redirect()->back()->with('success', "Siswa {$grad->name} berhasil dinyatakan LULUS dan dipindahkan ke Tabel Alumni SMA 5 Angkatan {$grad->angkatan}.");
        } else {
            $grad->update([
                'status'      => $status,
                'is_archived' => false,
                'archived_at' => null,
            ]);

            // Jika status bukan lulus, pastikan akun tetap aktif
            $user = null;
            if ($grad->user_id) {
                $user = User::find($grad->user_id);
            }
            if (!$user) {
                $user = User::where('role', 'student')
                    ->where(function ($q) use ($grad) {
                        $q->where('nis', $grad->nisn)
                          ->orWhere('name', $grad->name);
                    })->first();
            }

            if ($user && $user->is_graduated) {
                $user->update([
                    'is_graduated' => false,
                    'graduated_at' => null,
                    'class_id'     => $user->previous_class_id ?: $user->class_id,
                ]);
            }

            return redirect()->back()->with('success', "Status kelulusan {$grad->name} diperbarui menjadi {$status}.");
        }
    }

    /**
     * Kelulusan Massal untuk Siswa Tingkat Akhir.
     */
    public function kelulusanMassal(Request $request)
    {
        $action = $request->input('action', 'luluskan_semua');
        $ids = $request->input('selected_ids', []);
        $now = now();

        $query = Graduation::active();
        if ($action === 'luluskan_terpilih' && !empty($ids)) {
            $query->whereIn('id', $ids);
        }

        $list = $query->get();
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data siswa untuk diproses kelulusannya.');
        }

        $count = 0;
        foreach ($list as $grad) {
            $grad->update([
                'status'      => 'Lulus',
                'is_archived' => true,
                'archived_at' => $now,
            ]);

            $user = null;
            if ($grad->user_id) {
                $user = User::find($grad->user_id);
            }
            if (!$user) {
                $user = User::where('role', 'student')
                    ->where(function ($q) use ($grad) {
                        $q->where('nis', $grad->nisn)
                          ->orWhere('name', $grad->name);
                    })->first();
            }

            if ($user) {
                $user->update([
                    'is_graduated'      => true,
                    'graduated_at'      => $now,
                    'angkatan'          => $grad->angkatan ?? date('Y'),
                    'previous_class_id' => $user->class_id ?: $user->previous_class_id,
                    'class_id'          => null, // Dilepas dari kelas aktif
                ]);
            }
            $count++;
        }

        return redirect()->route('admin.kelulusan.alumni')
            ->with('success', "Sebanyak {$count} siswa berhasil dinyatakan LULUS dan dipindahkan ke Tabel Alumni SMA 5.");
    }

    /**
     * Halaman Tabel Alumni SMA Negeri 5 (Arsip Siswa Lulus per Angkatan).
     */
    public function alumniView(Request $request)
    {
        $query = Graduation::archived();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('class_name', 'like', "%{$search}%")
                  ->orWhere('angkatan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->filled('sort')) {
            if ($request->sort == 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort == 'name_desc') {
                $query->orderBy('name', 'desc');
            } elseif ($request->sort == 'angkatan_desc') {
                $query->orderBy('angkatan', 'desc');
            } else {
                $query->orderBy('archived_at', 'desc');
            }
        } else {
            $query->orderBy('archived_at', 'desc');
        }

        $graduations = $query->paginate(20)->withQueryString();
        $activeCount = Graduation::active()->count();
        $totalAlumni = Graduation::archived()->count();
        $angkatanList = Graduation::archived()->distinct()->whereNotNull('angkatan')->orderBy('angkatan', 'desc')->pluck('angkatan')->toArray();

        return view('admin.kelulusan.arsip', compact('graduations', 'activeCount', 'totalAlumni', 'angkatanList'));
    }

    /**
     * Nonaktifkan & arsipkan 1 siswa yang LULUS ke Alumni.
     */
    public function archive($id)
    {
        $grad = Graduation::findOrFail($id);
        $now = now();
        $grad->update([
            'status'      => 'Lulus',
            'is_archived' => true,
            'archived_at' => $now,
        ]);

        $user = null;
        if ($grad->user_id) {
            $user = User::find($grad->user_id);
        }
        if (!$user) {
            $user = User::where('role', 'student')
                ->where(function ($q) use ($grad) {
                    $q->where('nis', $grad->nisn)
                      ->orWhere('name', $grad->name);
                })->first();
        }

        if ($user) {
            $user->update([
                'is_graduated'      => true,
                'graduated_at'      => $now,
                'angkatan'          => $grad->angkatan ?? date('Y'),
                'previous_class_id' => $user->class_id ?: $user->previous_class_id,
                'class_id'          => null,
            ]);
        }

        return redirect()->back()->with('success', "Siswa {$grad->name} berhasil dipindahkan ke Alumni SMA 5.");
    }

    /**
     * Nonaktifkan & arsipkan SELURUH siswa yang berstatus LULUS.
     */
    public function archiveAll()
    {
        $lulusList = Graduation::active()->where('status', 'Lulus')->get();

        if ($lulusList->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data siswa berstatus Lulus yang dapat diarsipkan.');
        }

        $now = now();
        foreach ($lulusList as $grad) {
            $grad->update([
                'is_archived' => true,
                'archived_at' => $now,
            ]);

            $user = null;
            if ($grad->user_id) {
                $user = User::find($grad->user_id);
            }
            if (!$user) {
                $user = User::where('role', 'student')
                    ->where(function ($q) use ($grad) {
                        $q->where('nis', $grad->nisn)
                          ->orWhere('name', $grad->name);
                    })->first();
            }

            if ($user) {
                $user->update([
                    'is_graduated'      => true,
                    'graduated_at'      => $now,
                    'angkatan'          => $grad->angkatan ?? date('Y'),
                    'previous_class_id' => $user->class_id ?: $user->previous_class_id,
                    'class_id'          => null,
                ]);
            }
        }

        $count = $lulusList->count();
        return redirect()->route('admin.kelulusan.alumni')
            ->with('success', "Sebanyak {$count} siswa Lulus berhasil dipindahkan ke Tabel Alumni SMA 5.");
    }

    /**
     * Pulihkan status siswa dari alumni kembali aktif.
     */
    public function unarchive($id)
    {
        $grad = Graduation::findOrFail($id);
        $grad->update([
            'is_archived' => false,
            'archived_at' => null,
            'status'      => 'Pending',
        ]);

        $user = null;
        if ($grad->user_id) {
            $user = User::find($grad->user_id);
        }
        if (!$user) {
            $user = User::where('role', 'student')
                ->where(function ($q) use ($grad) {
                    $q->where('nis', $grad->nisn)
                      ->orWhere('name', $grad->name);
                })->first();
        }

        if ($user) {
            $user->update([
                'is_graduated' => false,
                'graduated_at' => null,
                'class_id'     => $user->previous_class_id ?: $user->class_id,
            ]);
        }

        return redirect()->back()->with('success', "Status alumni {$grad->name} berhasil dipulihkan menjadi siswa aktif kembali.");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'         => 'required|string|unique:graduations,nisn',
            'name'         => 'required|string',
            'status'       => 'required|in:Lulus,Tidak Lulus,Pending',
            'angkatan'     => 'nullable|string|max:10',
            'class_name'   => 'nullable|string|max:50',
            'tahun_ajaran' => 'nullable|string|max:20',
        ]);

        $status = $request->status;
        $isArchived = ($status === 'Lulus');
        $now = $isArchived ? now() : null;

        $grad = Graduation::create([
            'nisn'         => $request->nisn,
            'name'         => $request->name,
            'status'       => $status,
            'angkatan'     => $request->angkatan ?: date('Y'),
            'class_name'   => $request->class_name ?: 'Kelas XII',
            'tahun_ajaran' => $request->tahun_ajaran ?: (date('Y')-1) . '/' . date('Y'),
            'is_archived'  => $isArchived,
            'archived_at'  => $now,
        ]);

        // Cek jika siswa terdaftar di users
        $user = User::where('role', 'student')
            ->where(function ($q) use ($grad) {
                $q->where('nis', $grad->nisn)->orWhere('name', $grad->name);
            })->first();

        if ($user) {
            $grad->update(['user_id' => $user->id]);
            if ($isArchived) {
                $user->update([
                    'is_graduated'      => true,
                    'graduated_at'      => $now,
                    'angkatan'          => $grad->angkatan,
                    'previous_class_id' => $user->class_id ?: $user->previous_class_id,
                    'class_id'          => null,
                ]);
            }
        }

        return redirect()->route('admin.kelulusan.index')->with('success', 'Data kelulusan siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kelulusan = Graduation::findOrFail($id);
        $request->validate([
            'nisn'         => 'required|string|unique:graduations,nisn,' . $kelulusan->id,
            'name'         => 'required|string',
            'status'       => 'required|in:Lulus,Tidak Lulus,Pending',
            'angkatan'     => 'nullable|string|max:10',
            'class_name'   => 'nullable|string|max:50',
            'tahun_ajaran' => 'nullable|string|max:20',
        ]);

        $status = $request->status;
        $isArchived = ($status === 'Lulus');
        $now = $isArchived ? now() : null;

        $kelulusan->update([
            'nisn'         => $request->nisn,
            'name'         => $request->name,
            'status'       => $status,
            'angkatan'     => $request->angkatan ?: $kelulusan->angkatan,
            'class_name'   => $request->class_name ?: $kelulusan->class_name,
            'tahun_ajaran' => $request->tahun_ajaran ?: $kelulusan->tahun_ajaran,
            'is_archived'  => $isArchived,
            'archived_at'  => $now,
        ]);

        $user = $kelulusan->user ?: User::where('role', 'student')
            ->where(function ($q) use ($kelulusan) {
                $q->where('nis', $kelulusan->nisn)->orWhere('name', $kelulusan->name);
            })->first();

        if ($user) {
            if ($isArchived) {
                $user->update([
                    'is_graduated'      => true,
                    'graduated_at'      => $now,
                    'angkatan'          => $kelulusan->angkatan,
                    'previous_class_id' => $user->class_id ?: $user->previous_class_id,
                    'class_id'          => null,
                ]);
            } else {
                $user->update([
                    'is_graduated' => false,
                    'graduated_at' => null,
                    'class_id'     => $user->previous_class_id ?: $user->class_id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data kelulusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelulusan = Graduation::findOrFail($id);
        $kelulusan->delete();

        return redirect()->back()->with('success', 'Data kelulusan berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $query = Graduation::active();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        $graduations = $query->get();

        $data = $graduations->map(function ($g) {
            return [
                'NISN / NIS'       => $g->nisn,
                'Nama Siswa'       => $g->name,
                'Kelas'            => $g->class_name ?? '-',
                'Angkatan'         => $g->angkatan ?? '-',
                'Status Kelulusan' => $g->status,
                'Tahun Ajaran'     => $g->tahun_ajaran ?? '-',
                'Tanggal Proses'   => $g->created_at ? $g->created_at->format('d-m-Y H:i') : '-',
            ];
        })->toArray();

        return Excel::download(new GraduationExport($data), 'Data_Evaluasi_Kelulusan_Siswa.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Graduation::active();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        $graduations = $query->get();
        $kepsek = User::where('role', 'kepala_sekolah')->first();

        $pdf = Pdf::loadView('admin.kelulusan.pdf', [
            'graduations' => $graduations,
            'title'       => 'Daftar Evaluasi Kelulusan Siswa',
            'subtitle'    => 'Pengumuman Status Kelulusan Tingkat Akhir',
            'kepsek'      => $kepsek,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Data_Evaluasi_Kelulusan_Siswa.pdf');
    }

    public function exportArsipExcel(Request $request)
    {
        $query = Graduation::archived();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        $graduations = $query->get();

        $data = $graduations->map(function ($g) {
            return [
                'NISN / NIS'          => $g->nisn,
                'Nama Siswa (Alumni)' => $g->name,
                'Kelas Asal'          => $g->class_name ?? '-',
                'Angkatan'            => $g->angkatan ?? '-',
                'Tahun Ajaran'        => $g->tahun_ajaran ?? '-',
                'Status'              => 'Lulus (Alumni)',
                'Tanggal Kelulusan'   => $g->archived_at ? $g->archived_at->format('d-m-Y H:i') : ($g->created_at ? $g->created_at->format('d-m-Y') : '-'),
            ];
        })->toArray();

        $filename = 'Tabel_Alumni_SMA5';
        if ($request->filled('angkatan')) {
            $filename .= '_Angkatan_' . $request->angkatan;
        }
        $filename .= '.xlsx';

        return Excel::download(new GraduationExport($data), $filename);
    }

    public function exportArsipPdf(Request $request)
    {
        $query = Graduation::archived();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        $graduations = $query->get();
        $kepsek = User::where('role', 'kepala_sekolah')->first();

        $sub = 'Daftar Alumni SMA Negeri 5 Pulau Morotai';
        if ($request->filled('angkatan')) {
            $sub .= ' &bull; Angkatan ' . $request->angkatan;
        }

        $pdf = Pdf::loadView('admin.kelulusan.pdf', [
            'graduations' => $graduations,
            'title'       => 'Buku Induk Alumni SMA Negeri 5 Pulau Morotai',
            'subtitle'    => $sub,
            'kepsek'      => $kepsek,
        ])->setPaper('a4', 'portrait');

        $filename = 'Tabel_Alumni_SMA5';
        if ($request->filled('angkatan')) {
            $filename .= '_Angkatan_' . $request->angkatan;
        }
        $filename .= '.pdf';

        return $pdf->download($filename);
    }
}
