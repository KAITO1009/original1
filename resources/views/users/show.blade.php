@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
<div class="container user">
    <!--マイページ-->
    @if(Auth::user()->id == $user->id)
    <div class="row user-info">
        <img class="user-info__img" src="{{ Gravatar::src(Auth::user()->email, 500) }}" alt="">
        <h3 class="user-info__name">{{ Auth::user()->name }}</h3>
    </div>
    <div class="row ml-0">
        <h2 class="gallery-heading">投稿作品</h2>
    </div>
    <div class="nav nav-tabs">
        <a class="nav-item nav-link active" id="tab-menu1" data-toggle="tab" href="#panel-menu1" role="tab" aria-controls="panel-nenu1" aria-selected="true">小説・ライトノベル</a>
        <a class="nav-item nav-link" id="tab-menu2" data-toggle="tab" href="#panel-menu2" role="tab" aria-controls="panel-nenu2" aria-selected="false">漫画・イラスト</a>
    </div>
    
    
    <div class="tab-content" id="panel-menus">
        <div class="tab-pane fade show active border border-top-0" id="panel-menu1" role="tabpanel" aria-labelledby="tab-menu1">
            <div class="row ml-0">
                @if($book_posts->count())
                    @foreach($book_posts as $book_post)
                    <div class="book_post card">
                        <p class="book_post__advertisement card-title">{{ $book_post->advertisement }}</p>
                        <p class="book_post__title card-text">{{ $book_post->title }}</p>
                        <p class="book_post__author card-text">{{ $book_post->user()->first()->name }}</p>
                        {!! link_to_route("book_posts.show", "詳細", ["book_posts_id" => $book_post->id], ["class" => "btn btn-sm btn-outline-primary book-post__info-btn"]) !!}
                    </div>
                    @endforeach
                @else
                    <div class="post-none">
                        <p>投稿がありません</p>
                    </div>
                @endif
            </div>
            
        </div>
        <div class="tab-pane fade show border border-top-0" id="panel-menu2" role="tabpanel" aria-labelledby="tab-menu2">
            <div class="row ml-0">
                @if($img_posts->count())
                    @foreach($img_posts as $img_post)
                        <div class="img_post card">
                            <img src="{{ $img_post->image_url }}" class="img_post__img card-img-top"></img>
                            <div class="card-body">
                                <h4 class="img_post__title card-title">{{ $img_post->title }}</h4>
                                <h6 class="img_post__author card-subtitle">{{ $img_post->user()->first()->name }}</h6>
                            </div>
                            {!! link_to_route("img_posts.show", "詳細", ["img_posts_id" => $img_post->id], ["class" => "btn btn-sm btn-outline-primary img-post__info-btn"]) !!}
                        </div>
                    @endforeach
                @else
                    <div class="post-none">
                        <p>投稿がありません</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    
    
        
        
        <div class="offer mt-5">
            <h2 class="offer-heading mb-3">オファー・マッチング一覧</h2>
            @if($offering_exist->count())
                @foreach($offering_exist as $offering_user)
                    @if($user->offered()->where("offer_id", $user->id)->where("offered_id", $offering_user->id)->first()->pivot->match == null)
                        <div class="offer-box row ml-0">
                            <div class="col-8">
                                {!! link_to_route("users.show", $offering_user->name, ["id" => $offering_user->id], ["class" => "offer-user-name"]) !!}
                                <span class="offer-time">{{ $user->offered()->where("offer_id", $user->id)->where("offered_id", $offering_user->id)->first()->pivot->created_at }}</span>
                            </div>
                            
                            <p class="offer-status col-4">オファー中</p>
                        </div>
                    @elseif($user->offered()->where("offer_id", $user->id)->where("offered_id", $offering_user->id)->first()->pivot->match == "refused")
                        <div class="offer-box row ml-0">
                            <div class="col-8">
                                {!! link_to_route("users.show", $offering_user->name, ["id" => $offering_user->id], ["class" => "offer-user-name"]) !!}
                                <span class="offer-time">{{ $user->offered()->where("offer_id", $user->id)->where("offered_id", $offering_user->id)->first()->pivot->created_at }}</span>
                            </div>
                            
                            <p class="offer-status col-4">オファーを断られました</p>
                        </div>
                    @endif
                @endforeach
            @endif
            @if($is_offered_exist->count())
                @foreach($is_offered_exist as $is_offered_user)
                    @if($user->is_offered()->where("offer_id", $is_offered_user->id)->where("offered_id", $user->id)->first()->pivot->match == null)
                        <div class="offer-box row ml-0">
                            <div class="col-4">
                                {!! link_to_route("users.show",  $is_offered_user->name, ["id" => $is_offered_user->id], ["class" => "offer-user-name"]) !!}
                                <span class="offer-time">{{ $user->is_offered()->where("offer_id", $is_offered_user->id)->where("offered_id", $user->id)->first()->pivot->created_at }}</span>
                            </div>
                            
                            <div class="col-8">
                                <div class="row float-right">
                                {!! Form::open(['route' => ['agree', $is_offered_user->id]]) !!}
                                {!! Form::submit('オファーを受ける', ['class' => "btn btn-outline-success btn-lg"]) !!}
                                {!! Form::close() !!}
                                {!! Form::open(['route' => ['refuse', $is_offered_user->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('オファーを断る', ['class' => "btn btn-outline-danger btn-lg"]) !!}
                                {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @elseif($user->is_offered()->where("offer_id", $is_offered_user->id)->where("offered_id", $user->id)->first()->pivot->match == "refused")
                        <div class="offer-box row ml-0">
                            <div class="col-8">
                                {!! link_to_route("users.show", $is_offered_user->name, ["id" => $is_offered_user->id], ["class" => "offer-user-name"]) !!}
                                <span class="offer-time">{{ $user->is_offered()->where("offer_id", $is_offered_user->id)->where("offered_id", $user->id)->first()->pivot->created_at }}</span>
                            </div>
                            
                            <p class="offer-status col-4">オファーを断りました</p>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>    
        <div class="matching mb-5">
            @if($match)
                @foreach($me_others_offer as $offer)
                    @if($offer->match && !($offer->match == "refused"))
                        <div class="offer-box row ml-0">
                            {!! link_to_route("users.show", App\User::find($offer->offered_id)->name, ["id" => $offer->offered_id], ["class" => "offer-user-name col-8"]) !!}
                            {!! link_to_route("chat", "チャットルーム", ["roomid" => $offer->match, "me" => $user, "you" => App\User::find($offer->offered_id)],["class" => "btn btn-lg btn-outline-primary col-4"]) !!}
                        </div>
                    @endif
                @endforeach
                @foreach($others_me_offer as $offer)
                    @if($offer->match && !($offer->match == "refused"))
                        <div class="offer-box row ml-0">
                            {!! link_to_route("users.show", App\User::find($offer->offer_id)->name, ["id" => $offer->offer_id], ["class" => "offer-user-name col-8"]) !!}
                            {!! link_to_route("chat", "チャットルーム", ["roomid" => $offer->match, "you" => App\User::find($offer->offer_id), "me" => $user],["class" => "btn btn-lg btn-outline-primary col-4"]) !!}
                        </div>
                    @endif
                @endforeach
            @elseif(!$match)
                <div class="match-none">
                    <p>マッチング中のユーザーはいません</p>
                </div>
            @endif
        </div>
    </div>
    
    <!--ユーザーページ-->
    @else
        <div class="row user-info">
            <div class="col-8">
                <img class="user-info__img" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                <h3 class="user-info__name others_name">{{ $user->name }}</h3>
            </div>
            <div class="col-4 pt-5">
                @if($me_others_offer)
                    @foreach($me_others_offer as $offer) 
                        @if($offer->offered_id == $user->id)
                            @if($offer->match && !($offer->match == "refused"))
                                {!! link_to_route("chat", "チャットルーム", ["roomid" => $offer->match, "me" => Auth::user()->id, "you" => $user->id],["class" => "btn btn-lg btn-outline-primary"]) !!}
                            @elseif($offer->match == "refused")
                                <p>すでにオファーを断られています</p>
                            @else
                                <p>オファーしています</p>
                            @endif
                        @endif
                    @endforeach
                @endif
                @if($others_me_offer)
                    @foreach($others_me_offer as $offer)
                        @if($offer->offer_id == $user->id)
                            @if($offer->match && !($offer->match == "refused"))
                                {!! link_to_route("chat", "チャットルーム", ["roomid" => $offer->match, "me" => Auth::user()->id, "you" => $user->id],["class" => "btn btn-lg btn-outline-primary"]) !!}
                            @elseif($offer->match == "refused")
                                <p>このユーザーのオファーをすでに断っています</p>
                            @else
                                <p>オファーされています</p>
                            @endif
                        @endif
                    @endforeach
                @endif
                @if(!(Auth::user()->is_offering($user->id)) && !(Auth::user()->is_being_offered($user->id)))
                    {!! Form::open(['route' => ['offer', $user->id]]) !!}
                        {!! Form::submit('オファーする', ['class' => "btn btn-primary btn-block"]) !!}
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
        <div class="others">
            <div class="row ml-0">
            <h2 class="gallery-heading">投稿作品</h2>
        </div>
        <div class="nav nav-tabs">
            <a class="nav-item nav-link active" id="tab-menu1" data-toggle="tab" href="#panel-menu1" role="tab" aria-controls="panel-nenu1" aria-selected="true">小説・ライトノベル</a>
            <a class="nav-item nav-link" id="tab-menu2" data-toggle="tab" href="#panel-menu2" role="tab" aria-controls="panel-nenu2" aria-selected="false">漫画・イラスト</a>
        </div>
        
        
        <div class="tab-content mb-5" id="panel-menus">
            <div class="tab-pane fade show active border border-top-0" id="panel-menu1" role="tabpanel" aria-labelledby="tab-menu1">
                <div class="row ml-0">
                    @if($book_posts->count())
                        @foreach($book_posts as $book_post)
                        <div class="book_post card">
                            <p class="book_post__advertisement card-title">{{ $book_post->advertisement }}</p>
                            <p class="book_post__title card-text">{{ $book_post->title }}</p>
                            <p class="book_post__author card-text">{{ $book_post->user()->first()->name }}</p>
                            {!! link_to_route("book_posts.show", "詳細", ["book_posts_id" => $book_post->id], ["class" => "btn btn-sm btn-outline-primary book-post__info-btn"]) !!}
                        </div>
                        @endforeach
                    @else
                        <div class="post-none">
                            <p>投稿がありません</p>
                        </div>
                    @endif
                </div>
                
            </div>
            <div class="tab-pane fade show border border-top-0" id="panel-menu2" role="tabpanel" aria-labelledby="tab-menu2">
                <div class="row ml-0">
                    @if($img_posts->count())
                        @foreach($img_posts as $img_post)
                            <div class="img_post card">
                                <img src="{{ $img_post->image_url }}" class="img_post__img card-img-top"></img>
                                <div class="card-body">
                                    <h4 class="img_post__title card-title">{{ $img_post->title }}</h4>
                                    <h6 class="img_post__author card-subtitle">{{ $img_post->user()->first()->name }}</h6>
                                </div>
                                {!! link_to_route("img_posts.show", "詳細", ["img_posts_id" => $img_post->id], ["class" => "btn btn-sm btn-outline-primary img-post__info-btn"]) !!}
                            </div>
                        @endforeach
                    @else
                        <div class="post-none">
                            <p>投稿がありません</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
            
        </div>
    </div>
    @endif
</div>
@endsection
