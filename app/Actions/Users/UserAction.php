<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserAction
{
    // save user to database
    public function save(array $validatedData)
    {
        return DB::transaction(
            function () use ($validatedData) {
                $user = User::create($validatedData);
                // assign default role
                $user->syncRoles(config('system.default_role'));

                return $user;
            }
        );
    }

    // make changes to user information
    public function update(User $user, array $validatedData)
    {
        return DB::transaction(
            function () use ($user, $validatedData) {
                return $user->update($validatedData);
            }
        );
    }

    // permanently delete user
    public function delete(User $user)
    {
        return DB::transaction(
            function () use ($user): void {
                $user->delete();
                // delete all products belonging to user
                $user->products()->delete();
            }
        );
    }
}
