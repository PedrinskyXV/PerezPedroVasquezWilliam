<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::insert([
            [
                "name" => "Root",
                "email" => "root@gmail.com",
                "email_verified_at" => now(),
                "password" => bcrypt("0000"),
                "created_at" => now(),
            ],            
        ]);

        
        $user->assignRole('Root');
    }
}
