@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
<div class="container book-info">
        <div class"row">
                <h1>{{ $book_post->title }}</h1>
        </div>
        <div class"row">
                {!! link_to_route("users.show", "作者: ".$book_post->user()->first()->name, ["id" => $book_post->user()->first()->id]) !!}  
        </div>
        <div class"row">
                <h3>{{ $book_post->advertisement }}</h3>
        </div>
        <div class"row">
                <p>{{ $book_post->content }}</p>
        </div>
</div>
        
@endsection