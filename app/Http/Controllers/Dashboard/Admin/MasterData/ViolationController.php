<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\ViolationCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Facades\Setting;
use App\Imports\ViolationImport;
use Maatwebsite\Excel\Facades\Excel;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ViolationCategory $violation_category)
    {
        if ($request->ajax())
        {
            $query = Violation::query()->where('violation_category_id', $violation_category->id);
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
        if ($request->exists('excel')) {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            $file = $request->file('file');

            $excel = Excel::import(new ViolationImport, $file);

            return redirect()->back();
        } else {
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
        $settings = Setting::getAll('violation.');
        return view('pages.dashboard.admin.master-data.violation.setting', compact('settings'));
    }

    public function setting_update(Request $request)
    {
        $settings = Setting::getAll('violation.');

        // validate each setting
        foreach ($settings as $key => $value) {
            $key = str_replace('violation.', 'violation_', $key);
            $request->validate([
                $key => 'required',
            ]);
        }

        // update each setting
        foreach ($settings as $key => $value) {
            $request_key = str_replace('violation.', 'violation_', $key);
            $val = $request->$request_key;
            if (Setting::getType($key) == 'integer') {
                $val = intval($val);
            } else if (Setting::getType($key) == 'boolean') {
                $val = boolval($val);
            } else if (Setting::getType($key) == 'string') {
                $val = strval($val);
            }
            Setting::set($key, $val);
        }

        // setting violation point
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil mengubah pengaturan pelanggaran',
        ]);
    }
}
