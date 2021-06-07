<?php

namespace App\Services;

use App\Entities\TableResult;

class PredictionService
{
    public function setForRows($week, &$tableRows)
    {
        $tableRowsCount = count($tableRows);
        $numberOfWeeks = (int)($tableRowsCount * ($tableRowsCount - 1)) / 2;
        $maxPoints = TableResult::POINTS_FOR_WIN * $numberOfWeeks;
        $maxPointsToGet = TableResult::POINTS_FOR_WIN * ($numberOfWeeks - $week);
        $maxRows = count($tableRows);
        $sumPoints = 0;

        for ($rowCount = 1; $rowCount <= $maxRows; $rowCount++) {
            $pointsToGet = ($maxPoints - $tableRows[$rowCount]->getData()['points']);
            $sumPoints += 100 * ($maxPointsToGet / $pointsToGet);
        }

        for ($rowCount = 1; $rowCount <= $maxRows; $rowCount++) {
            $pointsToGet = ($maxPoints - $tableRows[$rowCount]->getData()['points']);
            $rowSumPoints = 100 * ($maxPointsToGet / $pointsToGet);

            if ($pointsToGet < $maxPointsToGet) {
                $tableRows[$rowCount]->addPrediction(0);
            } else {
                $tableRows[$rowCount]->addPrediction((int) 100 * ($rowSumPoints / $sumPoints));
            }
        }
    }
}