<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'email' => 'admin@gmail.com',
            'user_name' => 'admin',
            'role' => 2,
            'password' => bcrypt('11223344'),
            'experties' => 'Super Admin',
        ]);
    }
}
