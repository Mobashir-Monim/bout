<?php

namespace App\Helpers\DataBackupHelpers;

use \DB;

class UploadHelper extends BackupHelper
{
    protected $table;
    protected $rows;
    protected $prune;

    public function __construct($table, $rows, $prune)
    {
        $this->table = $table;
        $this->rows = $rows;
        $this->prune = $prune;
    }

    public function upload()
    {
        {
            if ($this->validateTable()) {
                $this->pruneTable();
                $this->seedDB();

                return [
                    'success' => true,
                    'message' => "Successfully uploaded data"
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "No such table exits $this->table"
                ];
            }
        }
    }

    public function pruneTable()
    {
        if ($this->table == 'users') {
            $this->pruneUsersTable();
        } elseif ($this->table == 'roles') {
            $this->pruneRolesTable();
        } elseif ($this->table == 'role_user') {
            $this->pruneRoleUserTable();
        } else {
            DB::table($this->table)->truncate();
        }
    }

    public function pruneUsersTable()
    {
        foreach (DB::table('users')->where('email', '!=', 'mobashir.monim@bracu.ac.bd')->get() as $row) {
            DB::table('role_user')->where('id', $row->id)->delete();
        }
    }

    public function pruneRolesTable()
    {
        foreach (DB::table('roles')->where('name', '!=', 'super-admin')->get() as $row) {
            DB::table('roles')->where('id', $row->id)->delete();
        }
    }

    public function pruneRoleUserTable()
    {
        $user = DB::table('users')->where('email', 'mobashir.monim@bracu.ac.bd')->first()->id;
        $role = DB::table('roles')->where('name', 'super-admin')->first()->id;

        foreach (DB::table('role_user')->where('user_id', '!=', $user)->get() as $row) {
            DB::table('role_user')->where('id', $row->id)->delete();
        }
    }

    public function seedDB()
    {
        if ($this->table == 'users') {
            $this->uploadUsersData();
        } elseif ($this->table == 'roles') {
            $this->uploadRoleData();
        } elseif ($this->table == 'role_user') {
            $this->uploadRoleUserData();
        } else {
            foreach ($this->rows as $row) {
                if (is_null(DB::table($this->table)->where('id', $row['id'])->first())) {
                    DB::table($this->table)->insert($row);
                }
            }
        }
    }

    public function uploadUsersData()
    {
        foreach ($this->rows as $row) {
            if ($row['email'] != 'mobashir.monim@bracu.ac.bd') {
                DB::table($this->table)->insert([$row]);
            }
        }
    }

    public function uploadRoleData()
    {
        foreach ($this->rows as $row) {
            if ($row['name'] != 'super-admin') {
                DB::table($this->table)->insert([$row]);
            }
        }
    }

    public function uploadRoleUserData()
    {
        foreach ($this->rows as $row) {
            if ($row['user_id'] != DB::table('users')->where('email', 'mobashir.monim@bracu.ac.bd')->first()->id) {
                DB::table($this->table)->insert([$row]);
            }
        }
    }
}