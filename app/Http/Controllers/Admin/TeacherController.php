<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller

    
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // If expects JSON (fetch/AJAX), return data
        if (request()->expectsJson() || request()->wantsJson()) {
            $gurus = \App\Models\User::where('role', 'teacher')
                ->with(['subjects.classes'])
                ->get();
            return response()->json($gurus);
        }
        // Otherwise, return the view
        return view('admin.guru');
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|max:30',
            'phone' => 'required|string|max:20',
        ]);
        $user = \App\Models\User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt('guru123'),
            'role' => 'teacher',
            'nip' => $validated['nip'],
            'phone' => $validated['phone'],
        ]);
        // Return same structure as index for frontend refresh
        return response()->json([
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'nip' => $user->nip,
            'phone' => $user->phone,
        ]);
    }

    public function show($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'required|string|max:30',
            'phone' => 'required|string|max:20',
        ]);
        $user->update([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'phone' => $validated['phone'],
        ]);
        // Return same structure as index for frontend refresh
        return response()->json([
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'nip' => $user->nip,
            'phone' => $user->phone,
        ]);
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}
