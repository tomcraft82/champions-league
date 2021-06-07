<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    private array $teams = [
        [
            'name' => 'Arsenal',
            'defence' => 5,
            'midfield' => 6,
            'attack' => 6,
        ],
        [
            'name' => 'Chelsea',
            'defence' => 7,
            'midfield' => 7,
            'attack' => 6,
        ],
        [
            'name' => 'Liverpool',
            'defence' => 8,
            'midfield' => 6,
            'attack' => 8,
        ],
        [
            'name' => 'Manchester City',
            'defence' => 8,
            'midfield' => 9,
            'attack' => 6,
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->teams as $team) {
            DB::table('teams')->insert($team);
        }
    }
}
