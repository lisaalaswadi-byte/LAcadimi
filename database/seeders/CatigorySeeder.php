<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CatigorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("catigories")->insert([
            ["name"=>"Python course"],
            ["name"=>"Flutter course"],
            ['name'=>"Athers"]
        ]);
    }
}
