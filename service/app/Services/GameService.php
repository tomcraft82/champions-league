<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    public function playWeek(int $week)
    {
        $games = Game::resultsInWeek($week)->get();

        foreach ($games as $game) {
            $game->play();
            $game->save();
        }
    }

    public function playAll()
    {
        $games = Game::all();

        foreach ($games as $game) {
            $game->play();
            $game->save();
        }
    }
}