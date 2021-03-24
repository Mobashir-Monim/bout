<?php

namespace App\Helpers\DataBackupHelpers;

use \DB;
use App\Models\Config;

class UploadHelper extends BackupHelper
{
    protected $table;
    protected $rows;

    public function __construct($table = null, $rows = null)
    {
        $this->table = $table;
        $this->rows = $rows;
    }

    public function setGlobals($table, $rows)
    {
        $this->table = $table;
        $this->rows = $rows;
    }

    public function upload()
    {
        if ($this->validateTable()) {
            DB::table($this->table)->insert($this->rows);
        }
    }

    public function prune()
    {
        foreach ($this->tables as $table) {
            if ($table['name'] != 'configs') {
                DB::table($table['name'])->delete();
            } else {
                DB::table($table['name'])->where('id', 'not like', 'data-backup-%')->delete();
            }
        }
    }

    public function getBackUpConfig($current)
    {
        $config = Config::find("data-backup-$current");

        if (is_null($config)) {
            $config = Config::create(['id' => "data-backup-$current", 'configs' => []]);
        }
        
        $config->configs = [];
        $config->save();

        return $config;
    }

    public function setBackupRows($table, $rows, $current)
    {
        $config = Config::find("data-backup-$current");

        if (is_null($config)) {
            $config = Config::create(['id' => "data-backup-$current", 'configs' => ['data' => 
                base64_encode(gzdeflate(json_encode(['table' => $table, 'rows' => $rows]), 9))
            ]]);
        } else {
            $config->configs = ['data' => 
                base64_encode(gzdeflate(json_encode(['table' => $table, 'rows' => $rows]), 9))
            ];
            $config->save();
        }
    }
}