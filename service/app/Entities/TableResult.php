<?php

namespace App\Entities;

class TableResult
{
    public const POINTS_FOR_WIN = 3;
    public const POINTS_FOR_DRAW = 1;
    public const POINTS_FOR_DEFEAT = 0;

    protected int $teamId;
    protected string $teamName;
    protected int $points;
    protected int $goalsScored;
    protected int $goalsConceded;
    protected int $wins;
    protected int $draws;
    protected int $losses;
    protected int $prediction;

    public function __construct(int $teamId, string $teamName)
    {
        $this->teamId = $teamId;
        $this->teamName = $teamName;
        $this->points = 0;
        $this->goalsScored = 0;
        $this->goalsConceded = 0;
        $this->wins = 0;
        $this->draws = 0;
        $this->losses = 0;
        $this->prediction = 0;
    }

    public function addResult($teamScore, $enemyScore)
    {
        $this->goalsScored += $teamScore;
        $this->goalsConceded += $enemyScore;

        if ($teamScore > $enemyScore) {
            $this->points += self::POINTS_FOR_WIN;
            $this->wins += 1;
        } else if ($teamScore < $enemyScore) {
            $this->points += self::POINTS_FOR_DEFEAT;
            $this->losses += 1;
        } else {
            $this->points += self::POINTS_FOR_DRAW;
            $this->draws += 1;
        }
    }

    public function addPrediction($predictionPercent)
    {
        $this->prediction = (int)$predictionPercent;
    }

    public function getData()
    {
        return [
            'team_name' => $this->teamName,
            'points' => $this->points,
            'goals_scored' => $this->goalsScored,
            'goal_difference' => $this->goalsScored - $this->goalsConceded,
            'wins' => $this->wins,
            'draws' => $this->draws,
            'losses' => $this->losses,
            'prediction' => $this->prediction
        ];
    }
}