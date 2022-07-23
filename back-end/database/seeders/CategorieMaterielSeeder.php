<?php

namespace Database\Seeders;

use App\Models\CategorieMateriel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieMaterielSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategorieMateriel::factory()->count(10)->create();
    }
}
