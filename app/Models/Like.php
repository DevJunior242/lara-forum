<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
      }
public function comments()  
{
    return $this->belongsTo(\App\Models\Comment::class);
}
}
