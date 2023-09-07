<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Imports\GenerationImport;
use App\Models\Generation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class GenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = Generation::query();
            return DataTables::eloquent($query)
                ->toJson(true);
        }

        return view('pages.dashboard.admin.master-data.generation.index');
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

            $excel = Excel::import(new GenerationImport, $file);

            return redirect()->back();
        } else {
            $request->validate([
                'id' => 'required|string',
                'name' => 'required|max:20|string',
            ]);
    
            $created = Generation::create($request->only('id', 'name'));
    
            return response()->json([
                'ok' => true,
                'message' => 'berhasil menambah data angkatan',
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
    public function update(Request $request, Generation $generation)
    {
        $request->validate([
            'id' => 'required|string',
            'name' => 'required|max:20|string',
        ]);

        $updated = $generation->update($request->only('id', 'name'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data angkatan',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Generation $generation)
    {
        $generation->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data angkatan',
        ]);
    }
}
