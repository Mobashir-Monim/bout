<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Course;

class TestExport implements FromCollection
{
    use Exportable;

    public function collection()
    {
        return Course::all();
    }
}
