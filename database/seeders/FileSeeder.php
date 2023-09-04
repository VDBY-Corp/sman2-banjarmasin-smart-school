<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::insert([
            'id' => 1,
            'hash' => "asjdhkasdlsakdj",
            'file_name' => "hallo.jpg",
            'mime' => "JPG"
        ]);
    }
}
