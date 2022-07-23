<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        \App\Models\User::factory(2)->create();
        $this->call(ResponsablitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TroupeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MaterielSeeder::class);
        $this->call(CategorieMaterielSeeder::class);
        $this->call(DemandeMaterielSeeder::class);
    }
}
