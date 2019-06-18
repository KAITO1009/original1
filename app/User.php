<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function book_posts()
    {
        return $this->hasMany(BookPost::class);
    }
    
    public function img_posts()
    {
        return $this->hasMany(ImgPost::class);
    }
    
    public function offered()
    {
        return $this->belongsToMany(User::class, 'offers', "offer_id", "offered_id")->withPivot("match")->withTimestamps();
    }
    
    public function is_offered()
    {
        return $this->belongsToMany(User::class, "offers", "offered_id", "offer_id")->withPivot("match")->withTimestamps();
    }
    
    
    public function offer($userId)
    {
            $exist = $this->is_offering($userId);
            
            $its_me = $this->id == $userId;
            
            if($exist || $its_me){
                return false;
            }else {
                $this->offered()->attach($userId);
                return true;
            }
    }
    
    public function refuse($userId)
    {
        $exist = $this->is_being_offered($userId);
        
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
            $this->is_offered()->detach($userId);
            
            Offer::create([
                "offer_id" => $userId,
                "offered_id" => $this->id,
                "match" => "refused",
                ]);
            
            return true;
        }else{
            return false;
        }
    }
    
    
    public function agree($userId)
    {
        $exist = $this->is_being_offered($userId);
        
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
            $this->is_offered()->detach($userId);
            
            $matching_room_id = uniqid();
            
            Offer::create([
                "offer_id" => $userId,
                "offered_id" => $this->id,
                "match" => $matching_room_id,
                ]);
                
            return true;
        }else{
            return false;
        }
        
    }
    
    public function is_offering($userId)
    {
        return $this->offered()->where("offered_id", $userId)->exists();
    }
    
    public function is_being_offered($userId)
    {
        return $this->is_offered()->where("offer_id", $userId)->exists();
    }
    
    public function is_offered_count(){
        return $offered = $this->is_offered()->where("match", null)->get()->count();
    }
}
