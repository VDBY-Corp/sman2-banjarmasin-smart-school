<?php

namespace Database\Seeders;

use App\Models\ViolationSanction;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ViolationSanctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sanction = ['dipanggil orang tua', 'push up', 'dikeluarkan'];
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 3; $i++) {
            ViolationSanction::insert([
                'id' => $i,
                'sanction' => $sanction[$i-1],
                'point' => $faker->numberBetween(70, 100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
