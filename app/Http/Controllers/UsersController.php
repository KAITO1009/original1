<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Offer;

class UsersController extends Controller
{
    public function index()
    {
        if(\Auth::check()){
            return redirect()->route('top');
        }
        return view('welcome');
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $img_posts = $user->img_posts()->orderBy("created_at", "desc")->get();
        $book_posts = $user->book_posts()->orderBy("created_at", "desc")->get();
        
        //参照したいユーザーがオファーをしている・されているユーザーの取得
        $offering_exist = $user->offered()->get();
        $is_offered_exist = $user->is_offered()->get();
        
        //ログイン中のユーザー（自分）がオファーしているか・されているオファーレコードの取得
        $me_others_offer = Offer::where("offer_id", \Auth::user()->id)->get();
        $others_me_offer = Offer::where("offered_id", \Auth::user()->id)->get(); 
        
        //matchが存在するかどうか
        $match = [];
        
        foreach($me_others_offer as $offer){
                if($offer->match && !($offer->match == "refused")){
                    $match = $offer;
                }
            }
            foreach($others_me_offer as $offer){
                if($offer->match && !($offer->match == "refused")){
                    $match = $offer;
                }
            }
        
            
        
        return view ("users.show", [
            "user" => $user,
            "img_posts" => $img_posts,
            "book_posts" => $book_posts,
            "offering_exist" => $offering_exist,
            "is_offered_exist" => $is_offered_exist,
            "me_others_offer" => $me_others_offer,
            "others_me_offer" => $others_me_offer,
            "match" => $match,
            ]);
    }
    
}
