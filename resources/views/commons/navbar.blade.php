<header>
    <nav class="navbar navbar-dark bg-dark">
        <a href="" class="navbar-brand">サイトタイトル</a>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="collapse navbar-nav mr-auto"></ul>
            
            <ul class="navbar-nav">
                @if(Auth::check())
                    <li class="nav-item">{!! link_to_route("logout.get", "ログアウト") !!}</li>
                    <li class="nav-item">{!! link_to_route("users.show", "マイページ”, ["id" => Auth:id()]) !!}</li>
                @else
                    <li class="nav-item">
                        {!! link_to_route("","ログイン", [], ["class" => "nav-link"] !!}
                    </li>
                    <li class="nav-item">
                        {!! link_to_route("signup.get",新規登録, [], ["class" => "nav-link btn btn-lg btn-succes"] !!}
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>