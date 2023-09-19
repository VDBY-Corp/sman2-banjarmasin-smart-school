<?php

namespace App\Http\Controllers\Dashboard\Admin\Main;

use App\Http\Controllers\Controller;
use App\Imports\AttendanceDataImport;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceDataController extends Controller
{
    static $statuses = ['Hadir', 'Alpa', 'Sakit', 'Izin', 'Rekomendasi', 'Telat', 'Bolos', 'Lainnya'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Attendance $attendance)
    {
        $data = [];

        // load all siswa to data
        $students = \App\Models\Student::with('grade', 'generation')
            ->where('grade_id', $attendance->grade->id)
            ->where('generation_id', $attendance->generation->id)
            ->get();

        // move to data
        foreach ($students as $student)
        {
            $data[] = (object) [
                'student' => $student,
                'status' => null,
                'description' => ''
            ];
        }

        // load current attendance data
        $attendance_data = $attendance->data()->get();

        // merge with current attendance data
        foreach ($attendance_data as $attendance_data)
        {
            // search first in data, if not found, then push to data
            $search = collect($data)->where('student.id', $attendance_data->student->id)->first();
            if ($search)
            {
                $search->status = $attendance_data->status;
                $search->description = $attendance_data->description;
            } else
            {
                $data[] = (object) [
                    'student' => $attendance_data->student,
                    'status' => $attendance_data->status,
                    'description' => $attendance_data->description
                ];
            }
        }

        // dd($data);

        $statuses = self::$statuses;
        return view('pages.dashboard.admin.main.attendance.data', compact('attendance', 'data', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Attendance $attendance)
    {
        if ($request->exists('excel')) {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            $file = $request->file('file');

            $excel = Excel::import(new AttendanceDataImport($attendance->id), $file);

            return redirect()->back();
        } else {
            $request->validate([
                'student.*' => 'required|exists:students,id',
                'status.*' => 'nullable|in:' . implode(',', self::$statuses),
                'description.*' => 'nullable|string'
            ]);
    
            // load current attendance data
            $attendance_data = $attendance->data()->get();
    
            // store all data
            DB::transaction(function () use ($attendance, $request, $attendance_data) {
                foreach (request('student') as $key => $student)
                {
                    // search first in data, if not found, then push to data
                    $search = collect($attendance_data)->where('student_id', $student)->first();
    
                    if ($search)
                    {
                        $attendance->data()->where('student_id', $student)->update([
                            'status' => request('status')[$key],
                            'description' => request('description')[$key]
                        ]);
                    } else
                    {
                        $attendance->data()->create([
                            'student_id' => $student,
                            'status' => request('status')[$key],
                            'description' => request('description')[$key]
                        ]);
                    }
                }
            });
    
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Data absensi berhasil disimpan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
