<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CoursesHelpers\UpdateHelper;
use App\Models\Course;

class CoursesController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::orderBy('provider')->orderBy('code')->get();

        if ($request->has('provider')) {
            $courses = Course::where('provider', $request->provider)->orderBy('provider')->orderBy('code')->get();
        }

        return view('courses.index', [
            'courses' => $courses,
            'providers' => array_unique(Course::all()->pluck('provider')->toArray())
        ]);
    }

    public function update(Course $course, Request $request)
    {
        $helper = new UpdateHelper($course, $request->code, $request->title, $request->provider);
        $helper->update();

        flash('Successfully updated')->success();

        return back();
    }
}
