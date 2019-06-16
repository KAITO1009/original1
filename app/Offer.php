<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['offer_id', 'offered_id', 'match'];
    
    
}
