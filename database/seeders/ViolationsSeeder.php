<?php

namespace Database\Seeders;

use App\Models\Violation;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ViolationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $name = ['Memasukkan Baju (Siswa Putri)', 'Berambut Gondrong (Siswa Putra)/dicat/diwarna', 'Meninggalkan Kelas Tanpa Izin', 'Tidak Mengikuti Upacara', 'Tidak Mengikuti Pelajaran Tanpa Izin', 'Mengejek Guru', 'Bertato', 'Tidak Memasukkan Baju (Siswa Putra)', 'Terbukti melakukan kejahatan', 'Berkata Kotor Dengan Guru'];
        for ($i=1; $i <= 10; $i++) {
            Violation::insert([
                'id' => $i,
                'violation_category_id' => $faker->numberBetween(1, 4),
                'name' => $name[$i-1],
                'point' => $faker->numberBetween(70, 100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
