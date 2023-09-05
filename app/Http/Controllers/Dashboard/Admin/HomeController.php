<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $student_count = Student::count();
        $teacher_count = Teacher::count();
        $grade_count = Grade::count();
        return view('pages.dashboard.admin.home', compact('student_count', 'teacher_count', 'grade_count'));
    }
}
