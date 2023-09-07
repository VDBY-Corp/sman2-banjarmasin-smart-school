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
            ['school.name', 'string', 'SMAN 2 BANJARMASIN', 'SMAN 2 BANJARMASIN'],
            ['school.address', 'string', 'Jl. A. Yani Km. 32,5', 'Jl. A. Yani Km. 32,5'],
            ['school.phone', 'string', '0511-3303030', '0511-3303030'],
            ['school.email', 'string', 'admin@smkn1banjarmasin.sch.id'],
            ['school.fax', 'string', '0511-3303030', '0511-3303030'],
            ['violation.initial_point', 'integer', 100, 100],
        ];
        for ($i = 0; $i < count($default_values); $i++) {
            $key = $default_values[$i][0];
            $type = $default_values[$i][1];
            $value = $default_values[$i][2];
            $default_value = $default_values[$i][3] ?? null;
            \App\Models\Setting::create(compact('key', 'type', 'value', 'default_value'));
        }
    }
}
