<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MapperHelper;

class MapperController extends Controller
{
    public function studentMaps()
    {
        return view('mapper.index');
    }

    public function mapStudents()
    {
        $helper = new MapperHelper(request()->mapType);
        $data = $helper->mapStudents(request()->data);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function savedResponseFormat()
    {
        return view('saved-response-format.index');
    }
}