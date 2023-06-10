<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
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
    }
}