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
        User::create(['name' => 'Mobashir Monim', 'password' => bcrypt(''), 'email' => 'ext.mobashir.monim@bracu.ac.bd']);
        User::create(['name' => 'Mahbubul Alam Majumdar', 'password' => bcrypt(''), 'email' => 'majumdar@bracu.ac.bd']);
        User::create(['name' => 'Sadia Hamid Kazi', 'password' => bcrypt(''), 'email' => 'skazi@bracu.ac.bd']);
        User::create(['name' => 'Yusuf Haider', 'password' => bcrypt(''), 'email' => 'yusuf.haider@bracu.ac.bd']);
        User::create(['name' => 'Zainab', 'password' => bcrypt(''), 'email' => 'zainab@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'lreshmin@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'pforet@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'fazim@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'shahidul.khan@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'eva.kabir@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'kshamsuddin@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'vincent@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'lee.sang@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'eileen.peacock@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'mahboob.morshed@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'shuq@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'erum.m@brac.net']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'sarwat@bracu.ac.bd']);
        User::create(['name' => 'Arif Shakil', 'password' => bcrypt(''), 'email' => 'arif.shakil@bracu.ac.bd']);
        User::create(['name' => 'MD Tanzim Reza', 'password' => bcrypt(''), 'email' => 'tanzim.reza@bracu.ac.bd']);
        User::create(['name' => 'Annajiat Alim Rasel', 'password' => bcrypt(''), 'email' => 'annajiat@bracu.ac.bd']);
        User::create(['name' => 'Warida Rashid', 'password' => bcrypt(''), 'email' => 'warida.rashid@bracu.ac.bd']);
    }
}
