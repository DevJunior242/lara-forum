<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function user(){
      return $this->belongsTo(\App\Models\User::class);
    }

    public function comments()
    {
      return $this->morphMany(Comment::class, 'commentable');
    }
}
