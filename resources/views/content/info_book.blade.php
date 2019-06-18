@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
<div class="container book-info">
        <div class"row">
                <h1>{{ $book_post->title }}</h1>
                @if(Auth::user()->id == $book_post->user_id)
                        {!! Form::open(['route' => ['book_posts.destroy', $book_post->id], 'method' => 'delete']) !!}
                                {!! Form::submit('削除する', ['class' => "btn btn-danger btn-sm float-right"]) !!}
                        {!! Form::close() !!}
                @endif
        </div>
        <div class"row">
                {!! link_to_route("users.show", "作者: ".$book_post->user()->first()->name, ["id" => $book_post->user()->first()->id]) !!}  
                
        </div>
        <div class"row">
                <h3>{{ $book_post->advertisement }}</h3>
        </div>
        <div class"row">
                <p>{!! nl2br(e($book_post->content)) !!}</p>
        </div>
</div>
        
@endsection