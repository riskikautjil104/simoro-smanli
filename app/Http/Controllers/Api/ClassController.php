<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of classes.
     * GET /api/kelas
     */
    public function index(Request $request)
    {
        $query = SchoolClass::withCount(['students', 'subjects']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $classes = $query->orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kelas berhasil diambil',
            'data'    => $classes
        ]);
    }

    /**
     * Store a newly created class.
     * POST /api/kelas
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:classes,name',
        ], [
            'name.required' => 'Nama kelas wajib diisi',
            'name.unique'   => 'Nama kelas sudah ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $class = SchoolClass::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan',
            'data'    => $class
        ], 201);
    }

    /**
     * Display the specified class with students and subjects.
     * GET /api/kelas/{id}
     */
    public function show(string $id)
    {
        $class = SchoolClass::with(['students' => function ($q) {
            $q->select('id', 'name', 'email', 'nis', 'class_id', 'phone', 'is_graduated', 'angkatan')
              ->where('role', 'student')
              ->where('is_graduated', false)
              ->orderBy('name', 'asc');
        }, 'subjects.teacher'])->find($id);

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kelas berhasil diambil',
            'data'    => $class
        ]);
    }

    /**
     * Update the specified class.
     * PUT/PATCH /api/kelas/{id}
     */
    public function update(Request $request, string $id)
    {
        $class = SchoolClass::find($id);

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:classes,name,' . $id,
        ], [
            'name.required' => 'Nama kelas wajib diisi',
            'name.unique'   => 'Nama kelas sudah ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $class->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diperbarui',
            'data'    => $class
        ]);
    }

    /**
     * Remove the specified class.
     * DELETE /api/kelas/{id}
     */
    public function destroy(string $id)
    {
        $class = SchoolClass::find($id);

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        // Cek jika ada siswa aktif di kelas
        if ($class->students()->where('is_graduated', false)->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak dapat dihapus karena masih memiliki siswa aktif'
            ], 422);
        }

        $class->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus'
        ]);
    }
}
