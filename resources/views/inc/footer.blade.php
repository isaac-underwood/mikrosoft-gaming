<div class="footer-basic">
    <footer>
        <ul class="list-inline">
            <li class="list-inline-item"><a class="text-light-custom" href="{{ route('pages.index') }}">Home</a></li>
            <li class="list-inline-item"><a class="text-light-custom" href="{{ route('games.index') }}">Games</a></li>
            <li class="list-inline-item"><a class="text-light-custom" href="{{ route('groups.index') }}">Groups</a></li>
            <li class="list-inline-item"><a class="text-light-custom" href="{{ route('players.index') }}">Players</a></li>
            @if(Auth::check())
                <li class="list-inline-item"><a class="text-light-custom" href="{{ route('profile.index', Auth::user()->id) }}">My Profile</a></li>
            @else
                <li class="list-inline-item"><a class="text-light-custom" href="{{ route('register') }}">Register</a></li>
                <li class="list-inline-item"><a class="text-light-custom" href="{{ route('login') }}">Login</a></li>
            @endif
        </ul>
        <p class="copyright">Mikrosoft Gaming © 2019</p>
    </footer>
</div>