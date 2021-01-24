<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\EnterprisePart;
use \DB;

class DCOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dcos = [
            ['user' => 'a.froza@bracu.ac.bd', 'part' => 'Department of Electrical and Electronic Engineering'],
            ['user' => 'chroy@bracu.ac.bd', 'part' => 'Department of Economics and Social Sciences'],
            ['user' => 'saiduzzaman@bracu.ac.bd', 'part' => 'Department of Architecture'],
            ['user' => 'tnokrek@bracu.ac.bd', 'part' => 'School of Law'],
            ['user' => 'asma_ahmed@bracu.ac.bd', 'part' => 'Department of Pharmacy'],
            ['user' => 'shahnoor@bracu.ac.bd', 'part' => 'Department of English and Humanities'],
            ['user' => 'mostak@bracu.ac.bd', 'part' => 'Department of Mathematics and Natural Sciences'],
            ['user' => 'rezwanur.rahman@bracu.ac.bd', 'part' => 'Department of Mathematics and Natural Sciences'],
            ['user' => 'shahin@bracu.ac.bd', 'part' => 'Brac Business School'],
            ['user' => 'satyajit@bracu.ac.bd', 'part' => 'Brac Business School'],
            ['user' => 'rokeya@bracu.ac.bd', 'part' => 'Brac Institute of Languages'],
            ['user' => 'rukhsana.hasin@bracu.ac.bd', 'part' => 'Brac Institute of Languages'],
            ['user' => 'gm.zilani@bracu.ac.bd', 'part' => 'Department of Computer Science and Engineering'],
            ['user' => 'anis.sharif@bracu.ac.bd', 'part' => 'Department of Computer Science and Engineering'],
        ];

        foreach ($dcos as $dco) {
            User::find($this->getUserID($dco['user']))->memberOf()
                ->attach(EnterprisePart::where('name', $dco['part'])->first()->id);
        }

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
