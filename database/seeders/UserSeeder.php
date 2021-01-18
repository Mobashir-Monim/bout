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
        User::create(['name' => 'Mohammad Mahboob Rahman', 'password' => bcrypt(''), 'email' => 'mahboob.rahman@bracu.ac.bd']);
        User::create(['name' => 'Matin S. Abdullah', 'password' => bcrypt(''), 'email' => 'mabdullah@bracu.ac.bd']);
        User::create(['name' => 'Afroza Begum', 'password' => bcrypt(''), 'email' => 'a.froza@bracu.ac.bd']);
        User::create(['name' => 'Chandan Roy', 'password' => bcrypt(''), 'email' => 'chroy@bracu.ac.bd']);
        User::create(['name' => 'Saiduzzaman Shikder', 'password' => bcrypt(''), 'email' => 'saiduzzaman@bracu.ac.bd']);
        User::create(['name' => 'Theophil Nokrek', 'password' => bcrypt(''), 'email' => 'tnokrek@bracu.ac.bd']);
        User::create(['name' => 'Asma Ahmed', 'password' => bcrypt(''), 'email' => 'asma_ahmed@bracu.ac.bd']);
        User::create(['name' => 'Allfe Shahnoor Chowdhury', 'password' => bcrypt(''), 'email' => 'shahnoor@bracu.ac.bd']);
        User::create(['name' => 'Mostak Ahmed', 'password' => bcrypt(''), 'email' => 'mostak@bracu.ac.bd']);
        User::create(['name' => 'Md Rezwanur Rahman', 'password' => bcrypt(''), 'email' => 'rezwanur.rahman@bracu.ac.bd']);
        User::create(['name' => 'Md Shahin Shaikh', 'password' => bcrypt(''), 'email' => 'shahin@bracu.ac.bd']);
        User::create(['name' => 'Satyajit Kumar Modok', 'password' => bcrypt(''), 'email' => 'satyajit@bracu.ac.bd']);
        User::create(['name' => 'Mosammat Rokeya Begum', 'password' => bcrypt(''), 'email' => 'rokeya@bracu.ac.bd']);
        User::create(['name' => 'Rukhsana Hasin Parag', 'password' => bcrypt(''), 'email' => 'rukhsana.hasin@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'gm.zilani@bracu.ac.bd']);
        User::create(['name' => ' ', 'password' => bcrypt(''), 'email' => 'anis.sharif@bracu.ac.bd']);
        
        // 'mahboob.rahman@bracu.ac.bd', 'mabdullah@bracu.ac.bd'
    }
}
