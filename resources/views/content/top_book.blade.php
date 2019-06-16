@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
        <div class="banner--book">
            <div class="container">
                <h1 class="title--book content-title">小説・ライトノベル</h1>
                {!! link_to_route('book_posts.create', '投稿する', [], ["class" => "btn btn-primary btn-lg link-btn"]) !!}
                {!! link_to_route('top', '漫画・イラストページへ', [], ["class" => "btn btn-secondary btn-lg link-btn ml-2"]) !!}
            </div>
        </div>
        <div class="container">
            <h2 class="heading">作品一覧</h2>
            <div class="topcontent--book row">
                 @foreach($book_posts as $book_post)
                    <div class="book_post card">
                        <h5 class="book_post__advertisement card-title">{{ $book_post->advertisement }}</h4>
                        <p class="book_post__title card-text">{{ $book_post->title }}</p>
                        <p class="book_post__author card-text">{{ $book_post->user()->first()->name }}</p>
                        {!! link_to_route("book_posts.show", "詳細", ["book_posts_id" => $book_post->id], ["class" => "btn btn-sm btn-outline-primary book-post__info-btn"]) !!}
                    </div>
                @endforeach
            </div>
            <div class="row">
                {{ $book_posts->render('pagination::bootstrap-4') }}
            </div>
            
        </div>
    </div>
@endsection