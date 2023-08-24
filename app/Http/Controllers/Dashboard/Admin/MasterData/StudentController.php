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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $student = Student::findOrfail($request->old_nisn);
        $student->nisn = $request->new_nisn;
        $student->name = $request->name;
        $student->gender = $request->gender;
        $student->grade_id = $request->grade_id;
        $student->generation_id = $request->generation_id;
        $student->save();
        return $student;
        // return back()->with('message', $student->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
