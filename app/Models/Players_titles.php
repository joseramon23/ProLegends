<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players_titles extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'player_id', 'team_id', 'league_id', 'date'
    ];

    public function player() {
        return $this->belongsTo(Players::class);
    }

    public function team() {
        return $this->belongsTo(Teams::class);
    }
}
