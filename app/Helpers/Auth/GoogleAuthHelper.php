<?php

namespace App\Helpers\Auth;

use App\Helpers\Helper;
use App\Models\User;
use Auth;

class GoogleAuthHelper extends Helper
{
    private $will_login = false;
    private $user = null;
    private $user_authorized_route = 'home';
    private $user_unauthorized_route = 'login';

    public function userExists($email)
    {
        $this->user = User::where('email', $email)->first();
        $this->will_login = !is_null($this->user);

        return $this->will_login;
    }

    public function belongsToOrg($email)
    {
        return $this->endsWith($email, '@bracu.ac.bd');
    }

    public function createUser($google_user)
    {
        $this->user = User::create([
            'name' => $google_user->name,
            'email' => $google_user->email,
            'google_id'=> $google_user->id,
            'password' => encrypt('')
        ]);

        $this->will_login = !is_null($this->user);
    }

    public function getRedirectInfo($google_user)
    {
        if ($this->will_login) {
            Auth::login($this->user);
            if ($google_user->name != $this->user->name) {
                $this->user->name = $google_user->name;
                $this->user->save();
            }

            return (object) ['route' => redirect()->intended()->getTargetUrl(), 'message' => 'Welcome ' . $this->user->name . '!', 'status' => 'success'];
        }

        return (object) ['route' => $this->user_unauthorized_route, 'message' => 'This application can only be accessed with emails of @bracu.ac.bd domain.', 'status' => 'error'];
    }

    public function showErrorPage()
    {
        return 'tbd';
    }
}