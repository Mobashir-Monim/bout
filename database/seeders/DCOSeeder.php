<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DCOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $connections = [
            'a.froza@bracu.ac.bd' => ['dco'],
            'chroy@bracu.ac.bd' => ['dco'],
            'saiduzzaman@bracu.ac.bd' => ['dco'],
            'tnokrek@bracu.ac.bd' => ['dco'],
            'asma_ahmed@bracu.ac.bd' => ['dco'],
            'shahnoor@bracu.ac.bd' => ['dco'],
            'mostak@bracu.ac.bd' => ['dco'],
            'rezwanur.rahman@bracu.ac.bd' => ['dco'],
            'shahin@bracu.ac.bd' => ['dco'],
            'satyajit@bracu.ac.bd' => ['dco'],
            'rokeya@bracu.ac.bd' => ['dco'],
            'rukhsana.hasin@bracu.ac.bd' => ['dco'],
            'gm.zilani@bracu.ac.bd' => ['dco'],
            'anis.sharif@bracu.ac.bd' => ['dco'],
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
        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            $user = User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => $email]);
        }

        return $user->id;
    }

    public function getRoleID($name)
    {
        return Role::where('name', $name)->first()->id;
    }
}
