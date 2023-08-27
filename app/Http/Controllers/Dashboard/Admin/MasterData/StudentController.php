<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Generation;
use App\Models\Grade;
use App\Models\Student;
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
        $grades = Grade::all();
        $generations = Generation::all();
        if ($request->ajax())
        {
            $query = Student::with(['grade', 'generation']);
            return DataTables::eloquent($query)
                ->toJson(true);
        }
        return view('pages.dashboard.admin.master-data.student.index', ['grades' => $grades, 'generations' => $generations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:students,nisn',
            'name' => 'required',
            'gender' => 'required|in:laki-laki,perempuan',
        ]);
        $created = Student::create($request->only('nsin', 'nama'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrfail($id);
        $student->nisn = $request->new_nisn;
        $student->name = $request->name;
        $student->gender = $request->gender;
        $student->grade_id = $request->grade_id;
        $student->generation_id = $request->generation_id;
        $student->save();

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
            'data' => $student,
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
