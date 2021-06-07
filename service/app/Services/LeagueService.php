<?php

namespace App\Services;

use App\Entities\TableResult;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class LeagueService
{
    public function getResults(int $week)
    {
        return Game::resultsInWeek($week)->get();
    }

    public function getTable(int $week)
    {
        $resultsUntil = Game::resultsUntilWeek($week)->get();
        $tableRows = [];

        foreach (Team::all() as $team) {
            $tableRows[$team->id] = new TableResult($team->id, $team->name);
        }

        foreach ($resultsUntil as $result) {
            $tableRows[$result->team1_id]->addResult($result->team1_score, $result->team2_score);
            $tableRows[$result->team2_id]->addResult($result->team2_score, $result->team1_score);
        }

        return $tableRows;
    }

    public function restart()
    {
        DB::table('games')->truncate();
        $teamIds = array_column(Team::all('id')->toArray(), 'id');
        $teamMeetings = [];
        shuffle($teamIds);
        $weekCount = count($teamIds) - 1;

        for ($week = 1; $week <= $weekCount; $week++) {
            $teamIdsForWeek = $teamIds;
            $team1 = array_pop($teamIdsForWeek);

            for ($teamCounter = 0; $teamCounter < count($teamIds); $teamCounter++) {
                $team2 = array_slice($teamIdsForWeek, $teamCounter, 1)[0];

                if (!isset($teamMeetings[$team1][$team2]) && !isset($teamMeetings[$team2][$team1])) {
                    $teamMeetings[$team1][$team2] = true;
                    $teamMeetings[$team2][$team1] = true;
                    array_splice($teamIdsForWeek, $teamCounter, 1);

                    $this->saveGames($week, $team1, $team2, $teamIdsForWeek);
                    break;
                }
            }
        }
    }

    protected function saveGames($week, $team1, $team2, &$teamIdsForWeek)
    {
        $game = new Game([
            'week' => $week,
            'played' => false,
            'team1_score' => 0,
            'team2_score' => 0,
            'team1_id' => $team1,
            'team2_id' => $team2,
        ]);
        $game->save();

        $game = new Game([
            'week' => $week,
            'played' => false,
            'team1_score' => 0,
            'team2_score' => 0,
            'team1_id' => array_pop($teamIdsForWeek),
            'team2_id' => array_pop($teamIdsForWeek),
        ]);
        $game->save();
    }
}
