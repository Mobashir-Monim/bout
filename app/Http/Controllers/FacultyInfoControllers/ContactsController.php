<?php

namespace App\Http\Controllers\FacultyInfoControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\FacultyInfoHelpers\ContactsHelper;

class ContactsController extends Controller
{
    public function index()
    {
        $helper = new ContactsHelper;

        return view('faculty-info.contacts.index', [
            'dco_parts' => $helper->compileDCOs(),
            'pco_parts' => $helper->compileProgramCoordinators()
        ]);
    }
}
