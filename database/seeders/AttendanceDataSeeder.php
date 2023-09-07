<?php

namespace Database\Seeders;

use App\Models\AttendanceData;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AttendanceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i < 40; $i++) {
            AttendanceData::insert([
                'id' => $i,
                'attendance_id' => $faker->numberBetween(1, 39),
                'student_id' => $i,
                'grade_id' => $faker->numberBetween(1, 6),
                'generation_id' => $faker->numberBetween(1, 3),
                'teacher_id' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['Alpha', 'Sakit', 'izin', 'rekomendasi', 'telat', 'bolos']),
                'date' => $faker->dateTime(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
