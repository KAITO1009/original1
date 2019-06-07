<header>
    <nav class="navbar navbar-dark bg-dark">
        <a href="" class="navbar-brand">サイトタイトル</a>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="collapse navbar-nav mr-auto"></ul>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    {!! link_to_route("",ログイン, [], ["class" => "nav-link"] !!}
                </li>
                <li class="nav-item">
                    {!! link_to_route("",新規登録, [], ["class" => "nav-link btn btn-lg btn-succes"] !!}
                </li>
            </ul>
        </div>
    </nav>
</header>