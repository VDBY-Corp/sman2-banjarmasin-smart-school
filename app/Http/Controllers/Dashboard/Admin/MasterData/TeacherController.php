<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = Teacher::query();
            return DataTables::eloquent($query)
                ->toJson(true);
        }

        return view('pages.dashboard.admin.master-data.teacher.index');
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
            'nip' => 'required|unique:teachers,nip|max:20|string',
            'name' => 'required|max:50|string',
            'gender' => 'required|in:laki-laki,perempuan|string',
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        $created = Teacher::create(
            array_merge(
                $request->only('nip', 'name', 'gender', 'email', 'password'),
                ['password' => Hash::make($request->password)]
            )
        );

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menambah data guru',
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
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'gender' => 'required|in:laki-laki,perempuan|string',
            'email' => 'required|email',
        ]);

        if ($teacher->nip !== $request->nip) {
            $request->validate(['nip' => 'required|unique:teachers,nip|max:20|string']);
        }

        if ($request->password != null) {
            $request->validate(['password' => 'required|string']);
            $updated = $teacher->update(
                array_merge(
                    $request->only('nip', 'name', 'gender', 'email'),
                    ['password' => Hash::make($request->password)]
                )
            );
        } else {
            $updated = $teacher->update($request->only('nip', 'name', 'gender', 'email'));
        }

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data guru',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data guru',
        ]);
    }
}
