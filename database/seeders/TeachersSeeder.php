<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 10; $i++) {
            Teacher::insert([
                'nip' => random_int(100000, 999999),
                'name' => $faker->name(),
                'gender' => $faker->randomElement(['laki-laki', 'perempuan']),
                'email' => $faker->email(),
                'password' => $faker->password(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        Teacher::insert([
            'nip' => random_int(100000, 999999),
            'name' => 'guru saboru',
            'gender' => 'laki-laki',
            'email' => 'guru@gmail.com',
            'password' => Hash::make("password"),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Teacher::insert([
            'nip' => random_int(100000, 999999),
            'name' => 'example guru',
            'gender' => 'laki-laki',
            'email' => 'guru@mail.com',
            'password' => Hash::make("password"),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
