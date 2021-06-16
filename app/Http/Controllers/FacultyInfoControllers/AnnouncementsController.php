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
        $helper = new Index($request->search_phrase);

        return view('faculty-info.announcements.index', [
            'announcements' => $helper->findAnnouncements()
        ]);
    }

    public function create()
    {
        return view('faculty-info.announcements.create');
    }

    public function store(Create $request)
    {
        $annoncement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'keywords' => $request->keywords,
            'enterprise_parts' => $request->enterprise_parts,
            'run' => $request->year . "_" . $request->semester,
            'valid_till' => $request->valid_till,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement successfully posted!'
        ]);
    }
}
