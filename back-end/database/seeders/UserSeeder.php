<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usr = User::create(
            [
                'first_name' => 'super',
                'last_name' => 'admin',
                'email' => 'superAdmin@admin.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('name', 'superAdmin')->first(),['status'=>1]);
        $usr->save();



        $usr = User::create(
            [
                'first_name' => 'leader1',
                'last_name' => 'leader1',
                'email' => 'leader1@leader.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Unit Leader')->first(),['troupe_id'=>1]);
        $usr->save();
        $usr = User::create(
            [
                'first_name' => 'leaderm',
                'last_name' => 'leaderm',
                'email' => 'leaderm@leader.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Unit Assigned Leader')->first(),['troupe_id'=>1,'Responsability_id'=>3,'status'=>1]);
        $usr->save();

        $usr = User::create(
            [
                'first_name' => 'leaderf',
                'last_name' => 'leaderf',
                'email' => 'leaderf@leader.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Unit Assigned Leader')->first(),['troupe_id'=>1,'Responsability_id'=>2]);
        $usr->save();


        $usr = User::create(
            [
                'first_name' => 'member',
                'last_name' => 'member',
                'email' => 'member@leader.com',
                'birth_date' => '2015-01-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Member')->first(),['troupe_id'=>1]);
        $usr->save();
        $usr = User::create(
            [
                'first_name' => 'member1',
                'last_name' => 'member1',
                'email' => 'member1@leader.com',
                'birth_date' => '2014-01-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Member')->first(),['troupe_id'=>1]);
        $usr->save();
        $usr = User::create(
            [
                'first_name' => 'member2',
                'last_name' => 'member2',
                'email' => 'member2@leader.com',
                'birth_date' => '2013-01-01',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Member')->first(),['troupe_id'=>2]);
        $usr->save();

        $usr = User::create(
            [
                'first_name' => 'leader2',
                'last_name' => 'leader2',
                'email' => 'leader2@leader.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Unit Assigned Leader')->first(),['troupe_id'=>2,'responsability_id'=>2]);
        $usr->save();


        $usr = User::create(
            [
                'first_name' => 'leader3',
                'last_name' => 'leader3',
                'email' => 'leader3@leader.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ]
        );
        $usr->roless()->attach(Role::where('ename', 'Leadership')->first());
        $usr->save();


    }
}
