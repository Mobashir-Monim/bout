<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Passport\Client;

class SBoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'SBout',
            'email' => 'user@sbout.bracu.ac.bd',
            'password' => bcrypt('')
        ]);

        $client = Client::create([
            'user_id' => $user->id,
            'name' => 'sbout',
            'secret' => $secret = Str::random(80),
            'provider' => null,
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false
        ]);

        echo $secret;
        echo "\n";
    }
}
