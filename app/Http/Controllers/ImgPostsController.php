<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JD\Cloudder\Facades\Cloudder;

use App\ImgPost;

class ImgPostsController extends Controller
{
    public function index()
    {
        $data = [];
        if(\Auth::check()){
            $img_posts = ImgPost::orderBy("created_at", "desc")->paginate(9);
            
            $data = [
                "img_posts" => $img_posts,
                ];
        }
        
        return view("content.top_manga", $data);
    }
    
    public function show($img_posts_id){
        $data = [];
        if(\Auth::check()){
            $img_post = ImgPost::find($img_posts_id);
            
            $data = [
                "img_post" => $img_post,
                ];
            
            return view("content.info_manga", $data);
            
        }
    }
    
    public function create(){
        $img_post = new ImgPost;
        
        return view("content.create_manga", [
            "img_post" => $img_post,
            ]);
    }
    
    public function store(Request $request){
        $this->validate($request,[
            "title" => "required|max:191",
            ]);
            
        
        if($request->hasFile("img")){
            $img = $request->file("img");
            $img_name = $img->getRealPath();
        
            Cloudder::upload($img_name, null);
            list($width, $height) = getimagesize($img_name);
            
            $public_id = Cloudder::getPublicId();
            
            $img_url = Cloudder::show($public_id,[
                "width" => $width,
                "height" => $height
                ]);
            
                
            $request->user()->img_posts()->create([
                "title" => $request->title,
                "image_url" => $img_url,
                "public_id" => $public_id,
                ]);
                
                $id = \Auth::user()->id;
                
                return redirect()->route('top');
        }else{
            return back();
        }
    }
    
    public function destroy($id){
        $img_post = ImgPost::find($id);
        
        if(\Auth::id() === $img_post->user_id){
            $public_id = $img_post->public_id;
            Cloudder::destroyImage($public_id);
            Cloudder::delete($public_id);
            
            $img_post->delete();
        }
        
        return redirect()->route("/");
    }
}
