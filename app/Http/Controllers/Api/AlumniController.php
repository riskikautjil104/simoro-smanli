<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Graduation;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlumniController extends Controller
{
    /**
     * Display a listing of alumni students.
     * GET /api/alumni
     */
    public function index(Request $request)
    {
        // Query siswa yang statusnya alumni / lulus
        $query = User::where('role', 'student')
            ->where('is_graduated', true)
            ->with(['previousClass:id,name', 'class:id,name']);

        // Filter angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Filter kelas asal
        if ($request->filled('class_id')) {
            $classId = $request->class_id;
            $query->where(function ($q) use ($classId) {
                $q->where('class_id', $classId)
                  ->orWhere('previous_class_id', $classId);
            });
        }

        // Pencarian nama, nis, nik, email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $query->orderBy('angkatan', 'desc')->orderBy('name', 'asc');

        if ($request->boolean('paginate', false)) {
            $perPage = $request->input('per_page', 20);
            $alumni = $query->paginate($perPage);
        } else {
            $alumni = $query->get();
        }

        // Ambil daftar pilihan angkatan unik yang tersedia untuk filter dropdown
        $availableAngkatan = User::where('role', 'student')
            ->where('is_graduated', true)
            ->whereNotNull('angkatan')
            ->distinct()
            ->pluck('angkatan');

        return response()->json([
            'success' => true,
            'message' => 'Daftar data alumni berhasil diambil',
            'available_angkatan' => $availableAngkatan,
            'data'    => $alumni
        ]);
    }

    /**
     * Display the specified alumni.
     * GET /api/alumni/{id}
     */
    public function show(string $id)
    {
        $alumnus = User::where('role', 'student')
            ->where('is_graduated', true)
            ->with(['previousClass:id,name', 'class:id,name'])
            ->find($id);

        if (!$alumnus) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan'
            ], 404);
        }

        // Data kelulusan dari tabel graduation jika ada
        $graduationRecord = Graduation::where('user_id', $alumnus->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Detail data alumni berhasil diambil',
            'data'    => [
                'alumni'     => $alumnus,
                'kelulusan'  => $graduationRecord,
            ]
        ]);
    }

    /**
     * Mark a student as graduated / Create alumni record.
     * POST /api/alumni
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required|exists:users,id',
            'angkatan'     => 'required|string|max:50',
            'tahun_ajaran' => 'nullable|string|max:50',
            'status'       => 'nullable|string|max:50',
        ], [
            'user_id.required'  => 'Pilih siswa yang akan dijadikan alumni',
            'angkatan.required' => 'Tahun angkatan wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $student = User::where('role', 'student')->find($request->user_id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $student->update([
            'is_graduated'      => true,
            'graduated_at'      => now(),
            'angkatan'          => $request->angkatan,
            'previous_class_id' => $student->class_id ?? $student->previous_class_id,
            'class_id'          => null, // Lepaskan dari kelas aktif
        ]);

        $className = $student->previousClass?->name ?? '-';

        // Update or create in graduations table
        $graduation = Graduation::updateOrCreate(
            ['user_id' => $student->id],
            [
                'nisn'         => $student->nis,
                'name'         => $student->name,
                'status'       => $request->status ?? 'LULUS',
                'angkatan'     => $request->angkatan,
                'class_name'   => $className,
                'tahun_ajaran' => $request->tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1),
                'is_archived'  => false,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status kelulusan siswa berhasil diperbarui menjadi Alumni',
            'data'    => [
                'alumni'     => $student->fresh(['previousClass']),
                'graduation' => $graduation
            ]
        ], 201);
    }

    /**
     * Update alumni data.
     * PUT/PATCH /api/alumni/{id}
     */
    public function update(Request $request, string $id)
    {
        $alumnus = User::where('role', 'student')
            ->where('is_graduated', true)
            ->find($id);

        if (!$alumnus) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'         => 'sometimes|string|max:255',
            'email'        => 'sometimes|email|unique:users,email,' . $id,
            'nis'          => 'sometimes|string|unique:users,nis,' . $id,
            'nik'          => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'angkatan'     => 'sometimes|string|max:50',
            'is_graduated' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $alumnus->update($request->only(['name', 'email', 'nis', 'nik', 'phone', 'angkatan', 'is_graduated']));

        // Update graduation record if exists
        $grad = Graduation::where('user_id', $alumnus->id)->first();
        if ($grad) {
            if ($request->filled('name')) $grad->name = $request->name;
            if ($request->filled('nis')) $grad->nisn = $request->nis;
            if ($request->filled('angkatan')) $grad->angkatan = $request->angkatan;
            $grad->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data alumni berhasil diperbarui',
            'data'    => $alumnus->fresh(['previousClass'])
        ]);
    }

    /**
     * Remove alumni or restore to active student.
     * DELETE /api/alumni/{id}
     */
    public function destroy(Request $request, string $id)
    {
        $alumnus = User::where('role', 'student')
            ->where('is_graduated', true)
            ->find($id);

        if (!$alumnus) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan'
            ], 404);
        }

        // Jika request memiliki flag restore, kembalikan ke siswa aktif
        if ($request->boolean('restore', false)) {
            $alumnus->update([
                'is_graduated' => false,
                'graduated_at' => null,
                'class_id'     => $alumnus->previous_class_id,
            ]);

            Graduation::where('user_id', $alumnus->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Alumni berhasil dikembalikan menjadi siswa aktif'
            ]);
        }

        // Hapus rekaman
        Graduation::where('user_id', $alumnus->id)->delete();
        $alumnus->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data alumni berhasil dihapus'
        ]);
    }
}
