<?php

namespace Database\Seeders;

use App\Models\Grade;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['ipa', 'ips', 'tkj', 'perkantoran', 'bahasa', 'sains'];
        for ($i=1; $i <= 6; $i++) {
            Grade::insert([
                'id' => $i,
                'name' => $name[$i - 1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
