<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['juara bidang esport', 'juara bidang religi', 'juara bidang sport', 'juara bidang pendidikan'];
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 4; $i++) {
            Achievement::insert([
                'id' => $i,
                'achievement_categories_id' => $faker->numberBetween(1, 4),
                'name' => $name[$i-1],
                'point' => $faker->numberBetween(70, 100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
