<?php

namespace App\Http\Controllers\Dashboard\Admin\Main;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
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
            $list = $request->get('list');
            if ($list == 'grades')
            {
                $query = $request->get('term');
                return Grade::where('name', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            }

            // if no data
            $attendances = Attendance::with('grade')
                ->orderBy('date', 'DESC');
            return DataTables::eloquent($attendances)
                ->toJson(true);
        }
        return view('pages.dashboard.admin.main.attendance.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'date' => 'required|date',
        ]);

        $created = Attendance::create([
            'grade_id' => $request->grade_id,
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
            'grade_id' => 'required|exists:grades,id',
            'date' => 'required|date',
        ]);

        $updated = $attendance->update([
            'grade_id' => $request->grade_id,
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
