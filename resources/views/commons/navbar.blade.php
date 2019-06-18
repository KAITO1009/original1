<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        {!! link_to_route('/','Coope', [], ['class' => 'navbar-brand ml-3 sitelogo']) !!}
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav-bar mr-auto"></ul>
            <ul class="navbar-nav mr-4">
                @if(Auth::check())
                    @if(!(Auth::user()->is_offered_count() == 0))
                        <div class="offer-badge-wrapper">
                            <span class="badge badge-pill badge-info offer-badge">オファーが来ています<span class="offer-badge__count badge-light badge-pill badge">{{ Auth::user()->is_offered_count() }}</span></span>
                        </div>
                    @endif
                    <li class="nav-item">{!! link_to_route('logout.get','ログアウト', [], ['class' => 'nav-link nav-link text-white mt-2', 'id' => 'logout-button']) !!}</li>
                    <li class="nav-item">{!! link_to_route('users.show','マイページ', ['id' => Auth::id()], ['class' => 'nav-link btn btn-lg btn-primary mt-1 ml-3 text-white']) !!}</li>
                @else
                    <li class="nav-item">
                        {!! link_to_route('login','ログイン', [], ['class' => 'nav-link text-white mt-1']) !!}
                    </li>
                    <li class="nav-item">
                        {!! link_to_route('signup.get','新規登録', [], ['class' => 'nav-link btn btn-lg btn-primary text-white ml-3']) !!}
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>