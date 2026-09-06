<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Return all classes as JSON for AJAX.
     */
    public function list()
    {
        return response()->json(
            SchoolClass::with(['students', 'subjects.teacher', 'waliKelas'])
                ->orderBy('name')
                ->get()
        );
    }

    /**
     * Return list of teachers for dropdown.
     */
    public function teachers()
    {
        return response()->json(
            User::whereIn('role', ['teacher', 'guru'])
                ->orderBy('name')
                ->get(['id', 'name', 'nip'])
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->expectsJson() || request()->wantsJson()) {
            $kelas = SchoolClass::with(['students', 'subjects.teacher', 'waliKelas'])
                ->orderBy('name')
                ->get();
            return response()->json($kelas);
        }
        $teachers = User::whereIn('role', ['teacher', 'guru'])->orderBy('name')->get(['id', 'name', 'nip']);
        return view('admin.kelas', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $kelas = SchoolClass::create([
            'name' => $validated['nama'],
            'wali_kelas_id' => $validated['wali_kelas_id'] ?? null,
        ]);

        return response()->json($kelas->load('waliKelas'));
    }

    public function show($id)
    {
        $kelas = SchoolClass::with(['students', 'subjects.teacher', 'waliKelas'])->findOrFail($id);
        return response()->json($kelas);
    }

    public function update(Request $request, $id)
    {
        $kelas = SchoolClass::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $kelas->update([
            'name' => $validated['nama'],
            'wali_kelas_id' => $validated['wali_kelas_id'] ?? null,
        ]);

        return response()->json($kelas->load('waliKelas'));
    }

    public function destroy($id)
    {
        $kelas = SchoolClass::findOrFail($id);
        $kelas->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Get school-wide default rapor weights, KKM, tahun ajaran, and semester
     */
    public function getRaporSettings()
    {
        return response()->json([
            'tahun_ajaran' => \App\Models\MobileConfig::get('rapor_tahun_ajaran_default', '2025/2026'),
            'semester'     => \App\Models\MobileConfig::get('rapor_semester_default', 'Ganjil'),
            'weight_tugas' => (int) \App\Models\MobileConfig::get('rapor_weight_tugas', 40),
            'weight_cbt'   => (int) \App\Models\MobileConfig::get('rapor_weight_cbt', 60),
            'kkm'          => (int) \App\Models\MobileConfig::get('rapor_kkm_default', 75),
        ]);
    }

    /**
     * Save school-wide default rapor weights, KKM, tahun ajaran, and semester
     */
    public function saveRaporSettings(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'nullable|string|max:20',
            'semester'     => 'nullable|string|in:Ganjil,Genap',
            'weight_tugas' => 'required|numeric|min:0|max:100',
            'weight_cbt'   => 'required|numeric|min:0|max:100',
            'kkm'          => 'required|numeric|min:0|max:100',
        ]);

        if (!empty($validated['tahun_ajaran'])) {
            \App\Models\MobileConfig::set('rapor_tahun_ajaran_default', $validated['tahun_ajaran'], 'rapor', 'string', 'Tahun Ajaran Aktif Sekolah');
        }
        if (!empty($validated['semester'])) {
            \App\Models\MobileConfig::set('rapor_semester_default', $validated['semester'], 'rapor', 'string', 'Semester Aktif Sekolah');
        }
        \App\Models\MobileConfig::set('rapor_weight_tugas', (int) $validated['weight_tugas'], 'rapor', 'integer', 'Bobot Nilai Tugas Default (%)');
        \App\Models\MobileConfig::set('rapor_weight_cbt', (int) $validated['weight_cbt'], 'rapor', 'integer', 'Bobot Nilai CBT Default (%)');
        \App\Models\MobileConfig::set('rapor_kkm_default', (int) $validated['kkm'], 'rapor', 'integer', 'Standar KKM Default Sekolah');

        return response()->json([
            'success' => true,
            'message' => 'Standar Pengaturan Rapor & Semester Sekolah berhasil disimpan.',
            'data'    => [
                'tahun_ajaran' => $validated['tahun_ajaran'] ?? '2025/2026',
                'semester'     => $validated['semester'] ?? 'Ganjil',
                'weight_tugas' => (int) $validated['weight_tugas'],
                'weight_cbt'   => (int) $validated['weight_cbt'],
                'kkm'          => (int) $validated['kkm'],
            ],
        ]);
    }
}
