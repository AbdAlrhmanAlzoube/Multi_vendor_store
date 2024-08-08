<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Abdalrhman Alzobi',
            'password'=>Hash::make('password'),  //google 
            'email'=>'abd@gmail.com',
            'phone_number'=>'0992938066',

        ]); 
        // ممككن اواجه اواجه جدول بدون موديل كيف بدي عالح هالشي؟؟
       // بقوم بانشاء من نوع كويري بلدر
       DB::table('users')->insert([
        'name'=>'abd',
        'password'=>Hash::make('password'),  //google 
        'email'=>'abdalrhman@gmail.com',
        'phone_number'=>'099293806',

       ]);

    }

     


}
