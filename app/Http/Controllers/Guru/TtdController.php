<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TtdController extends Controller
{
    // Tampilkan form/canvas ttd (opsional, jika pakai blade)
    public function edit()
    {
        $user = Auth::user();
        return view('guru.ttd', [
            'ttd_signature' => $user->ttd_signature,
        ]);
    }

    // Simpan ttd_signature ke database
    public function update(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'ttd_signature' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'TTD tidak valid'], 422);
        }
        $user->ttd_signature = $request->ttd_signature;
        $user->save();
        return response()->json(['message' => 'TTD berhasil disimpan']);
    }
}
