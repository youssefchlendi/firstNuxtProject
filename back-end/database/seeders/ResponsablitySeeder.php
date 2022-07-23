<?php

namespace Database\Seeders;

use App\Models\Responsability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponsablitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Responsability::create([
            'name' => 'مسئوول عن الاعلام',
            'ename' => 'media-manager',
        ]);
        Responsability::create([
            'name' => 'مسئوول عن الأثاث',
            'ename' => 'materiel-manager',
        ]);
        Responsability::create([
            'name' => 'امين مال',
            'ename' => 'money-manager',
        ]);
    }
}
