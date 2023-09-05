<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\ViolationAction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ViolationActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = ViolationAction::query();
            return DataTables::of($query)
                ->toJson(true);
        }

        return view('pages.dashboard.admin.master-data.violation.action');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'point_a' => 'required|numeric',
            'point_b' => 'required|numeric'
        ]);

        $created = ViolationAction::create($request->only('action', 'point_a', 'point_b'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menambah data aksi pelanggaran',
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
            'action' => 'required|string',
            'point_a' => 'required|numeric',
            'point_b' => 'required|numeric'
        ]);

        $violationAction = ViolationAction::findOrFail($id);

        $updated = $violationAction->update($request->only('action', 'point_a', 'point_b'));

        return response()->json([
            'ok' => True,
            'message' => 'berhasil mengubah data aksi pelanggaran',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $violationAction = ViolationAction::findOrfail($id);

        $violationAction->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data aksi pelanggaran',
            'data' => $violationAction,
        ]);
    }
}
