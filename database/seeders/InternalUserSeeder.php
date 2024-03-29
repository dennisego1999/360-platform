<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InternalUserSeeder extends Seeder
{
    private array $users = [
        [
            'first_name' => 'Dennis',
            'last_name' => 'Ego',
            'email' => 'dennis.ego@artcoresociety.com',
            'password' => 'Arty007*',
            'roles' => ['super_admin'],
        ],
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@artcoresociety.com',
            'password' => 'Arty007*',
            'roles' => ['editor'],
        ],
        [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@artcoresociety.com',
            'password' => 'Arty007*',
            'roles' => ['visitor'],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUsers();
    }

    private function createUsers(): void
    {
        foreach ($this->users as $user) {
            // Skip if the user already exists
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            // Create the user
            $this->createUser($user);
        }
    }

    private function createUser(array $user): void
    {
        // Create the user
        $userModel = User::factory()->create([
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'] ?? null,
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);

        // Give the user the correct roles
        $userModel->syncRoles($user['roles'] ?? []);

        // Save the user
        $userModel->saveQuietly();
    }
}
