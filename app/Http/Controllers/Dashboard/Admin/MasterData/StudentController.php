<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Generation;
use App\Models\Grade;
use App\Models\Student;
use App\Models\ViolationData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = Student::with(['grade', 'generation']);
            return DataTables::eloquent($query)
                ->toJson(true);
        }

        $grades = Grade::all();
        $generations = Generation::all();
        return view('pages.dashboard.admin.master-data.student.index', ['grades' => $grades, 'generations' => $generations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:students,nisn|max:20|string',
            'name' => 'required|max:50|string',
            'gender' => 'required|in:laki-laki,perempuan|string',
            'grade_id' => 'required|exists:App\Models\Grade,id|numeric',
            'generation_id' => 'required|exists:App\Models\Generation,id|numeric'
        ]);

        $created = Student::create($request->only('nisn', 'grade_id', 'generation_id', 'name', 'gender'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menambah data siswa',
            'data' => $created,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Student $student)
    {
        if ($request->ajax())
        {
            $violations = ViolationData::with('student', 'violation', 'generation', 'grade', 'teacher')->where('student_id', $student->id);
            return DataTables::eloquent($violations)
                ->toJson(true);
        }
        return view('pages.dashboard.admin.master-data.student.detail', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'gender' => 'required|in:laki-laki,perempuan|string',
            'grade_id' => 'required|exists:App\Models\Grade,id|numeric',
            'generation_id' => 'required|exists:App\Models\Generation,id|numeric'
        ]);

        if ($student->nisn !== $request->nisn) {
            $request->validate(['nisn' => 'required|unique:students,nisn|max:20|string']);
        }

        $updated = $student->update($request->only('nisn', 'grade_id', 'generation_id', 'name', 'gender'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data siswa',
            'data' => $student,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrfail($id);
        $student->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data siswa',
        ]);
    }

    /**
     * Get view import data student
     */
    public function importView() {
        return view('import-view');
    }

    /**
     * Import data student from excel
     */
     public function importStudent() {
        // dd(request()->file('file')->store('files'));
        // die();
        Excel::import(new StudentsImport, request()->file('file'));

        return redirect('/import-student')->with('success', 'all good');
     }
}
