<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Imports\ViolationCategoryImport;
use App\Models\ViolationCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ViolationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = ViolationCategory::withCount('violations');
            return DataTables::eloquent($query)
                ->toJson(true);
        }

        return view('pages.dashboard.admin.master-data.violation.index');
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

            $excel = Excel::import(new ViolationCategoryImport, $file);

            return redirect()->back();
        } else {
            $request->validate([
                'name' => 'required|max:50|string',
                'description' => 'nullable|max:255|string',
            ]);
    
            $created = ViolationCategory::create($request->only('name', 'description'));
    
            return response()->json([
                'ok' => true,
                'message' => 'berhasil menambah data kategori pelanggaran',
                'data' => $created,
            ]);
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(ViolationCategory $violation_category)
    {
        return response()->json([
            'ok' => true,
            'data' => $violation_category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ViolationCategory $violation_category)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'description' => 'nullable|max:255|string',
        ]);

        $updated = $violation_category->update($request->only('name', 'description'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data kategori pelanggaran',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ViolationCategory $violation_category)
    {
        $violation_category->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data kategori pelanggaran',
        ]);
    }
}
