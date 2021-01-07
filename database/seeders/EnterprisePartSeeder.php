<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnterprisePart;
use App\Models\User;
use \DB;

class EnterprisePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parts = [
            ['name' => 'Vice Chancellor\'s Office', 'user_id' => $this->getUserID('vincent@bracu.ac.bd')],
            ['name' => 'Online Learning Team', 'user_id' => $this->getUserID('majumdar@bracu.ac.bd')],
            ['name' => 'School of Data and Sciences', 'user_id' => $this->getUserID('majumdar@bracu.ac.bd')],
            ['name' => 'Department of Computer Science and Engineering', 'user_id' => $this->getUserID('skazi@bracu.ac.bd')],
            ['name' => 'Department of Mathematics and Natural Sciences', 'user_id' => $this->getUserID('yusuf.haider@bracu.ac.bd')],
            ['name' => 'Department of Architecture', 'user_id' => $this->getUserID('zainab@bracu.ac.bd')],
            ['name' => 'Brac Institute of Languages', 'user_id' => $this->getUserID('sarwat@bracu.ac.bd')],
            ['name' => 'Department of Economics and Social Sciences', 'user_id' => $this->getUserID('pforet@bracu.ac.bd')],
            ['name' => 'Department of English and Humanities', 'user_id' => $this->getUserID('fazim@bracu.ac.bd')],
            ['name' => 'Department of Electrical and Electronic Engineering', 'user_id' => $this->getUserID('shahidul.khan@bracu.ac.bd')],
            ['name' => 'Department of Pharmacy', 'user_id' => $this->getUserID('eva.kabir@bracu.ac.bd')],
            ['name' => 'School of Law', 'user_id' => $this->getUserID('kshamsuddin@bracu.ac.bd')],
            ['name' => 'Brac Business School', 'user_id' => $this->getUserID('lee.sang@bracu.ac.bd')],
            ['name' => 'Graduate School of Management', 'user_id' => $this->getUserID('eileen.peacock@bracu.ac.bd')],
            ['name' => 'BRAC Institute of Governance and Development', 'user_id' => $this->getUserID('erum.m@brac.net')],
            ['name' => 'School of General Education', 'user_id' => $this->getUserID('shuq@bracu.ac.bd')],
            ['name' => 'School of Humanities and Social Sciences', 'user_id' => $this->getUserID('pforet@bracu.ac.bd')],
            ['name' => 'Super Admin', 'user_id' => $this->getUserID('mobashir.monim@bracu.ac.bd')]
        ];

        $connections = [
            1 => [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
            2 => [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
            3 => [4,5],
            17 => [8,9],
            18 => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]
        ];

        foreach ($parts as $key => $part) {
            EnterprisePart::create(['name' => strtoupper($part['name']), 'user_id' => $part['user_id']]);
        }

        foreach ($connections as $key => $rels) {
            foreach ($rels as $k => $rel) {
                DB::table('enterprise_part_relationships')->insert([
                    'parent_id' => $key,
                    'child_id' => $rel,
                ]);
            }
        }
    }

    public function getUserID($email)
    {
        return User::where('email', $email)->first()->id;
    }
}
