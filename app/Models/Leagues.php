<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leagues extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'region', 'founded', 'image' 
    ];

    public function teams() {
        return $this->hasMany(Teams::class, 'leagues_id');
    }
    
}
