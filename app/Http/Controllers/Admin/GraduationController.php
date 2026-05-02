<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graduation;
use Illuminate\Http\Request;

class GraduationController extends Controller
{
    public function index(Request $request)
    {
        $query = Graduation::query();

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

        return view('admin.kelulusan.index', compact('graduations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|unique:graduations,nisn',
            'name' => 'required|string',
            'status' => 'required|in:Lulus,Tidak Lulus',
        ]);

        Graduation::create($request->all());

        return redirect()->route('admin.kelulusan.index')->with('success', 'Data kelulusan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kelulusan = Graduation::findOrFail($id);
        $request->validate([
            'nisn' => 'required|string|unique:graduations,nisn,' . $kelulusan->id,
            'name' => 'required|string',
            'status' => 'required|in:Lulus,Tidak Lulus',
        ]);

        $kelulusan->update($request->all());

        return redirect()->route('admin.kelulusan.index')->with('success', 'Data kelulusan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kelulusan = Graduation::findOrFail($id);
        $kelulusan->delete();

        return redirect()->route('admin.kelulusan.index')->with('success', 'Data kelulusan berhasil dihapus');
    }

    public function exportExcel(Request $request)
    {
        $query = Graduation::query();

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

        $graduations = $query->get();

        $data = $graduations->map(function ($g) {
            return [
                'NISN' => $g->nisn,
                'Nama Siswa' => $g->name,
                'Status Kelulusan' => $g->status,
                'Tanggal Dibuat' => $g->created_at ? $g->created_at->format('d-m-Y H:i') : '-',
            ];
        });

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\GraduationExport($data), 'Data_Kelulusan_Siswa.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Graduation::query();

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

        $graduations = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.kelulusan.pdf', compact('graduations'));
        return $pdf->download('Data_Kelulusan_Siswa.pdf');
    }
}
