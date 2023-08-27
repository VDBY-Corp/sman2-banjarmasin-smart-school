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

class ViolationCategoryController extends Controller
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
        return view('pages.dashboard.admin.master-data.violation.index', compact('grades', 'generations'));
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
