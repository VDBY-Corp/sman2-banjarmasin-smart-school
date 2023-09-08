<?php

namespace App\Imports;

use App\Models\Violation;
use App\Models\ViolationCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ViolationImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $violationCategoryName = $row['kategori_pelanggaran'];
        $violation = ViolationCategory::select('id', 'name')->where('name', $violationCategoryName)->first();

        // if violation category not found, don't import
        if (!$violation) {
            return null;
        }

        return new Violation([
            'violation_category_id' => $violation->id,
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
