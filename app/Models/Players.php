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

    public function transfer() {
        return $this->hasMany(Transfers::class, 'player_id');
    }

    public function titles() {
        return $this->hasMany(Players_titles::class);
    }
}
