<?php

namespace App\Actions\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleAction
{
    public function save(array $validatedData)
    {
        return DB::transaction(
            function () use ($validatedData) {
                return Role::create($validatedData);
            }
        );
    }
    public function update(Role $role, array $validatedData)
    {
        return DB::transaction(
            function () use ($role, $validatedData) {
                return $role->update($validatedData);
            }
        );
    }

    public function delete(Role $role)
    {
        return DB::transaction(
            function () use ($role): void {
                $role->delete();
            }
        );
    }
}
