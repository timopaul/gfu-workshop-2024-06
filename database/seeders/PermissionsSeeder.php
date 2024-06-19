<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableNames = config('permission.table_names');

        $data = [
            [
                'name' => 'index-users',
                'guard_name' => 'web',
                'roles' => [
                    'Admin',
                ],
            ],
            [
                'name' => 'create-users',
                'guard_name' => 'web',
                'roles' => [
                    'Admin',
                ],
            ],
            [
                'name' => 'edit-users',
                'guard_name' => 'web',
                'roles' => [
                    'Admin',
                ],
            ],
            [
                'name' => 'remove-users',
                'guard_name' => 'web',
                'roles' => [
                    'Admin',
                ],
            ],
        ];

        foreach ($data as $permissionData) {

            $builder = DB::table($tableNames['permissions'])
                ->where('name', '=', $permissionData['name'])
                ->where('guard_name', '=', $permissionData['guard_name']);
            if (0 < $builder->count()) {
                continue;
            }

            $roles = $permissionData['roles'];
            unset($permissionData['roles']);
            DB::table($tableNames['permissions'])->insert($permissionData);

            /** @var Permission $permission */
            $permission = Permission::where('name', '=', $permissionData['name'])
                ->where('guard_name', '=', $permissionData['guard_name'])
                ->firstOrFail();

            foreach ($roles as $roleName) {
                /** @var Role $role */
                $role = Role::where('name', '=', $roleName)
                    ->where('guard_name', '=', $permissionData['guard_name'])
                    ->firstOrFail();
                $role->givePermissionTo($permission);
            }
        }
    }
}
