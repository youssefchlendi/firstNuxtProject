<?php

namespace Database\Seeders;

use App\Models\DemandeMateriel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandeMaterielSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DemandeMateriel::factory()->count(10)->create();
    }
}
