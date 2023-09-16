<?php

namespace App\Http\Controllers\Dashboard\Teacher\Main;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Generation;
use App\Models\GenerationGradeTeacher;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $list = $request->get('list');
            if ($list == 'generationGrades')
            {
                $query = $request->get('term');

                return DB::table('generation_grade_teachers')->select('generation_grade_teachers.id as id', 'generations.name as generationName', 'grades.name as gradeName')
                ->join('generations', 'generations.id', '=', 'generation_grade_teachers.generation_id')
                ->join('grades', 'grades.id', '=', 'generation_grade_teachers.grade_id')
                ->where('generation_grade_teachers.deleted_at', null)
                ->where('generation_grade_teachers.teacher_id', getAuthGuardByCurrentRoute()->user()->id)
                // ->where('generations.name', 'like', "%$query%")
                ->where('grades.name', 'like', "%$query%")
                ->get();
            }
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
            'generation_grade_id' => 'required|exists:generation_grade_teachers,id',
            'date' => 'required|date',
        ]);

        $generationGradeTeacher = GenerationGradeTeacher::findOrFail($request->generation_grade_id);

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
        $updated = '';

        if (!$request->generation_grade_id) {
            $updated = $attendance->update([
                'date' => $request->date,
            ]);
        } else {
            $request->validate([
                'generation_grade_id' => 'required|exists:generation_grade_teachers,id',
            ]);

            $generationGradeTeacher = GenerationGradeTeacher::findOrFail($request->generation_grade_id);

            $updated = $attendance->update([
                'grade_id' => $generationGradeTeacher->grade_id,
                'generation_id' => $generationGradeTeacher->generation_id,
                'date' => $request->date,
            ]);
        }

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
