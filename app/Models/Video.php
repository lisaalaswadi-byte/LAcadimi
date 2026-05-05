<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable=[
        "video","title","catigory_id"
    ];
    public function catigory(){
        return $this->belongsTo(Catigory::class);
    }
}
