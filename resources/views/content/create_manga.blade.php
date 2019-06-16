@extends('layouts.app')
@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
<div class="container create--book">
    <div class="row">
        {!! Form::open(["route" => "img_posts.store", 'files' => true]) !!}
        <div class="form-group col-12">
            {!! Form::label("title", "タイトル:") !!}
            {!! Form::text("title", null, ["class" => "form-control"]) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            {!! Form::label("img", "画像ファイル選択") !!}
            {!! Form::file("img", ["class" => "form-control-file", "id" => "img"]) !!}
        </div>
        <img class="preview" id="preview">
    </div>
    <div class="row">
        <div class="form-group col-12">
          {!! Form::submit('投稿', ["class" => "btn btn-primary btn-block manga-post-btn"]) !!}  
        </div>
    </div>
    {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
    <script>
        $('#img').on('change', function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#preview").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
@endsection