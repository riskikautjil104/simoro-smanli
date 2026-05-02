<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Graduation;

class PengumumanController extends Controller
{
    public function index()
    {
        // Tanggal rilis pengumuman
        $releaseDate = '2026-05-04 10:00:00';
        return view('frontend.pengumuman', compact('releaseDate'));
    }

    public function cek(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
        ]);

        $releaseDate = '2026-05-04 10:00:00';
        if (now()->format('Y-m-d H:i:s') < $releaseDate) {
            return back()->with('error', 'Pengumuman kelulusan belum dibuka!');
        }

        $graduation = Graduation::where('nisn', $request->nisn)->first();

        if (!$graduation) {
            return back()->with('error', 'Data siswa dengan NISN tersebut tidak ditemukan.');
        }

        return back()->with('result', $graduation);
    }
}
