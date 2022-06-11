<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::insert([
            [
                "name" => "PPerez",
                "age" => 22,
                "salary_base" => 600,
                'address' => 'prueba',
                "id_administrador" => 1,
                "id_branch" => 1,
                "created_at" => now(),
            ],
            [
                "name" => "William",
                "age" => 27,
                "salary_base" => 650,
                'address' => 'prueba',
                "id_administrador" => 2,
                "id_branch" => 2,
                "created_at" => now(),
            ],
            [
                "name" => "Tzec",
                "age" => 30,
                "salary_base" => 850,
                'address' => 'prueba',
                "id_administrador" => 1,
                "id_branch" => 2,
                "created_at" => now(),
            ],
            [
                "name" => "Oscar",
                "age" => 29,
                "salary_base" => 1200,
                'address' => 'prueba',
                "id_administrador" => 3,
                "id_branch" => 3,
                "created_at" => now(),
            ],
        ]);
    }
}
