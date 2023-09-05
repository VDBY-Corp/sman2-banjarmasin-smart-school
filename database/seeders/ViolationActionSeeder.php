<?php

namespace Database\Seeders;

use App\Models\ViolationAction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViolationActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [50, 80, "Panggilan ke BK"],
            [10, 50, "Panggilan Orang Tua"],
        ];

        for ($i = 0; $i < count($data); $i++) {
            $min_point = $data[$i][0];
            $max_point = $data[$i][1];
            $description = $data[$i][2];
            ViolationAction::create([
                'point_a' => $min_point,
                'point_b' => $max_point,
                'action' => $description,
            ]);
        }
    }
}
