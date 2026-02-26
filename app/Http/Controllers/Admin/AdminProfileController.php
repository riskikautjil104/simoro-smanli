<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function editTtd()
    {
        $user = Auth::user();
        return view('admin.ttd_admin', compact('user'));
    }

    public function updateTtd(Request $request)
    {
        $request->validate([
            'ttd_signature' => 'required|string',
        ]);
        $user = Auth::user();
        $user->ttd_signature = $request->ttd_signature;
        $user->save();
        return redirect()->back()->with('success', 'Tanda tangan digital berhasil disimpan!');
    }
}
