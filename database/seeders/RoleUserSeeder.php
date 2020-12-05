<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use \DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $connections = [
            'mobashir.monim@bracu.ac.bd' => ['super-admin', 'bux-support'],
            'ext.mobashir.monim@bracu.ac.bd' => ['bux-support'],
            'vincent@bracu.ac.bd' => ['vc'],
            'majumdar@bracu.ac.bd' => ['dean', 'online-learning-chair'],
            'skazi@bracu.ac.bd' => ['chair'],
            'yusuf.haider@bracu.ac.bd' => ['chair'],
            'zainab@bracu.ac.bd' => ['dean'],
            'sarwat@bracu.ac.bd' => ['dean'],
            'pforet@bracu.ac.bd' => ['dean'],
            'fazim@bracu.ac.bd' => ['chair'],
            'shahidul.khan@bracu.ac.bd' => ['chair'],
            'eva.kabir@bracu.ac.bd' => ['dean'],
            'lee.sang@bracu.ac.bd' => ['dean'],
            'eileen.peacock@bracu.ac.bd' => ['dean'],
            'shuq@bracu.ac.bd' => ['dean'],
            'erum.m@brac.net' => ['dean'],
        ];

        foreach ($connections as $email => $cons) {
            foreach ($cons as $k => $name) {
                DB::table('role_user')->insert([
                    'user_id' => $this->getUserID($email),
                    'role_id' => $this->getRoleID($name),
                ]);
            }
        }
    }

    public function getUserID($email)
    {
        return User::where('email', $email)->first()->id;
    }

    public function getRoleID($name)
    {
        return Role::where('name', $name)->first()->id;
    }
}
