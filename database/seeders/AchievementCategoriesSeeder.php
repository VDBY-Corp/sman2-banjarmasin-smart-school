<?php

namespace Database\Seeders;

use App\Models\AchievementCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['lomba nasional', 'lomba internasional', 'lomba sekolah', 'lomba provinsi'];
        for ($i=1; $i <= 4; $i++) {
            AchievementCategory::insert([
                'id' => $i,
                'name' => $name[$i-1],
                'description' => 'ini buat contoh aja',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
