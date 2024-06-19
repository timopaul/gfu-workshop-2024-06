<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableNames = config('permission.table_names');

        $data = [
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Driver',
                'guard_name' => 'web',
            ],
        ];

        foreach ($data as $role) {

            $builder = DB::table($tableNames['roles'])
                ->where('name', '=', $role['name'])
                ->where('guard_name', '=', $role['guard_name']);
            if (0 < $builder->count()) {
                continue;
            }

            DB::table($tableNames['roles'])->insert($role);
        }


    }
}
