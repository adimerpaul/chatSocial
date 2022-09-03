<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('admin'),
                'avatar' => 'avatar.png',
                'fechaLimite' => date('Y-m-d', strtotime(now(). ' + 360 days')),
                "fechaConexion"=>"2022-08-24 10:00:00"
            ],
            ["name"=>"BART SIMPSON","avatar"=>"bart.jpg","email"=>"bart@gmail.com","password"=>Hash::make("123"),"fechaConexion"=>"2022-08-24 10:00:00",'fechaLimite' => date('Y-m-d', strtotime(now(). ' + 360 days')),],
            ["name"=>"LISA SIMPSON","avatar"=>"lisa.jpg","email"=>"lisa@gmail.com","password"=>Hash::make("123"),"fechaConexion"=>"2022-08-24 10:00:00",'fechaLimite' => date('Y-m-d', strtotime(now(). ' + 360 days')),],
            ["name"=>"HOMERO SIMPSON","avatar"=>"homero.jpg","email"=>"homero@gmail.com","password"=>Hash::make("123"),"fechaConexion"=>"2022-08-24 10:00:00",'fechaLimite' => date('Y-m-d', strtotime(now(). ' + 360 days')),],
            ["name"=>"MARGE SIMPSON","avatar"=>"marge.jpg","email"=>"marge@gmail.com","password"=>Hash::make("123"),"fechaConexion"=>"2022-08-24 10:00:00",'fechaLimite' => date('Y-m-d', strtotime(now(). ' + 360 days')),],
        ]);
    }
}
