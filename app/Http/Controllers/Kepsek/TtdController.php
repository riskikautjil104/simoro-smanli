<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TtdController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('kepsek.ttd', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'ttd_signature' => 'required|string',
        ]);

        $user = Auth::user();
        $user->ttd_signature = $request->ttd_signature;
        $user->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Tanda tangan digital Kepala Sekolah berhasil disimpan!']);
        }

        return redirect()->back()->with('success', 'Tanda tangan digital Kepala Sekolah berhasil disimpan!');
    }
}
