<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\Auth\GoogleAuthHelper as GAH;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        dd(Socialite::driver('google')->with(['hd' => 'bracu.ac.bd']));
        return Socialite::driver('google')->with(['hd' => 'bracu.ac.bd'])->redirect();
    }

    public function handleGoogleCallback()
    {
        $helper = new GAH;

        try {
            $user = Socialite::driver('google')->user();

            if(!$helper->userExists($user->id) && $helper->belongsToOrg($user->email)){
                $helper->createUser($user);
            }

            $redirect_info = $helper->getRedirectInfo();
            $this->flashMessage($redirect_info->status, $redirect_info->message);

            return redirect(route($redirect_info->route))->with($redirect_info->status, $redirect_info->message);
        } catch (Exception $e) {
            dd($e->getMessage());
            $helper->showErrorPage();
        }
    }
}
