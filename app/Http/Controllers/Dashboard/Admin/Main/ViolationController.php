<?php

namespace App\Http\Controllers\Dashboard\Admin\Main;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ViolationData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $request->validate([
            'student_id' => 'required|exists:App\Models\Student,nisn|string',
            'violation_id' => 'required|exists:App\Models\Violation,id|string',
            'date' => 'required|date'
        ]);

        // mengambil kelas dan angkatan berdasarkan student_id yang dikirim
        $student = Student::findOrFail($request->student_id);

        $created = ViolationData::create(
            array_merge(
                $request->only('student_id', 'violation_id', 'date'),
                ['generation_id' => $student->generation_id],
                ['grade_id' => $student->grade_id],
                ['file_id' => '1']
            )
        );

        return response()->json([
           'ok' => True,
           'message' => 'berhasil menambah data pelanggaran',
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|exists:App\Models\Student,nisn|string',
            'violation_id' => 'required|exists:App\Models\Violation,id|string',
            'date' => 'required|date'
        ]);

        $violationData = ViolationData::findOrFail($id);
        if ($violationData->student_id != $request->student_id) {
            $student = Student::findOrFail($request->student_id);
            
            $updated = $violationData->update(
                array_merge(
                    $request->only('student_id', 'violation_id', 'date'),
                    ['generation_id' => $student->generation_id],
                    ['grade_id' => $student->grade_id],
                )
            );
        } else {
            $updated = $violationData->update($request->only('student_id', 'violation_id', 'date'));
        }

        return response()->json([
            'ok' => True,
            'message' => 'berhasil mengubah data pelanggaran',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $violationData = ViolationData::findOrFail($id);
        $violationData->delete();

        return response()->json([
            'ok' => True,
            'message' => 'berhasil menghapus data pelanggaran',
        ]);
    }
}
