<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfers extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_team_id', 'new_team_id', 'player_id', 'start', 'end', 'description'
    ];

    public function player() {
        return $this->belongsTo(Players::class, 'player_id');
    }

    public function lastTeam() {
        return $this->belongsTo(Teams::class, 'last_team_id');
    }

    public function newTeam() {
        return $this->belongsTo(Teams::class, 'new_team_id');
    }
}
