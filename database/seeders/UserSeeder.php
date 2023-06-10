<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =    User::create([
            'name' => 'Ahmad atef nouh',
            'email' => 'admin@gmail.com',
            'phone' => '+97-597701597',
            'salary' => 4000,
            'workdays' => '',
            'Worktime' => '',
            'marital_status' => 'single',
            'email_verified_at' => now(),
            'password' =>  Hash::make('password'),



        ]);
        Role::create([
            'name' => 'admin', 'guard_name' => 'web'
        ]);
        $user->assignRole('admin');
    }
}