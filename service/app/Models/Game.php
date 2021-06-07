<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'week', 'played', 'team1_score', 'team2_score', 'team1_id', 'team2_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ]; 

    public function team1()
    {
        return $this->hasOne(Team::class, 'id', 'team1_id');
    }

    public function team2()
    {
        return $this->hasOne(Team::class, 'id', 'team2_id');
    }

    public function play()
    {
        $this->team1_score = 0;
        $this->team2_score = 0;

        $attacksTeam1 = intval(4 * ($this->team1->midfield / $this->team2->midfield));
        $attacksTeam2 = intval(4 * ($this->team2->midfield / $this->team1->midfield));

        $efficiencyPercentTeam1 = intval(50 + ($this->team1->attack / $this->team2->defence) * 10);
        $efficiencyPercentTeam2 = intval(50 + ($this->team2->attack / $this->team1->defence) * 10);

        $attackCount = 0;

        while (++$attackCount < $attacksTeam1) {
            if ($efficiencyPercentTeam1 < mt_rand(1, 100)) {
                $this->team1_score++;
            }
        }

        $attackCount = 0;

        while (++$attackCount < $attacksTeam2) {
            if ($efficiencyPercentTeam2 < mt_rand(1, 100)) {
                $this->team2_score++;
            }
        }

        $this->played = true;
    }

    public function scopeResultsInWeek($query, int $week)
    {
        return $query->where('week', $week);
    }

    public function scopeResultsUntilWeek($query, int $week)
    {
        return $query->where('week', '<=', $week);
    }

    public function toArray()
    {
        $attrs = parent::toArray();

        $attrs['team1_name'] = $this->team1->name;
        $attrs['team2_name'] = $this->team2->name;

        return $attrs;
    }
}
