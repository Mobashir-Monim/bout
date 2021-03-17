<?php

namespace App\Helpers\DataBackupHelpers;

use \DB;

class DownloadHelper extends BackupHelper
{
    protected $table;
    protected $index;

    public function __construct($table, $index)
    {
        $this->table = $table;
        $this->index = $index;
    }

    public function validateTable()
    {
        foreach ($this->tables as $table) {
            if ($table['name'] == $this->table) {
                return true;
            }
        }

        return false;
    }

    public function download()
    {
        if ($this->validateTable()) {
            return [
                'success' => true,
                'table_data' => DB::table($this->table)->paginate(250),
                'has_more' => count(DB::table($this->table)->get()) > $this->index * 250 + 250
            ];
        } else {
            return [
                'success' => false,
                'message' => "No such table exits $this->table"
            ];
        }
    }
}