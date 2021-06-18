<?php

namespace App\Http\Controllers\FacultyInfoControllers;

use App\Http\Controllers\Controller;
use App\Helpers\FacultyInfoHelpers\AnnouncementHelpers\Index;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Requests\AnnounementRequests\Create;

class AnnouncementsController extends Controller
{
    public function index(Request $request)
    {
        $helper = new Index([
            'search_phrase' => $request->search_phrase,
            'validity' => $request->validity,
            'semester' => $request->semester,
            'year' => $request->year
        ]);

        return view('faculty-info.announcements.index', [
            'announcements' => $helper->findAnnouncements()
        ]);
    }

    public function create()
    {
        return view('faculty-info.announcements.action');
    }

    public function store(Create $request)
    {
        $annoncement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'keywords' => $request->keywords,
            'enterprise_parts' => $request->announcement_target,
            'run' => $request->year . "_" . $request->semester,
            'valid_till' => $request->valid_till,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement successfully posted!'
        ]);
    }

    public function edit(Announcement $announcement, Request $request)
    {
        return view('faculty-info.announcements.action', [
            'announcement' => $announcement
        ]);
    }

    public function update(Announcement $announcement, Request $request)
    {
        $announcement->title = $request->title;
        $announcement->content = $request->content;
        $announcement->keywords = $request->keywords;
        $announcement->enterprise_parts = $request->announcement_target;
        $announcement->run = $request->year . "_" . $request->semester;
        $announcement->valid_till = $request->valid_till;
        $announcement->save();

        return response()->json([
            'success' => true,
            'message' => 'Announcement successfully updated!'
        ]);
    }
}
