<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PlayWeekUpdateRequest;
use App\Services\GameService;

class PlayController extends Controller
{
    private $gameService;

    public function __construct()
    {
        $this->gameService = new GameService();
    }

    public function store(PlayWeekUpdateRequest $request)
    {
        if ($request->filled('week')) {
            $this->gameService->playWeek($request->input('week'));
        } else {
            $this->gameService->playAll();
        }

        return response()->json(['league' => 1]);
    }
}
