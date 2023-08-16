<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $student_count = Student::count();
        return view('pages.dashboard.admin.home', compact('student_count'));
    }
}
