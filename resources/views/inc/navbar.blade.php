<nav class="navbar navbar-expand-lg navbar-dark bg-custom">
    <div class="container">
        <a  href="{{ url('/') }}"><img class="navbar-logo mr-2" src="{{ asset('img/logo.jpg') }}"></a>
        <a class="navbar-brand" href="{{ url('/') }}">
            <!-- {{ config('app.name', 'MikroSoft') }} -->
            <h1 class="text-light">Mikrosoft Gaming</h1>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{route('pages.index')}}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('games*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Games</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-light-custom" href="{{route('games.index')}}">All Games</a>
                        @if(Auth::check())
                        <a class="dropdown-item text-light-custom" href="{{route('games.create')}}">Add Game <i class="fas fa-plus pl-2"></i></a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('groups*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Groups</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-light-custom" href="{{route('groups.index')}}">All Groups</a>
                        @if(Auth::check())
                            @if(Auth::user()->group_id)
                                <a class="dropdown-item text-light-custom" href="{{route('groups.show', Auth::user()->group_id)}}">My Group <i class="fas fa-users pl-2"></i></a>
                            @endif
                                <a class="dropdown-item text-light-custom" href="{{route('groups.create')}}">Create Group <i class="fas fa-plus pl-2"></i></a>
                        @endif
                    </div>
                </li>
                @if(Auth::check())
                    <li class="nav-item">
                        <a href="{{route('players.index')}}" class="nav-link {{ Request::is('players*') ? 'active' : '' }}">Players</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::is('*create') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-light-custom" href="{{route('games.create')}}">Add Game <i class="fas fa-gamepad pl-2"></i></a>
                            <a class="dropdown-item text-light-custom" href="{{route('highscores.create')}}">New Highscore <i class="fas fa-gamepad pl-2"></i></a>
                            <a class="dropdown-item text-light-custom" href="{{route('groups.create')}}">New Group <i class="fas fa-users pl-2"></i></a>
                        </div>
                    </li>
                @endif
                @if(!Auth::check()) {{-- Check if user is not logged in --}}
                    <li class="nav-item">
                        <a href="{{route('register')}}" class="nav-link {{ Request::is('register') ? 'active' : '' }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('login')}}" class="nav-link {{ Request::is('login') ? 'active' : '' }}">Login</a>
                    </li>
                @else {{-- Check if user is logged in, display their username --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::is('profile*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (auth()->user()->image)
                        <img src="{{ asset(auth()->user()->image) }}" style="width: 20px; height: 20px; border-radius: 50%;">
                        @endif
                        Hello, {{ Auth::user()->username }}!
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('profile.index')}}">My Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('logout')}}">Logout <i class="fas fa-sign-out-alt pl-2"></i></a>
                        </div>
                    </li>
                @endif     
            </ul>
        </div>
    </div>
</nav>