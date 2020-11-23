<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Mobashir Monim', 'password' => bcrypt(''), 'email' => 'mobashir.monim@bracu.ac.bd']);
        User::create(['name' => 'Mahbubul Alam Majumdar', 'password' => bcrypt(''), 'email' => 'majumdar@bracu.ac.bd']);
        User::create(['name' => 'Sadia Hamid Kazi', 'password' => bcrypt(''), 'email' => 'skazi@bracu.ac.bd']);
        User::create(['name' => 'Arif Shakil', 'password' => bcrypt(''), 'email' => 'arif.shakil@bracu.ac.bd']);
        User::create(['name' => 'MD Tanzim Reza', 'password' => bcrypt(''), 'email' => 'tanzim.reza@bracu.ac.bd']);
        User::create(['name' => 'Annajiat Alim Rasel', 'password' => bcrypt(''), 'email' => 'annajiat@bracu.ac.bd']);
        User::create(['name' => 'Warida Rashid', 'password' => bcrypt(''), 'email' => 'warida.rashid@bracu.ac.bd']);
    }
}
