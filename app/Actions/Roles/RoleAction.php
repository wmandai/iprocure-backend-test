<?php

namespace App\Actions\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleAction
{
    // save role to database
    public function save(array $validatedData)
    {
        return DB::transaction(
            function () use ($validatedData) {
                return Role::create($validatedData);
            }
        );
    }

    // update a specific role
    public function update(Role $role, array $validatedData)
    {
        return DB::transaction(
            function () use ($role, $validatedData) {
                return $role->update($validatedData);
            }
        );
    }

    // delete a role
    public function delete(Role $role)
    {
        return DB::transaction(
            function () use ($role): void {
                $role->delete();
            }
        );
    }
}
