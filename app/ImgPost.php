<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImgPost extends Model
{
    protected $fillable = [
        "user_id", "title", "image_url","public_id"
        ];
        
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
