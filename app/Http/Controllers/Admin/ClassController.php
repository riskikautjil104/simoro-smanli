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
}
