<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catigory extends Model
{
    protected $fillable=[
        "name"
    ];

    public function videos(){
        return $this->hasMany(Video::class);
    }
}
