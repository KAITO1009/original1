@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
        <div class="banner--manga">
            <div class="container">
                <h1 class="title--manga content-title">漫画・イラスト</h1>
                {!! link_to_route('img_posts.create', '投稿する', [],["class" => "btn btn-primary btn-lg link-btn"]) !!}
                {!! link_to_route('book_posts.index', '小説ページへ', [],["class" => "btn btn-secondary btn-lg link-btn ml-2"]) !!}
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