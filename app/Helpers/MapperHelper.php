<?php

namespace App\Helpers;

use App\Models\StudentMap;

class MapperHelper extends Helper
{
    public function mapStudents($data)
    {
        if (sizeof($data[0]) > 1) {
            return $this->mapDualKey($data);
        } else {
            return $this->mapSingleKey($data);
        }
    }

    public function mapSingleKey($data)
    {
        foreach ($data as $k => $row) {
            foreach ($row as $key => $value) {
                $data[$k]['id'] = StudentMap::where($key, $value)->first();
                $data[$k]['id'] = is_null($data[$k]['id']) ? 'Not found, please let the devs know' : $data[$k]['id']->student_id;
            }
        }

        return $data;
    }

    public function mapDualKey($data)
    {
        foreach ($data as $k => $row) {
            $temp = [];

            foreach ($row as $key => $value) {
                $t = StudentMap::where($key, $value)->first();
                array_push($temp, is_null($t) ? 'Not found, please let the devs know' : $t->student_id);
            }

            if ($temp[0] == $temp[1]) {
                $data[$k]['id'] = $temp[0];
            } elseif ($temp[0] == 'Not found, please let the devs know') {
                $data[$k]['id'] = $temp[1];
            } elseif ($temp[1] == 'Not found, please let the devs know') {
                $data[$k]['id'] = $temp[0];
            } else {
                $data[$k]['id'] = 'Student ID mismatch, please let the devs know';
            }
        }

        return $data;
    }
}