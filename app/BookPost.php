<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookPost extends Model
{
    protected $fillable = ["user_id", "title", "content", "advertisement"];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
