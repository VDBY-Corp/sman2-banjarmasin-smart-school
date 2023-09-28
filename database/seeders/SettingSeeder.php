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
        $navbarcolorslist = ['bg-primary','bg-warning','bg-info','bg-danger','bg-success','bg-indigo','bg-lightblue','bg-navy','bg-purple','bg-fuchsia','bg-pink','bg-maroon','bg-orange','bg-lime','bg-teal','bg-olive'];
        $sidebarcolorslist = ['sidebar-dark-primary','sidebar-dark-warning','sidebar-dark-info','sidebar-dark-danger','sidebar-dark-success','sidebar-dark-indigo','sidebar-dark-lightblue','sidebar-dark-navy','sidebar-dark-purple','sidebar-dark-fuchsia','sidebar-dark-pink','sidebar-dark-maroon','sidebar-dark-orange','sidebar-dark-lime','sidebar-dark-teal','sidebar-dark-olive','sidebar-light-primary','sidebar-light-warning','sidebar-light-info','sidebar-light-danger','sidebar-light-success','sidebar-light-indigo','sidebar-light-lightblue','sidebar-light-navy','sidebar-light-purple','sidebar-light-fuchsia','sidebar-light-pink','sidebar-light-maroon','sidebar-light-orange','sidebar-light-lime','sidebar-light-teal','sidebar-light-olive'];

        $default_values = [
            ['school.name', 'string', 'SMAN 2 BANJARMASIN', 'SMAN 2 BANJARMASIN'],
            ['school.address', 'string', 'Jl. A. Yani Km. 32,5', 'Jl. A. Yani Km. 32,5'],
            ['school.phone', 'string', '0511-3303030', '0511-3303030'],
            ['school.email', 'string', 'admin@smkn1banjarmasin.sch.id'],
            ['school.fax', 'string', '0511-3303030', '0511-3303030'],
            ['violation.initial_point', 'integer', 100, 100],


            ['ui.nav_color', 'options', 'bg-lightblue', 'bg-lightblue', ['options' => $navbarcolorslist]],
            ['ui.sidebar_color', 'options', 'sidebar-dark-lightblue', 'sidebar-dark-lightblue', ['options' => $sidebarcolorslist]],
        ];
        for ($i = 0; $i < count($default_values); $i++) {
            $key = $default_values[$i][0];
            $type = $default_values[$i][1];
            $value = $default_values[$i][2];
            $default_value = $default_values[$i][3] ?? null;
            $meta = $default_values[$i][4] ?? (object) [];
            \App\Models\Setting::create(compact('key', 'type', 'value', 'default_value', 'meta'));
        }
    }
}
