<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert($this->getPermissions());
    }

    protected function getPermissions()
    {
        return [
            [
                'name' => 'roles_access',
                'description' => 'Allow user to view roles',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'roles_create',
                'description' => 'Allow user to create roles',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'roles_update',
                'description' => 'Allow user to update roles',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'roles_delete',
                'description' => 'Allow user to delete roles',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'products_search',
                'description' => 'Allow user to search through products',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'products_access',
                'description' => 'Allow user to view products',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'products_create',
                'description' => 'Allow user to create products',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'products_update',
                'description' => 'Allow user to update products',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'products_delete',
                'description' => 'Allow user to delete products',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'users_access',
                'description' => 'Allow user to view users',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'users_create',
                'description' => 'Allow user to create users',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'users_update',
                'description' => 'Allow user to update users',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
            [
                'name' => 'users_delete',
                'description' => 'Allow user to delete users',
                'guard_name' => 'api',
                'created_at' => '2022-10-13 15:46:00',
                'updated_at' => '2022-10-13 15:46:00',
            ],
        ];
    }
}
