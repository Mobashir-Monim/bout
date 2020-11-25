<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvalController extends Controller
{
    public function index()
    {
        return view('eval.index');
    }

    public function report($report)
    {
        if ($report != 'dept' && $report != 'course' && $report != 'section') {
            $this->flashMessage('error', 'The report that you are trying to access does not exist 👽👽👽');
            return back();
        }

        return view("eval.reports.$report-template");
    }
}
