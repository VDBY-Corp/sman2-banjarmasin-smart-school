<?php

namespace Database\Seeders;

use App\Models\AchievementData;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AchievementDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 30; $i++) {
            AchievementData::insert([
                'id' => $i,
                'student_id' => $faker->numberBetween(1, 39),
                'achievement_id' => $faker->numberBetween(1, 4),
                'generation_id' => $faker->numberBetween(1, 3),
                'grade_id' => $faker->numberBetween(1, 6),
                'date' => $faker->dateTime(),
                'proof' => 'bukti.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
