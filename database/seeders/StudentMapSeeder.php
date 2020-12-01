<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Excel;
use App\Imports\SeedImport;
use App\Helpers\InitHelper;

class StudentMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = Excel::toArray(new SeedImport, str_replace('storage', 'public\files', storage_path('buX-USIS-gsuite.xlsx')))[0];
        $init = new InitHelper;

        foreach ($rows as $key => $row) {
            $init->studentCreate($row);
        }
    }
}
