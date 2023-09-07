<?php

namespace Database\Seeders;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i=1; $i < 40; $i++) {
            Student::insert([
                'nisn' => random_int(100000, 999999),
                'grade_id' => $faker->numberBetween(1, 6),
                'generation_id' => $faker->numberBetween(1, 3),
                'name' => $faker->name(),
                'gender' => $faker->randomElement(['laki-laki', 'perempuan']),
                'place_birth' => 'jakarta',
                'date_birth' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
