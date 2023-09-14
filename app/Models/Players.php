<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'nickname', 'team_id', 'birthdate', 'country', 'image', 'rol'
    ];

    public function transfers() {
        return $this->hasMany(Teams::class, 'player_id');
    }
}
