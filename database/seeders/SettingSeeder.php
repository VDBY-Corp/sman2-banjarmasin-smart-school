<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_values = [
            ['school.name', 'SMAN 2 BANJARMASIN', 'SMAN 2 BANJARMASIN'],
            ['school.address', 'Jl. A. Yani Km. 32,5', 'Jl. A. Yani Km. 32,5'],
            ['school.phone', '0511-3303030', '0511-3303030'],
            ['school.email', 'admin@smkn1banjarmasin.sch.id'],
            ['school.fax', '0511-3303030', '0511-3303030'],
            ['violation.initial_point', 0, 0],
            ['violation.max_point', 100, 100],
        ];
        for ($i = 0; $i < count($default_values); $i++) {
            $key = $default_values[$i][0];
            $value = $default_values[$i][1];
            $default_value = $default_values[$i][2] ?? null;
            \App\Models\Setting::create(compact('key', 'value', 'default_value'));
        }
    }
}
