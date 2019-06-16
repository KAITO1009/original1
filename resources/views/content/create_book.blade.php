@extends('layouts.app')
@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
    {!!Form::model($book_post, ["route" => "book_posts.store"]) !!}
    <div class="container create--book">
        <div class="row">
            <div class="form-group col-6">
                {!! Form::label("title", "タイトル:") !!}
                {!! Form::text("title", null, ["class" => "form-control"]) !!}
            </div>
            <div class="form-group col-6">
                {!! Form::label("advertisement", "キャッチコピー:") !!}
                {!! Form::text("advertisement", null, ["class" => "form-control"]) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {!! Form::label("content", "内容") !!}
                {!! Form::textarea("content", null, ["class" => "form-control", "rows" => "30"]) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {!! Form::submit('投稿', ["class" => "btn btn-primary btn-lg float-right"]) !!}
            </div>
            
        </div>
    </div>
    {!! Form::close() !!}
@endsection