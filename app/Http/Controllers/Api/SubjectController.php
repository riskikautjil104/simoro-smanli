<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects.
     * GET /api/mapel
     */
    public function index(Request $request)
    {
        $query = Subject::with(['teacher:id,name,email,nip,phone', 'classes:id,name'])
            ->withCount(['exams', 'questions']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('class_id')) {
            $classId = $request->class_id;
            $query->whereHas('classes', function ($q) use ($classId) {
                $q->where('classes.id', $classId);
            });
        }

        $subjects = $query->orderBy('name', 'asc')->get()->map(function ($s) {
            return [
                'id'              => $s->id,
                'name'            => $s->name,
                'code'            => $s->code,
                'teacher_id'      => $s->teacher_id,
                'teacher_name'    => $s->teacher?->name ?? 'Belum ditentukan',
                'teacher_email'   => $s->teacher?->email ?? null,
                'classes'         => $s->classes->map(fn($c) => ['id' => $c->id, 'name' => $c->name]),
                'exams_count'     => $s->exams_count,
                'questions_count' => $s->questions_count,
                'created_at'      => $s->created_at ? $s->created_at->format('d-m-Y H:i') : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar mata pelajaran berhasil diambil',
            'data'    => $subjects
        ]);
    }

    /**
     * Store a newly created subject.
     * POST /api/mapel
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'code'       => 'required|string|max:50|unique:subjects,code',
            'teacher_id' => 'nullable|exists:users,id',
            'class_ids'  => 'nullable|array',
            'class_ids.*'=> 'exists:classes,id',
        ], [
            'name.required' => 'Nama mata pelajaran wajib diisi',
            'code.required' => 'Kode mapel wajib diisi',
            'code.unique'   => 'Kode mapel sudah terdaftar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $subject = Subject::create([
            'name'       => $request->name,
            'code'       => strtoupper($request->code),
            'teacher_id' => $request->teacher_id,
        ]);

        if ($request->has('class_ids')) {
            $subject->classes()->sync($request->class_ids);
        }

        $subject->load(['teacher', 'classes']);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil ditambahkan',
            'data'    => $subject
        ], 201);
    }

    /**
     * Display the specified subject.
     * GET /api/mapel/{id}
     */
    public function show(string $id)
    {
        $subject = Subject::with(['teacher', 'classes', 'exams' => function ($q) {
            $q->select('id', 'title', 'subject_id', 'duration', 'is_active', 'start_time', 'end_time');
        }])->withCount(['questions', 'exams'])->find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail mata pelajaran berhasil diambil',
            'data'    => [
                'id'              => $subject->id,
                'name'            => $subject->name,
                'code'            => $subject->code,
                'teacher'         => $subject->teacher ? [
                    'id'    => $subject->teacher->id,
                    'name'  => $subject->teacher->name,
                    'nip'   => $subject->teacher->nip,
                    'email' => $subject->teacher->email,
                    'phone' => $subject->teacher->phone,
                ] : null,
                'classes'         => $subject->classes->map(fn($c) => ['id' => $c->id, 'name' => $c->name]),
                'questions_count' => $subject->questions_count,
                'exams_count'     => $subject->exams_count,
                'exams'           => $subject->exams,
                'created_at'      => $subject->created_at ? $subject->created_at->format('d-m-Y H:i') : null,
            ]
        ]);
    }

    /**
     * Update the specified subject.
     * PUT/PATCH /api/mapel/{id}
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
            'name'       => 'sometimes|string|max:255',
            'code'       => 'sometimes|string|max:50|unique:subjects,code,' . $id,
            'teacher_id' => 'nullable|exists:users,id',
            'class_ids'  => 'nullable|array',
            'class_ids.*'=> 'exists:classes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $request->only(['name', 'teacher_id']);
        if ($request->filled('code')) {
            $data['code'] = strtoupper($request->code);
        }

        $subject->update($data);

        if ($request->has('class_ids')) {
            $subject->classes()->sync($request->class_ids);
        }

        $subject->load(['teacher', 'classes']);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil diperbarui',
            'data'    => $subject
        ]);
    }

    /**
     * Remove the specified subject.
     * DELETE /api/mapel/{id}
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

        $subject->classes()->detach();
        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dihapus'
        ]);
    }
}
