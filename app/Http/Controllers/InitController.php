<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\InitHelper;

class InitController extends Controller
{
    public function seederIndex()
    {
        return view('init/seeder');
    }

    public function seedPart()
    {
        $helper = new InitHelper;
        $student = $helper->seedPart(request()->data);

        return response()->json([
            'success' => true,
            'message' => 'Part seeded'
        ]);
    }
}
