<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     * GET /api/guru
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'teacher')
            ->with(['subjects'])
            ->withCount(['subjects']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $teachers = $query->orderBy('name', 'asc')->get()->map(function ($teacher) {
            return [
                'id'             => $teacher->id,
                'name'           => $teacher->name,
                'email'          => $teacher->email,
                'role'           => $teacher->role,
                'nip'            => $teacher->nip ?? '-',
                'nik'            => $teacher->nik ?? '-',
                'phone'          => $teacher->phone ?? '-',
                'has_signature'  => !empty($teacher->ttd_signature),
                'subjects_count' => $teacher->subjects_count,
                'subjects'       => $teacher->subjects->map(function ($s) {
                    return [
                        'id'   => $s->id,
                        'name' => $s->name,
                        'code' => $s->code,
                    ];
                }),
                'created_at'     => $teacher->created_at ? $teacher->created_at->format('d-m-Y H:i') : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar guru pengampu berhasil diambil',
            'data'    => $teachers
        ]);
    }

    /**
     * Store a newly created teacher.
     * POST /api/guru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'nip'      => 'nullable|string|max:50|unique:users,nip',
            'nik'      => 'nullable|string|max:50',
            'phone'    => 'nullable|string|max:20',
        ], [
            'name.required'     => 'Nama guru wajib diisi',
            'email.required'    => 'Email guru wajib diisi',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'nip.unique'        => 'NIP sudah terdaftar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $teacher = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'teacher',
            'nip'               => $request->nip,
            'nik'               => $request->nik,
            'phone'             => $request->phone,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil ditambahkan',
            'data'    => $teacher
        ], 201);
    }

    /**
     * Display the specified teacher.
     * GET /api/guru/{id}
     */
    public function show(string $id)
    {
        $teacher = User::where('role', 'teacher')
            ->with(['subjects.classes'])
            ->find($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data guru berhasil diambil',
            'data'    => [
                'id'            => $teacher->id,
                'name'          => $teacher->name,
                'email'         => $teacher->email,
                'role'          => $teacher->role,
                'nip'           => $teacher->nip ?? '-',
                'nik'           => $teacher->nik ?? '-',
                'phone'         => $teacher->phone ?? '-',
                'has_signature' => !empty($teacher->ttd_signature),
                'ttd_signature' => $teacher->ttd_signature,
                'subjects'      => $teacher->subjects->map(function ($s) {
                    return [
                        'id'      => $s->id,
                        'name'    => $s->name,
                        'code'    => $s->code,
                        'classes' => $s->classes->map(fn($c) => ['id' => $c->id, 'name' => $c->name]),
                    ];
                }),
                'created_at'    => $teacher->created_at ? $teacher->created_at->format('d-m-Y H:i') : null,
            ]
        ]);
    }

    /**
     * Update the specified teacher.
     * PUT/PATCH /api/guru/{id}
     */
    public function update(Request $request, string $id)
    {
        $teacher = User::where('role', 'teacher')->find($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'nip'      => 'nullable|string|max:50|unique:users,nip,' . $id,
            'nik'      => 'nullable|string|max:50',
            'phone'    => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'nip'   => $request->nip,
            'nik'   => $request->nik,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $teacher->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil diperbarui',
            'data'    => $teacher
        ]);
    }

    /**
     * Remove the specified teacher.
     * DELETE /api/guru/{id}
     */
    public function destroy(string $id)
    {
        $teacher = User::where('role', 'teacher')->find($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil dihapus'
        ]);
    }

    /**
     * Reset password for teacher account.
     * POST /api/guru/{id}/reset-password
     */
    public function resetPassword(Request $request, string $id)
    {
        $teacher = User::where('role', 'teacher')->find($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
        ], [
            'password.required' => 'Password baru wajib diisi',
            'password.min'      => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $teacher->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password akun guru berhasil direset',
            'data'    => [
                'id'    => $teacher->id,
                'name'  => $teacher->name,
                'email' => $teacher->email,
                'role'  => $teacher->role,
            ]
        ]);
    }
}

