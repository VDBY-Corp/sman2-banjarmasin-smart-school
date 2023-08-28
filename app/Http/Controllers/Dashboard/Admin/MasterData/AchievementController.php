<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AchievementCategory $achievement_category)
    {
        if ($request->ajax())
        {
            $query = Achievement::query();
            return DataTables::of($query)
                ->toJson(true);
        }

        return view('pages.dashboard.admin.master-data.achievement.detail_blade', compact('achievement_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AchievementCategory $achievement_category)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'point' => 'required|integer',
        ]);

        $created = Achievement::create(
            array_merge(
                $request->only('name', 'point'),
                ['achievement_category_id' => $achievement_category->id]
            )
        );

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menambah data prestasi',
            'data' => $created,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AchievementCategory $achievement_category, Achievement $achievement)
    {
        return response()->json([
            'ok' => true,
            'data' => $achievement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AchievementCategory $achievement_category, Achievement $achievement)
    {
        $request->validate([
            'name' => 'required|max:50|string',
            'point' => 'required|integer',
        ]);

        $updated = $achievement->update($request->only('name', 'point'));

        return response()->json([
            'ok' => true,
            'message' => 'berhasil mengubah data prestasi',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AchievementCategory $achievement_category, Achievement $achievement)
    {
        $achievement->delete();

        return response()->json([
            'ok' => true,
            'message' => 'berhasil menghapus data prestasi',
        ]);
    }
}
