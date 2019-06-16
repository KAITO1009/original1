@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="container">
        <div class="text-center">
            <h1>ログイン</h1>
        </div>
    
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
    
                {!! Form::open(['route' => 'login.post']) !!}
                    <div class="form-group">
                        {!! Form::label('email', 'メールアドレス') !!}
                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'user-mail']) !!}
                    </div>
    
                    <div class="form-group">
                        {!! Form::label('password', 'パスワード') !!}
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'user-pass']) !!}
                    </div>
    
                    {!! Form::submit('ログイン', ['class' => 'btn btn-primary btn-block mt-5', 'id' => 'login-button']) !!}
                    {!! Form::close() !!}
    
                <p class="mt-2">アカウントをお持ちでない方はこちら {!! link_to_route('signup.get', '新規会員登録') !!}</p>
            </div>
        </div>
    </div>
</div>
    
@endsection