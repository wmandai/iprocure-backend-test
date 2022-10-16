<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserAction
{
    public function save(array $validatedData)
    {
        return DB::transaction(
            function () use ($validatedData) {
                return User::create($validatedData);
            }
        );
    }

    public function update(User $user, array $validatedData)
    {
        return DB::transaction(
            function () use ($user, $validatedData) {
                return $user->update($validatedData);
            }
        );
    }

    public function delete(User $user)
    {
        return DB::transaction(
            function () use ($user): void {
                $user->delete();
            }
        );
    }
}
