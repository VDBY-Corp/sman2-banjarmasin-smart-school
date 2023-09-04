<?php

namespace App\Http\Controllers\Dashboard\Admin\Main;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $list = $request->get('list');
            if ($list == 'students')
            {
                $query = $request->get('term');
                return Student::with('grade', 'generation')
                    ->where('name', 'like', "%$query%")
                    ->orWhere('nisn', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            } else if ($list == 'violations')
            {
                $query = $request->get('term');
                return \App\Models\Violation::with('category')
                    ->where('name', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            }

            // if no data
            $violations = \App\Models\ViolationData::with('student', 'violation', 'generation', 'grade');
            return DataTables::eloquent($violations)
                ->toJson(true);
        }
        return view('pages.dashboard.admin.main.violation.index');
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
