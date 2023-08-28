<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\AchievementCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AchievementCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = AchievementCategory::withCount('achievements');
            return DataTables::eloquent($query)
                ->toJson(true);
        }

        return view('pages.dashboard.admin.master-data.achievement.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'description' => 'nullable|max:255|string',
        ]);

        $created = AchievementCategory::create($request->only('name', 'description'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menambah data kategori prestasi',
            'data' => $created,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AchievementCategory $achievement_category)
    {
        return response()->json([
            'ok' => true,
            'data' => $achievement_category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AchievementCategory $achievement_category)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'description' => 'nullable|max:255|string',
        ]);

        $updated = $achievement_category->update($request->only('name', 'description'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data kategori prestasi',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AchievementCategory $achievement_category)
    {
        $deleted = $achievement_category->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data kategori prestasi',
            'data' => $deleted,
        ]);
    }
}
