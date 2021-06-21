<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\FacultyInfoHelpers\AnnouncementHelpers\Index as AnnouncementHelper;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $helper = new AnnouncementHelper(['search_phrase' => null, 'validity' => null, 'semester' => null, 'year' => null]);
        
        return view('home', [
            'announcements' => $helper->findAnnouncements()
        ]);
    }

    public function descriptionBuilder()
    {
        return view('description-builder.index');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $user->phone = $request->phone;
        $user->show_phone = $request->show_phone;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully updated phone and phone discoverability.'
        ]);
    }

    public function loginAs(Request $request)
    {
        $user = User::where('email', request()->email)->first();

        if (is_null($user)) {
            flash('User does not exist on system')->error();
            return redirect()->back();
        }

        Auth::login($user);
        return redirect(route('home'));
    }
}
