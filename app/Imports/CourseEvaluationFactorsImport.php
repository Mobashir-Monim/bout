<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class CourseEvaluationFactorsImport implements ToCollection, WithHeadingRow
{
    public $data = null;

    public function collection(Collection $rows)
    {
        $this->data = (object) [
            'short_hand' => $rows->pluck('short_hand')->toArray(),
            'name' => $rows->pluck('name')->toArray(),
            'description' => $rows->pluck('description')->toArray()
        ];
    }
}
