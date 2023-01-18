<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Marco Sanabria',
            'email'=> 'ingmarcosanabria@gmail.com',
            'phone'=> '555-555-5555',
            'bio'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'profile_picture'=>'img/marco.png',
            'album_id'=>1,
            'password' => Hash::make('password'),
            'created_at'=>'2015-05-01',
        ]);

        DB::table('users')->insert([
            'name' => 'Nandhaka Pieris',
            'email'=> 'nick.reynolds@domain.co',
            'phone'=> '555-555-5555',
            'bio'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'profile_picture'=>'img/profile.png',
            'album_id'=>1,
            'password' => Hash::make('password'),
            'created_at'=>'2015-05-02',
        ]);
    }
}
