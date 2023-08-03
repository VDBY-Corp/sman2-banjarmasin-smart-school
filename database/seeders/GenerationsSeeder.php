<?php

namespace Database\Seeders;

use App\Models\Generation;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['2020', '2021', '2022'];
        for ($i=1; $i <= 3; $i++) {
            Generation::insert([
                'id' => $i,
                'name' => $name[($i - 1)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
