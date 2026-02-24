<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // AJAX: return JSON
        if (request()->expectsJson() || request()->wantsJson()) {
            $siswas = \App\Models\User::where('role', 'student')->with('class')->get()->map(function ($siswa) {
                return [
                    'id' => $siswa->id,
                    'nama' => $siswa->name,
                    'email' => $siswa->email,
                    'kelas_id' => $siswa->class_id,
                    'kelas' => $siswa->class ? ['id' => $siswa->class->id, 'nama' => $siswa->class->name] : null,
                    'nis' => $siswa->nis,
                    'phone' => $siswa->phone,
                ];
            });
            return response()->json($siswas);
        }
        // Otherwise, return view
        return view('admin.siswa');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'kelas_id' => 'required|integer|exists:classes,id',
            'nis' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:20',
        ]);
        $user = \App\Models\User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt('siswa123'),
            'role' => 'student',
            'class_id' => $validated['kelas_id'],
            'nis' => $validated['nis'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);
        return response()->json([
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'kelas_id' => $user->class_id,
            'kelas' => $user->class ? ['id' => $user->class->id, 'nama' => $user->class->name] : null,
            'nis' => $user->nis,
            'phone' => $user->phone,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = \App\Models\User::where('role', 'student')->with('class')->findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'kelas_id' => $user->class_id,
            'kelas' => $user->class ? ['id' => $user->class->id, 'nama' => $user->class->name] : null,
            'nis' => $user->nis,
            'phone' => $user->phone,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::where('role', 'student')->findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'kelas_id' => 'required|integer|exists:classes,id',
            'nis' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:20',
        ]);
        $user->update([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'class_id' => $validated['kelas_id'],
            'nis' => $validated['nis'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);
        return response()->json([
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'kelas_id' => $user->class_id,
            'kelas' => $user->class ? ['id' => $user->class->id, 'nama' => $user->class->name] : null,
            'nis' => $user->nis,
            'phone' => $user->phone,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = \App\Models\User::where('role', 'student')->findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }
}
