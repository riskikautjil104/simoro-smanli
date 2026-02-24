<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller

{
    /**
     * Return all classes as JSON for AJAX.
     */
    public function list()
    {
        return response()->json(\App\Models\SchoolClass::with(['students', 'subjects.teacher'])->get());
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->expectsJson() || request()->wantsJson()) {
            $kelas = \App\Models\SchoolClass::with(['students', 'subjects.teacher'])->get();
            return response()->json($kelas);
        }
        return view('admin.kelas');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $kelas = \App\Models\SchoolClass::create([
            'name' => $validated['nama'],
        ]);
        return response()->json($kelas);
    }

    public function show($id)
    {
        $kelas = \App\Models\SchoolClass::findOrFail($id);
        return response()->json($kelas);
    }

    public function update(Request $request, $id)
    {
        $kelas = \App\Models\SchoolClass::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $kelas->update([
            'name' => $validated['nama'],
        ]);
        return response()->json($kelas);
    }

    public function destroy($id)
    {
        $kelas = \App\Models\SchoolClass::findOrFail($id);
        $kelas->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}
