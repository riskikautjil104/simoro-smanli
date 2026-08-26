<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of all user accounts.
     * GET /api/users or GET /api/akun
     */
    public function index(Request $request)
    {
        $query = User::with(['class:id,name', 'previousClass:id,name', 'subjects:id,name,code,teacher_id']);

        // Filter role (admin, teacher, student, kepala_sekolah, mobile)
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Filter kelas (untuk siswa)
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter status kelulusan
        if ($request->filled('is_graduated')) {
            $query->where('is_graduated', $request->boolean('is_graduated'));
        }

        // Filter pencarian nama, email, nip, nis, nik, no hp
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $query->orderBy('role', 'asc')->orderBy('name', 'asc');

        if ($request->boolean('paginate', false)) {
            $users = $query->paginate($request->input('per_page', 20));
        } else {
            $users = $query->get();
        }

        $usersFormatted = $users->map(function ($u) {
            return [
                'id'                => $u->id,
                'name'              => $u->name,
                'email'             => $u->email,
                'role'              => $u->role,
                'role_label'        => match($u->role) {
                    'admin'          => 'Administrator',
                    'teacher'        => 'Guru Pengampu',
                    'student'        => 'Siswa',
                    'kepala_sekolah' => 'Kepala Sekolah',
                    'mobile'         => 'Mobile Manager',
                    default          => ucfirst($u->role),
                },
                'nip'               => $u->nip ?? '-',
                'nis'               => $u->nis ?? '-',
                'nik'               => $u->nik ?? '-',
                'phone'             => $u->phone ?? '-',
                'class_id'          => $u->class_id,
                'class_name'        => $u->class?->name ?? ($u->previousClass ? $u->previousClass->name . ' (Alumni)' : '-'),
                'angkatan'          => $u->angkatan,
                'is_graduated'      => (bool)$u->is_graduated,
                'has_signature'     => !empty($u->ttd_signature),
                'subjects'          => $u->subjects->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'code' => $s->code]),
                'email_verified_at' => $u->email_verified_at ? $u->email_verified_at->format('d-m-Y H:i') : null,
                'created_at'        => $u->created_at ? $u->created_at->format('d-m-Y H:i') : null,
            ];
        });

        // Summary counts by role
        $counts = [
            'total'          => User::count(),
            'admin'          => User::where('role', 'admin')->count(),
            'teacher'        => User::where('role', 'teacher')->count(),
            'student'        => User::where('role', 'student')->where('is_graduated', false)->count(),
            'alumni'         => User::where('role', 'student')->where('is_graduated', true)->count(),
            'kepala_sekolah' => User::where('role', 'kepala_sekolah')->count(),
            'mobile'         => User::where('role', 'mobile')->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Daftar seluruh akun pengguna berhasil diambil',
            'counts'  => $counts,
            'data'    => $usersFormatted
        ]);
    }

    /**
     * Display the specified user account.
     * GET /api/users/{id} or GET /api/akun/{id}
     */
    public function show(string $id)
    {
        $user = User::with(['class:id,name', 'previousClass:id,name', 'subjects:id,name,code,teacher_id'])->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Akun pengguna tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail akun pengguna berhasil diambil',
            'data'    => [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'role'              => $user->role,
                'role_label'        => match($user->role) {
                    'admin'          => 'Administrator',
                    'teacher'        => 'Guru Pengampu',
                    'student'        => 'Siswa',
                    'kepala_sekolah' => 'Kepala Sekolah',
                    'mobile'         => 'Mobile Manager',
                    default          => ucfirst($user->role),
                },
                'nip'               => $user->nip,
                'nis'               => $user->nis,
                'nik'               => $user->nik,
                'phone'             => $user->phone,
                'class_id'          => $user->class_id,
                'class_name'        => $user->class?->name,
                'previous_class'    => $user->previousClass?->name,
                'angkatan'          => $user->angkatan,
                'is_graduated'      => (bool)$user->is_graduated,
                'has_signature'     => !empty($user->ttd_signature),
                'ttd_signature'     => $user->ttd_signature,
                'subjects'          => $user->subjects,
                'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->format('d-m-Y H:i') : null,
                'created_at'        => $user->created_at ? $user->created_at->format('d-m-Y H:i') : null,
            ]
        ]);
    }

    /**
     * Store a newly created user account.
     * POST /api/users or POST /api/akun
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:users,email',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:admin,teacher,student,kepala_sekolah,mobile',
            'nip'          => 'nullable|string|max:50|unique:users,nip',
            'nis'          => 'nullable|string|max:50|unique:users,nis',
            'nik'          => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'class_id'     => 'nullable|exists:classes,id',
            'angkatan'     => 'nullable|string|max:50',
            'is_graduated' => 'nullable|boolean',
        ], [
            'name.required'     => 'Nama pengguna wajib diisi',
            'email.required'    => 'Email wajib diisi',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'role.required'     => 'Pilih role akun pengguna',
            'role.in'           => 'Role yang diperbolehkan: admin, teacher, student, kepala_sekolah, mobile',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'nip'               => $request->nip,
            'nis'               => $request->nis,
            'nik'               => $request->nik,
            'phone'             => $request->phone,
            'class_id'          => $request->class_id,
            'angkatan'          => $request->angkatan,
            'is_graduated'      => $request->boolean('is_graduated', false),
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun pengguna berhasil dibuat',
            'data'    => $user
        ], 201);
    }

    /**
     * Update user account.
     * PUT/PATCH /api/users/{id} or PUT/PATCH /api/akun/{id}
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Akun pengguna tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'         => 'sometimes|string|max:255',
            'email'        => 'sometimes|email|max:255|unique:users,email,' . $id,
            'password'     => 'nullable|string|min:6',
            'role'         => 'sometimes|in:admin,teacher,student,kepala_sekolah,mobile',
            'nip'          => 'nullable|string|max:50|unique:users,nip,' . $id,
            'nis'          => 'nullable|string|max:50|unique:users,nis,' . $id,
            'nik'          => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'class_id'     => 'nullable|exists:classes,id',
            'angkatan'     => 'nullable|string|max:50',
            'is_graduated' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $request->only(['name', 'email', 'role', 'nip', 'nis', 'nik', 'phone', 'class_id', 'angkatan', 'is_graduated']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data akun pengguna berhasil diperbarui',
            'data'    => $user
        ]);
    }

    /**
     * Reset password for any user account.
     * POST /api/users/{id}/reset-password or POST /api/akun/{id}/reset-password
     */
    public function resetPassword(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Akun pengguna tidak ditemukan'
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

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password akun berhasil direset',
            'data'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ]
        ]);
    }

    /**
     * Delete user account.
     * DELETE /api/users/{id} or DELETE /api/akun/{id}
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Akun pengguna tidak ditemukan'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Akun pengguna berhasil dihapus'
        ]);
    }
}
