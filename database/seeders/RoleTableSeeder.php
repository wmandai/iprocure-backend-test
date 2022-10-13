<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert($this->getRoles());
        app()['cache']->forget('spatie.permission.cache');
        $admin = Role::where(['name' => 'Admin'])->first();
        $admin->syncPermissions(Permission::select(['name'])->get()->toArray());

        $client = Role::where(['name' => 'Customer'])->first();
        $client->syncPermissions($this->customerPermissions());
    }

    protected function customerPermissions()
    {
        return [
            'products_search',
            'products_access',
            'products_create'
        ];
    }

    protected function getRoles()
    {
        return [
            [
                'name' => 'Admin',
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer',
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
    }
}
