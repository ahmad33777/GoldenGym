<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $perm  = [
            'إنشاء موظف',
            'تعديل موظف',
            'حذف موظف',
            'إنشاء صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',
        ];
     

        foreach ($perm  as $p) {
            Permission::create([
                'name' => $p, 'guard_name' => 'web'
            ]);
        }

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
