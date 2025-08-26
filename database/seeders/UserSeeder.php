<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamA = Team::where('name', 'Team A')->first();
        $teamB = Team::where('name', 'Team B')->first();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'super@grand.test',
                'password' => Hash::make('password'),
                'role' => UserRole::SUPER_ADMIN,
                'team_id' => $teamA->id,
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@grand.test',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'team_id' => $teamA->id,
                'is_active' => true,
                'is_admin' => true,
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@grand.test',
                'password' => Hash::make('password'),
                'role' => UserRole::STAFF,
                'team_id' => $teamB->id,
                'is_active' => true,
                'is_admin' => false,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
