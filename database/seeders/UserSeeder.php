<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::insert([
            [
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "email_verified_at" => now(),
                "password" => bcrypt("1234"),
                "created_at" => now(),
            ],
            [
                "name" => "Admin2",
                "email" => "admin2@gmail.com",
                "email_verified_at" => now(),
                "password" => bcrypt("1234"),
                "created_at" => now(),
            ],
            [
                "name" => "Admin3",
                "email" => "admin3@gmail.com",
                "email_verified_at" => now(),
                "password" => bcrypt("1234"),
                "created_at" => now(),
            ],
            [
                "name" => "Admin4",
                "email" => "admin4@gmail.com",
                "email_verified_at" => now(),
                "password" => bcrypt("1234"),
                "created_at" => now(),
            ]
        ]);
    }
}
