<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Facades\Setting;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\AchievementData;
use App\Models\Generation;
use App\Models\Grade;
use App\Models\Student;
use App\Models\ViolationData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $list = $request->get('list');
            if ($list == 'grades')
            {
                $query = $request->get('term');
                return Grade::where('name', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            } else if ($list == 'generations')
            {
                $query = $request->get('term');
                return Generation::where('name', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            }
            if ($request->filter == 'showDeleted') {
                $query = Student::with(['grade', 'generation'])->onlyTrashed();
                return DataTables::eloquent($query)
                    ->toJson(true);
            } else {
                $query = Student::with(['grade', 'generation']);
                return DataTables::eloquent($query)
                    ->toJson(true);
            }
            
        }

        $grades = Grade::all();
        $generations = Generation::all();
        return view('pages.dashboard.admin.master-data.student.index', ['grades' => $grades, 'generations' => $generations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->exists('excel')) {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            $file = $request->file('file');

            $excel = Excel::import(new StudentsImport, $file);

            return redirect()->back();
        } else {
            $request->validate([
                'nisn' => 'required|unique:students,nisn|max:20|string',
                'name' => 'required|max:50|string',
                'gender' => 'required|in:laki-laki,perempuan|string',
                'grade_id' => 'required|exists:App\Models\Grade,id|numeric',
                'generation_id' => 'required|exists:App\Models\Generation,id|numeric',
                'place_birth' => 'required|max:20|string',
                'date_birth' => 'required|date'
            ]);

            $created = Student::create($request->only('nisn', 'grade_id', 'generation_id', 'name', 'gender', 'place_birth', 'date_birth'));

            return response()->json([
                'ok' => true,
                'message' => 'berhasil menambah data siswa',
                'data' => $created,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Student $student)
    {

        $violationData = [];
        $achievementData = [];
        $violationData['count'] = ViolationData::where('student_id', $student->id)->count('student_id');
        $violationData['sum'] = (Setting::get('violation.initial_point')) - DB::table('violation_data')->join('violations', 'violation_data.violation_id', '=', 'violations.id')->where('student_id', $student->id)->sum('point');
        $achievementData['count'] = AchievementData::where('student_id', $student->id)->count('student_id');
        $achievementData['sum'] = DB::table('achievement_data')->join('achievements', 'achievement_data.achievement_id', '=', 'achievements.id')->where('student_id', $student->id)->sum('point');
        $totalPoint = $achievementData['sum'] + $violationData['sum'];

        if ($request->has('laporan')) {
            $violations = ViolationData::with('student', 'violation', 'generation', 'grade', 'teacher')->where('student_id', $student->id)->get();
            $achievements = AchievementData::with('student', 'achievement', 'generation', 'grade')->where('student_id', $student->id)->get();
            // return view('pdf.student_report', compact('student', 'violationData', 'achievementData', 'violations', 'achievements'));
            return PDF::loadView('pdf.student_report', compact('student', 'violationData', 'achievementData', 'violations', 'achievements'))
                ->setPaper('a4')
                ->setOrientation('portrait')
                ->setOption('margin-bottom', 0)
                ->inline('report.pdf');
        } else {
            if ($request->ajax())
            {
                $table = $request->get('table');

                if ($table == 'violations') {
                    $violations = ViolationData::with('student', 'violation', 'generation', 'grade', 'teacher')->where('student_id', $student->id);
                    return DataTables::eloquent($violations)
                        ->toJson(true);
                } else if ($table == 'achievements') {
                    $achievement = AchievementData::with('student', 'achievement', 'generation', 'grade')->where('student_id', $student->id);
                    return DataTables::eloquent($achievement)
                        ->toJson(true);
                }
            }

            return view('pages.dashboard.admin.master-data.student.detail', compact('student', 'violationData', 'achievementData', 'totalPoint'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'gender' => 'required|in:laki-laki,perempuan|string',
            'grade_id' => 'required|exists:App\Models\Grade,id|numeric',
            'generation_id' => 'required|exists:App\Models\Generation,id|numeric',
            'place_birth' => 'required|max:20|string',
            'date_birth' => 'required|date'
        ]);

        if ($student->nisn !== $request->nisn) {
            $request->validate(['nisn' => 'required|unique:students,nisn|max:20|string']);
        }

        $updated = $student->update($request->only('nisn', 'grade_id', 'generation_id', 'name', 'gender', 'place_birth', 'date_birth'));

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
