<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Imports\GradeImport;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            if ($request->filter == 'showDeleted') {
                $query = Grade::onlyTrashed();
                return DataTables::eloquent($query)
                    ->toJson(true);
            } else {
                $query = Grade::query();
                return DataTables::eloquent($query)
                    ->toJson(true);
            }
            
        }

        $teachers = Teacher::all();
        return view('pages.dashboard.admin.master-data.grade.index', ['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

            $excel = Excel::import(new GradeImport, $file);

            return redirect()->back();
        } else {
            $request->validate([
                'name' => 'required|max:20|string',
            ]);

            $created = Grade::create($request->only('id', 'name'));

            return response()->json([
                'ok' => true,
                'message' => 'berhasil menambah data kelas',
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'name' => 'required|max:20|string',
        ]);

        $updated = $grade->update($request->only('id', 'name'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data kelas',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data kelas',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        Grade::withTrashed()->find($id)->restore();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil memulihkan data kelas',
        ]);
    }

    /**
     * Permanent delete the specified resource from storage.
     */
    public function permanentDelete($id)
    {
        Grade::withTrashed()->find($id)->forceDelete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus permanen data kelas',
        ]);
    }
}
