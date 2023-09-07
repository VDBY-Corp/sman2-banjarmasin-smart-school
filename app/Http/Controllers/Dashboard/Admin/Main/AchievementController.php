<?php

namespace App\Http\Controllers\Dashboard\Admin\Main;

use App\Http\Controllers\Controller;
use App\Models\AchievementData;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AchievementController extends Controller
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
            } else if ($list == 'achievements')
            {
                $query = $request->get('term');
                return \App\Models\Achievement::with('category')
                    ->where('name', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            }

            // if no data
            $achievement = \App\Models\AchievementData::with('student', 'achievement', 'generation', 'grade');
            return DataTables::eloquent($achievement)
                ->toJson(true);
        }
        return view('pages.dashboard.admin.main.achievement.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:App\Models\Student,nisn|string',
            'achievement_id' => 'required|exists:App\Models\Achievement,id|string'
        ]);

        // mengambil kelas dan angkatan berdasarkan student_id yang dikirim
        $student = Student::findOrFail($request->student_id);

        $created = AchievementData::create(
            array_merge(
                $request->only('student_id', 'achievement_id'),
                ['generation_id' => $student->generation_id],
                ['grade_id' => $student->grade_id],
                ['date' => Carbon::now()],
                ['file_id' => '1']
            )
        );

        return response()->json([
           'ok' => True,
           'message' => 'berhasil menambah data prestasi',
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
            'achievement_id' => 'required|exists:App\Models\Achievement,id|string'
        ]);

        $achievementData = AchievementData::findOrFail($id);
        if ($achievementData->student_id != $request->student_id) {
            $student = Student::findOrFail($request->student_id);

            $updated = $achievementData->update(
                array_merge(
                    $request->only('student_id', 'achievement_id'),
                    ['generation_id' => $student->generation_id],
                    ['grade_id' => $student->grade_id],
                )
            );
        } else {
            $updated = $achievementData->update($request->only('student_id', 'achievement_id'));
        }

        return response()->json([
            'ok' => True,
            'message' => 'berhasil mengubah data prestasi',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $achievementData = AchievementData::findOrFail($id);
        $achievementData->delete();

        return response()->json([
            'ok' => True,
            'message' => 'berhasil menghapus data prestasi',
        ]);
    }
}
