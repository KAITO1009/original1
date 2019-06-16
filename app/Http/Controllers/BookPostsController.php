<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BookPost;

class BookPostsController extends Controller
{
    public function index(){
        $data = [];
        if(\Auth::check()){
            $book_posts = BookPost::orderBy("created_at", "desc")->paginate(9);
            
            $data = [
                "book_posts" => $book_posts,
                ];
                
            return view('content.top_book', $data);
        }
    }
    
    public function show($book_posts_id){
        $data = [];
        if(\Auth::check()){
            $book_post = BookPost::find($book_posts_id);
            
            $data = [
                "book_post" => $book_post,
                ];
                
            return view('content.info_book', $data);
            
        }
    }
    
    public function create(){
        $book_post = new BookPost;
        
        return view("content.create_book", [
            "book_post" => $book_post,
            ]);
    }
    
    public function store(Request $request){
        $this->validate($request, [
            "title" => "required|max:191",
            "content" => "required",
            "advertisement" => "required|max:191",
            ]);
        
        $request->user()->book_posts()->create([
            "title" => $request->title,
            "content" => $request->content,
            "advertisement" => $request->advertisement,
            ]);
            
        $id = \Auth::user()->id;
        
        return redirect()->route('book_posts.index');
    }
}
