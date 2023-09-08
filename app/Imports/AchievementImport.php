<?php

namespace App\Imports;

use App\Models\Achievement;
use App\Models\AchievementCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AchievementImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $achievementCategoryName = $row['kategori_pelanggaran'];
        $achievement = AchievementCategory::select('id', 'name')->where('name', $achievementCategoryName)->first();

        // if achievement category not found, don't import
        if (!$achievement) {
            return null;
        }

        return new Achievement([
            'achievement_category_id' => $achievement->id,
            'name' => $row['nama'],
            'point' => $row['point']
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
