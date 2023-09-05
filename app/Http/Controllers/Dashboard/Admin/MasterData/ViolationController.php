<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\ViolationCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ViolationCategory $violation_category)
    {
        if ($request->ajax())
        {
            $query = Violation::query();
            return DataTables::of($query)
                ->toJson(true);
        }

        return view('pages.dashboard.admin.master-data.violation.detail_blade', compact('violation_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ViolationCategory $violation_category)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'point' => 'required|integer',
        ]);

        $created = Violation::create(
            array_merge(
                $request->only('name', 'point'),
                ['violation_category_id' => $violation_category->id]
            )
        );

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menambah data pelanggaran',
            'data' => $created,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ViolationCategory $violation_category, Violation $violation)
    {
        return response()->json([
            'ok' => true,
            'data' => $violation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ViolationCategory $violation_category, Violation $violation)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'point' => 'required|integer',
        ]);

        $updated = $violation->update($request->only('name', 'point'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data pelanggaran',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ViolationCategory $violation_category, Violation $violation)
    {
        $violation->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data pelanggaran',
        ]);
    }

    public function setting_index()
    {
        return view('pages.dashboard.admin.master-data.violation.setting');
    }

    public function setting_store()
    {

    }
}
