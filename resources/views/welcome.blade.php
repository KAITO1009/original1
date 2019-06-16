@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">
@endsection

@section('content')
    <div class="welcome">
        <div class="center-block">
            <h1 class="welcome__title mt-5">Coope</h1>
            <p class="catch">創作仲間を見つけよう</p>
            {!! link_to_route('signup.get','はじめる', [], ['class' => 'btn btn-block btn-primary center-block__start mt-5'])!!}
            {!! link_to_route('login', 'ログイン', [], ['class' => 'btn btn-block btn-secondary center-block__start'])!!}
        </div>
    </div>
@endsection