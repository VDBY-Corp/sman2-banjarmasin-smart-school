<?php

namespace Database\Seeders;

use App\Models\ViolationCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViolationCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['kejahatan', 'kerajinan', 'kerapian', 'keseopanan'];

        for ($i=1; $i <= 4; $i++) {
            ViolationCategory::insert([
                'id' => $i,
                'name' => $name[$i - 1],
                'description' => 'ini cuma buat test aja',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
