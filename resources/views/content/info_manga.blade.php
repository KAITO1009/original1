@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
<div class="container manga-info">
    <div class="row">
        <h1>{{ $img_post->title }}</h1>
        @if(Auth::user()->id == $img_post->user_id)
        <div class="delete-btn-wrapper">
            {!! Form::open(['route' => ['img_posts.destroy', $img_post->id], 'method' => 'delete']) !!}
                        {!! Form::submit('削除する', ['class' => "btn btn-danger float-right"]) !!}
                {!! Form::close() !!}
        </div>
        @endif
    </div>
    <div class="row">
        {!! link_to_route("users.show", "作者： " .$img_post->user()->first()->name, ["id" => $img_post->user()->first()->id]) !!}
    </div>
    <div class="row">
        <img src="{{ $img_post->image_url }}" class="img_post__item"></img>
    </div>
</div>
@endsection