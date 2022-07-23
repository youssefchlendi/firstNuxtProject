<?php

namespace Database\Seeders;

use App\Models\Troupe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Troupe::create(['name' => 'فرقة اشبال البساتين', 'description' => 'فرقة اشبال البساتين', 'gender' => 'H', 'min_age' => 6,'max_age'=>11]);
        Troupe::create(['name' => 'فرقة اشبال الروابي', 'description' => 'فرقة اشبال الروابي', 'gender' => 'H', 'min_age' => 6,'max_age'=>11]);
        Troupe::create(['name' => 'باقة زهرات البنفسج', 'description' => 'باقة زهرات البنفسج', 'gender' => 'F', 'min_age' => 6,'max_age'=>11]);
        Troupe::create(['name' => 'فرقة منصف الزناتي', 'description' => 'فرقة منصف الزناتي', 'gender' => 'H', 'min_age' => 12,'max_age'=>18]);
        Troupe::create(['name' => 'فرقة زينب للمرشدات', 'description' => 'فرقة زينب للمرشدات', 'gender' => 'F', 'min_age' => 12,'max_age'=>18]);
    }
}
