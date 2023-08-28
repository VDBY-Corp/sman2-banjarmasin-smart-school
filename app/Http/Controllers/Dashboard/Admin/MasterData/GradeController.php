<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = Grade::with(['teacher']);
            return DataTables::eloquent($query)
                ->toJson(true);
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
        $request->validate([
            'id' => 'required|string',
            'name' => 'required|max:20|string',
            'teacher_id' => 'required|exists:App\Models\Teacher,id|string',
        ]);

        $created = Grade::create($request->only('id', 'name', 'teacher_id'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menambah data kelas',
            'data' => $created,
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
            'id' => 'required|string',
            'name' => 'required|max:20|string',
            'teacher_id' => 'required|exists:App\Models\Teacher,id|string',
        ]);

        $updated = $grade->update($request->only('id', 'name', 'teacher_id'));

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
}
