@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('slick/slick-theme.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('slick/slick.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
    <div class="banner--manga">
        <div class="container">
            <div class="row">
                <div>
                    <h1 class="title--manga content-title">漫画・イラスト</h1>
                    {!! link_to_route('img_posts.create', '投稿する', [],["class" => "btn btn-primary btn-lg link-btn"]) !!}
                    {!! link_to_route('book_posts.index', '小説ページへ', [],["class" => "btn btn-secondary btn-lg link-btn ml-2"]) !!}
                </div>
                <div class="slide-wrapper">
                    <span class="latest">最新投稿</span>
                    <ul class="slider">
                        <?php  $latest_img = App\ImgPost::orderBy("created_at", "desc")->take(3)->get(); ?>
                            @foreach($latest_img as $img)
                            <li class="slider__list"><img class="slider__img" src="{{ $img->image_url }}"></img></li>
                            @endforeach
                    </ul>
                </div>
            </div>
            
        </div>
        
    </div>
    <div class="container">
        <h2 class="heading">作品一覧</h2>
        <div class="topcontent--manga row">
            @foreach($img_posts as $img_post)
            <div class="img_post card">
                <img src="{{ $img_post->image_url }}" class="img_post__img card-img-top"></img>
                <div class="card-body">
                    <h4 class="img_post__title card-title">{{ $img_post->title }}</h4>
                    <h6 class="img_post__author card-subtitle">{{ $img_post->user()->first()->name }}</h6>
                    {!! link_to_route("img_posts.show", "詳細", ["img_posts_id" => $img_post->id], ["class" => "btn btn-sm btn-outline-primary img-post__info-btn"]) !!}
                </div>
            </div>
        @endforeach
        </div>
        <div class="row">
            {{ $img_posts->render('pagination::bootstrap-4') }}
        </div>
    </div>
    
    
@endsection
@section("script")
    <script src="{{ asset('slick/slick.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" ></script>
@endsection