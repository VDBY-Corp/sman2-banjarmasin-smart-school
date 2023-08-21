<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Generation;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
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
}
