<?php

namespace App\Services;

class TableRendererJsonService
{
    public static function run(array $tableRows)
    {
        $jsonItems = [];

        foreach ($tableRows as $row)
        {
            $jsonItems[] = $row->getData();
        }

        usort($jsonItems, 'self::compareRows');

        return $jsonItems;
    }

    public static function compareRows(array $row1, array $row2)
    {
        if ($row1['points'] < $row2['points']) {
            return true;
        } elseif ($row1['points'] > $row2['points']) {
            return false;
        } else {
            if ($row1['goal_difference'] < $row2['goal_difference']) {
                return true;
            } elseif ($row1['goal_difference'] > $row2['goal_difference']) {
                return false;
            } else {
                if ($row1['goals_scored'] < $row2['goals_scored']) {
                    return true;
                } elseif ($row1['goals_scored'] > $row2['goals_scored']) {
                    return false;
                }
            }
        }

        return true;
    }
}