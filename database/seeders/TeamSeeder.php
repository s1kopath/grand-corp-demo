<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'Team A'],
            ['name' => 'Team B'],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
