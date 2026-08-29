<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login khusus Siswa (bisa menggunakan Email atau NIS).
     * POST /api/siswa/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required_without:email|string',
            'email'    => 'required_without:login|string',
            'password' => 'required|string',
        ]);

        $loginIdentifier = $request->input('login') ?: $request->input('email');

        // Cari user berdasarkan email atau NIS
        $user = User::where(function ($q) use ($loginIdentifier) {
            $q->where('email', $loginIdentifier)
              ->orWhere('nis', $loginIdentifier);
        })->with('class')->first();

        // Validasi keberadaan user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email/NIS atau kata sandi yang Anda masukkan salah.',
            ], 401);
        }

        // Pastikan role adalah siswa
        if ($user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Endpoint ini khusus untuk akun Siswa.',
            ], 403);
        }

        // Cek status kelulusan / alumni
        if ($user->is_graduated) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda telah dinonaktifkan karena Anda sudah dinyatakan Lulus / Alumni SMA Negeri 5 Pulau Morotai.',
            ], 403);
        }

        // Buat token Sanctum
        $token = $user->createToken('siswa-mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil. Selamat datang, ' . $user->name,
            'data'    => [
                'token'      => $token,
                'token_type' => 'Bearer',
                'user'       => [
                    'id'           => $user->id,
                    'name'         => $user->name,
                    'email'        => $user->email,
                    'nis'          => $user->nis,
                    'agama'        => $user->agama,
                    'phone'        => $user->phone,
                    'role'         => $user->role,
                    'class_id'     => $user->class_id,
                    'class_name'   => $user->class?->name,
                    'angkatan'     => $user->angkatan,
                    'ttd_signature'=> $user->ttd_signature,
                    'is_graduated' => (bool)$user->is_graduated,
                    'created_at'   => $user->created_at?->toISOString(),
                ]
            ]
        ], 200);
    }

    /**
     * Ambil detail profil siswa yang sedang login.
     * GET /api/siswa/profile atau GET /api/siswa/me
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load('class');

        return response()->json([
            'success' => true,
            'message' => 'Data profil siswa berhasil diambil.',
            'data'    => [
                'id'           => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'nis'          => $user->nis,
                'agama'        => $user->agama,
                'phone'        => $user->phone,
                'role'         => $user->role,
                'class_id'     => $user->class_id,
                'class_name'   => $user->class?->name,
                'angkatan'     => $user->angkatan,
                'ttd_signature'=> $user->ttd_signature,
                'is_graduated' => (bool)$user->is_graduated,
                'created_at'   => $user->created_at?->toISOString(),
            ]
        ], 200);
    }

    /**
     * Update profil siswa (Nama, Email, No Telepon, Agama, TTD, atau Password).
     * PUT /api/siswa/profile atau POST /api/siswa/profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'             => 'sometimes|string|max:255',
            'email'            => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'agama'            => 'sometimes|nullable|string|max:50',
            'phone'            => 'sometimes|nullable|string|max:20',
            'ttd_signature'    => 'sometimes|nullable|string',
            'current_password' => 'sometimes|nullable|string',
            'new_password'     => 'sometimes|nullable|string|min:6',
        ]);

        // Jika user ingin mengganti password sekaligus
        if (!empty($validated['new_password'])) {
            if (empty($validated['current_password'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi saat ini (current_password) wajib diisi untuk mengganti kata sandi.',
                ], 422);
            }

            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi saat ini tidak sesuai.',
                ], 422);
            }

            $user->password = Hash::make($validated['new_password']);
        }

        if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }
        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }
        if (array_key_exists('agama', $validated)) {
            $user->agama = $validated['agama'];
        }
        if (array_key_exists('phone', $validated)) {
            $user->phone = $validated['phone'];
        }
        if (array_key_exists('ttd_signature', $validated)) {
            $user->ttd_signature = $validated['ttd_signature'];
        }

        $user->save();
        $user->load('class');

        return response()->json([
            'success' => true,
            'message' => 'Profil siswa berhasil diperbarui.',
            'data'    => [
                'id'           => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'nis'          => $user->nis,
                'phone'        => $user->phone,
                'role'         => $user->role,
                'class_id'     => $user->class_id,
                'class_name'   => $user->class?->name,
                'angkatan'     => $user->angkatan,
                'ttd_signature'=> $user->ttd_signature,
                'is_graduated' => (bool)$user->is_graduated,
                'updated_at'   => $user->updated_at?->toISOString(),
            ]
        ], 200);
    }

    /**
     * Endpoint khusus Ganti Kata Sandi Siswa.
     * POST /api/siswa/change-password atau PUT /api/siswa/password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi saat ini tidak sesuai.',
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diubah.',
        ], 200);
    }

    /**
     * Logout Siswa (Revoke Token Aktif).
     * POST /api/siswa/logout
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            // Hapus fcm_token agar notifikasi tidak terkirim setelah logout
            $user->update(['fcm_token' => null]);
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil. Sesi token telah dihapus.',
        ], 200);
    }

    // awal batas suci yang kamu ubah
    /**
     * Simpan / Update FCM Device Token Siswa.
     * POST /api/siswa/device-token
     * 
     * Dipanggil otomatis oleh aplikasi Flutter saat login berhasil.
     * Token ini digunakan server untuk mengirim push notification ke HP siswa.
     */
    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string|min:10',
        ]);

        $request->user()->update([
            'fcm_token' => $request->fcm_token,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FCM token berhasil disimpan.',
        ], 200);
    }
    // akhir batas suci yang kamu ubah
}
