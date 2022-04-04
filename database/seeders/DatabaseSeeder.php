<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => "SuperAdmin",
            'lastname' => "SuperAdmin",
            'username' => "SuperAdmin",
            'email' => 'super@admin.com',
            'is_admin' => '1',
            'password' => Hash::make('superadmin'),
            'created_at' => '2022-02-01 22:52:12'
        ]);
    }
}
