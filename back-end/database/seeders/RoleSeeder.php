<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'superAdmin',
            'ename' => 'Super Admin',
        ]);
        Role::create([
            'name' => 'قيادة الفوج',
            'ename' => 'Leadership',
        ]);
        Role::create([
            'name' => 'قائد وحدة',
            'ename' => 'Unit Leader',
        ]);
        Role::create([
            'name' => 'ملازم قائد وحدة',
            'ename' => 'Unit Sub Leader',
        ]);
        Role::create([
            'name' => 'معين قائد وحدة',
            'ename' => 'Unit Assigned Leader',
        ]);

        Role::create([
            'name' => 'فرد',
            'ename' => 'Member',
        ]);

        Role::create([
            'name' => 'ولي',
            'ename' => 'Parent',
        ]);

        // Role::factory(4)->create();
    }
}
