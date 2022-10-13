<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'firstName' => 'Wil',
            'lastName' => 'Mandai',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'email_verified_at' => now(),
            'phoneNumber' => '254723924858',
        ]);

        $user->syncRoles('Admin');
    }
}
