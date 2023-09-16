<?php

namespace App\Http\Controllers\Dashboard\Teacher\Main;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Generation;
use App\Models\GenerationGradeTeacher;
use App\Models\Grade;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $attendances = Attendance::with('grade', 'generation', 'teacher')
                ->where('teacher_id', getAuthGuardByCurrentRoute()->user()->id)
                ->orderBy('date', 'DESC');
            return DataTables::eloquent($attendances)
                ->toJson(true);
        }
        return view('pages.dashboard.teacher.main.attendance.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $generationGradeTeacher = GenerationGradeTeacher::where('teacher_id', getAuthGuardByCurrentRoute()->user()->id)->first();

        $created = Attendance::create([
            'grade_id' => $generationGradeTeacher->grade_id,
            'generation_id' => $generationGradeTeacher->generation_id,
            'teacher_id' => $generationGradeTeacher->teacher_id,
            'date' => $request->date,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Attendance created successfully.',
            'data' => $created
        ]);
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
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $grade = Grade::findOrFail($request->grade_id);
        $updated = $attendance->update([
            'date' => $request->date,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Attendance updated successfully.',
            'data' => $updated
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $deleted = $attendance->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Attendance deleted successfully.',
            'data' => $deleted
        ]);
    }
}
