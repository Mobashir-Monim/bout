<?php

namespace App\Http\Controllers\PlatformAccessControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use App\Helpers\PlatformAccessHelpers\SBoutHelper;

class SBoutController extends Controller
{
    public function login(Request $request)
    {
        $helper = new SBoutHelper('login', $request);
    }
}
