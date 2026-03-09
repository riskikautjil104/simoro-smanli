<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('teacher')->get();

        return response()->json([
            'success' => true,
            'data' => $subjects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $subject = Subject::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dibuat',
            'data' => $subject
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::with('teacher', 'classes', 'exams')->find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|max:50|unique:subjects,code,' . $id,
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $subject->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil diperbarui',
            'data' => $subject
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan'
            ], 404);
        }

        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dihapus'
        ]);
    }
}
