<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserOfferController extends Controller
{
    public function offer($id){
        \Auth::user()->offer($id);
        
        return back();
    }
    
    public function refuse($id){
        \Auth::user()->refuse($id);
        
        return back();
    }
    
    public function agree($id){
        \Auth::user()->agree($id);
        
        return back();
    }
    
    public function chat($roomid,$me,$you){
        
        return view("content.chat",[
           "roomid" => $roomid,
           "me" => $me,
           "you" => $you,
           ]);
   }
}
