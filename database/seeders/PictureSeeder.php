<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pictures')->insert([
            'title' => 'Nandhaka Pieris',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'img'=>'img/landscape1.jpg',
            'created_at'=>'2015-05-01',
            'featured'=>true,
            'album_id'=>1,
        ]);
        DB::table('pictures')->insert([
            'title' => 'New West Calgary',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'img'=>'img/landscape2.jpg',
            'created_at'=>'2016-05-01',
            'featured'=>false,
            'album_id'=>1,
        ]);
        DB::table('pictures')->insert([
            'title' => 'Australian Landscape',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'img'=>'img/landscape3.jpg',
            'created_at'=>'2016-05-02',
            'featured'=>false,
            'album_id'=>1,
        ]);
        DB::table('pictures')->insert([
            'title' => 'Halvergate Marsh',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'img'=>'img/landscape4.jpg',
            'created_at'=>'2014-04-01',
            'featured'=>true,
            'album_id'=>1,
        ]);
        DB::table('pictures')->insert([
            'title' => 'Rikkis Landscape',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'img'=>'img/landscape5.jpg',
            'created_at'=>'2010-09-01',
            'featured'=>false,
            'album_id'=>1,
        ]);
        DB::table('pictures')->insert([
            'title' => 'Kiddi Kristjans Iceland',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'img'=>'img/landscape6.jpg',
            'created_at'=>'2015-07-21',
            'featured'=>true,
            'album_id'=>1,
        ]);
    }
}
