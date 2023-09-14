<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'league_id', 'founded', 'country', 'image'
    ];

    public function league() {
        return $this->belongsTo(Leagues::class);
    }

    public function latestTransfers() {
        return $this->hasMany(Transfers::class, 'last_team_id');
    }

    public function newTransfers() {
        return $this->hasMany(Transfers::class, 'new_team_id');
    }
}
