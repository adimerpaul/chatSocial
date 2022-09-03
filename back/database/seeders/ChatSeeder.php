<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chats')->insert([
            ["message"=>"Hola","fecha"=>"2022-08-24 10:00:00","userEnviado_id"=>1,"userRecibido_id"=>2],
            ["message"=>"Como estas","fecha"=>"2022-08-24 10:00:00","userEnviado_id"=>2,"userRecibido_id"=>1],
        ]);
    }
}
