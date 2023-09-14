<?php

namespace App\Http\Controllers\Dashboard\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student_count = Student::count();
        $teacher_count = Teacher::count();
        $grade_count = Grade::count();
        return view('pages.dashboard.teacher.home', compact('student_count', 'teacher_count', 'grade_count'));
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
