<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\StudentHelpers\DataRetriever;

class StudentController extends Controller
{
    public function getAcademicList(Request $request)
    {
        $helper = new DataRetriever($request->data, $request->index, $request->cluster);

        return response()->json([
            'success' => true,
            'results' => $helper->getResults()
        ]);
    }
}
