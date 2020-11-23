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

    public function userExists($google_id)
    {
        $this->user = User::where('google_id', $google_id)->first();
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

    public function getRedirectInfo()
    {
        if ($this->will_login) {
            Auth::login($this->user);

            return (object) ['route' => $this->user_authorized_route, 'message' => 'Welcome ' . $this->user->name . '!', 'status' => 'success'];
        }

        return (object) ['route' => $this->user_unauthorized_route, 'message' => 'This application can only be accessed with emails of @bracu.ac.bd domain.', 'status' => 'error'];
    }

    public function showErrorPage()
    {
        return 'tbd';
    }
}