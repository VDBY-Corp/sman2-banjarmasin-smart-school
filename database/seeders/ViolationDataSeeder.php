<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\ViolationData;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ViolationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 50; $i++) {
            ViolationData::insert([
                'id' => $i,
                'student_id' => $faker->numberBetween(1, 39),
                'teacher_id' => Teacher::all()->random()->id,
                'violation_id' => $faker->numberBetween(1, 10),
                'generation_id' => $faker->numberBetween(1, 3),
                'grade_id' => $faker->numberBetween(1, 6),
                'date' => $faker->dateTime(),
                // 'file_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
