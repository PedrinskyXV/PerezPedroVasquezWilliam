<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::insert([
            [
                "name" => "Sucursal 1",
                "address" => 'La alameda enrique araujo',
                "created_at" => now(),
            ],
            [
                "name" => "Sucursal 2",
                "address" => 'Mejicanos calle 24 pjs 35',
                "created_at" => now(),
            ],
            [
                "name" => "Sucursal 3",
                "address" => 'Tercera etapa merliot, Santa tecla',
                "created_at" => now(),
            ],
            [
                "name" => "Sucursal 4",
                "address" => 'Antiguo...',
                "created_at" => now(),
            ],
        ]);
    }
}
