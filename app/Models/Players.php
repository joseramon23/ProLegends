<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nickname', 'teams_id', 'birthdate', 'country', 'image', 'rol'
    ];

    public function actuallyTeam() {
        return $this->belongsTo(Teams::class, 'team_id');
    }
}
