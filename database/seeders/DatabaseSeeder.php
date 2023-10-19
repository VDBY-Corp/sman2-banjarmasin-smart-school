<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // FileSeeder::class,
            UsersSeeder::class,
            // TeachersSeeder::class,
            // GenerationsSeeder::class,
            // GradesSeeder::class,
            // StudentsSeeder::class,
            // ViolationCategoriesSeeder::class,
            // ViolationsSeeder::class,
            // AchievementCategoriesSeeder::class,
            // AchievementsSeeder::class,
            // ViolationSanctionSeeder::class,
            // AchievementDataSeeder::class,
            // ViolationDataSeeder::class,
            // AttendancesSeeder::class,
            // AttendanceDataSeeder::class,
            SettingSeeder::class,
            // ViolationActionSeeder::class,
            // GenerationGradeTeacherSeeder::class,
        ]);
    }
}
