<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LeagueIndexRequest;
use App\Services\LeagueService;
use App\Services\PredictionService;
use App\Services\TableRendererJsonService;

class LeagueController extends Controller
{
    private $leagueService;
    private $predictionService;

    public function __construct()
    {
        $this->leagueService = new LeagueService();
        $this->predictionService = new PredictionService();
    }
    
    public function index(LeagueIndexRequest $request)
    {
        $week = $request->get('week');
        $tableRows = $this->leagueService->getTable($week);
        $this->predictionService->setForRows($week, $tableRows);

        return response()->json([
            'results' => $this->leagueService->getResults($week), 
            'table'   => TableRendererJsonService::run($tableRows),
        ]);
    }

    public function store()
    {
        $this->leagueService->restart();

        return response()->json(['message' => 'success']);
    }
}
