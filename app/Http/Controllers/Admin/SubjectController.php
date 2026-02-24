<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->expectsJson() || request()->wantsJson()) {
            $mapel = \App\Models\Subject::with(['teacher', 'classes'])->get();
            return response()->json($mapel);
        }
        return view('admin.mapel');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code',
            'teacher_id' => 'required|exists:users,id',
            'kelas_id' => 'required|array',
            'kelas_id.*' => 'exists:classes,id',
        ]);
        $mapel = \App\Models\Subject::create([
            'name' => $validated['nama'],
            'code' => $validated['code'],
            'teacher_id' => $validated['teacher_id'],
        ]);
        $mapel->classes()->sync($validated['kelas_id']);
        return response()->json($mapel->load(['teacher', 'classes']));
    }

    public function show($id)
    {
        $mapel = \App\Models\Subject::with(['teacher', 'classes'])->findOrFail($id);
        return response()->json($mapel);
    }

    public function update(Request $request, $id)
    {
        $mapel = \App\Models\Subject::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'kelas_id' => 'required|array',
            'kelas_id.*' => 'exists:classes,id',
        ]);
        $mapel->update([
            'name' => $validated['nama'],
            'teacher_id' => $validated['teacher_id'],
        ]);
        $mapel->classes()->sync($validated['kelas_id']);
        return response()->json($mapel->load(['teacher', 'classes']));
    }

    public function destroy($id)
    {
        $mapel = \App\Models\Subject::findOrFail($id);
        $mapel->delete();
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
