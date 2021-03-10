<?php

namespace App\Http\Controllers\FacultyInfoControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('faculty-info.calendar.index');
    }
}
