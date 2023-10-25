<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Imports\GenerationGradeTeacherImport;
use App\Models\Generation;
use App\Models\GenerationGradeTeacher;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class GenerationGradeTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $list = $request->get('list');
            if ($list == 'teachers')
            {
                $query = $request->get('term');
                return Teacher::where('name', 'like', "%$query%")
                    ->orWhere('nip', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            } else if ($list == 'generations') {
                $query = $request->get('term');
                return Generation::where('name', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            } else if ($list == 'grades') {
                $query = $request->get('term');
                return Grade::where('name', 'like', "%$query%")
                    ->limit(10)
                    ->get();
            }

            if ($request->filter == 'showDeleted') {
                $query = GenerationGradeTeacher::with(['generation', 'grade', 'teacher'])->onlyTrashed();
                return DataTables::eloquent($query)
                    ->toJson(true);
            } else {
                $query = GenerationGradeTeacher::with(['generation', 'grade', 'teacher']);
                return DataTables::eloquent($query)
                    ->toJson(true);
            }

        }
        // $query = GenerationGradeTeacher::with(['generation', 'grade', 'teacher']);
        // return DataTables::eloquent($query)
        //     ->toJson(true);
        return view('pages.dashboard.admin.master-data.generation-grade-teacher.index');
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

            $excel = Excel::import(new GenerationGradeTeacherImport, $file);

            return redirect()->back();
        } else {
            $request->validate([
                'generation_id' => 'required|exists:App\Models\Generation,id|string',
                'grade_id' => 'required|exists:App\Models\Grade,id|string',
                'teacher_id' => 'required|exists:App\Models\Teacher,id|string',
            ]);

            $created = GenerationGradeTeacher::create($request->only('generation_id', 'grade_id', 'teacher_id'));

            return response()->json([
                'ok' => true,
                'message' => 'berhasil menambah data angkatan kelas guru',
                'data' => $created,
            ]);
        }
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
    public function update(Request $request, GenerationGradeTeacher $generationGradeTeacher)
    {
        $request->validate([
            'generation_id' => 'required|exists:App\Models\Generation,id|string',
            'grade_id' => 'required|exists:App\Models\Grade,id|string',
            'teacher_id' => 'required|exists:App\Models\Teacher,id|string',
        ]);

        $updated = $generationGradeTeacher->update($request->only('generation_id', 'grade_id', 'teacher_id'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data angkatan kelas guru',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenerationGradeTeacher $generationGradeTeacher)
    {
        $generationGradeTeacher->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data angkatan kelas guru',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        GenerationGradeTeacher::withTrashed()->find($id)->restore();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil memulihkan data wali kelas',
        ]);
    }

    /**
     * Permanent delete the specified resource from storage.
     */
    public function permanentDelete($id)
    {
        GenerationGradeTeacher::withTrashed()->find($id)->forceDelete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus permanen data wali kelas',
        ]);
    }
}
