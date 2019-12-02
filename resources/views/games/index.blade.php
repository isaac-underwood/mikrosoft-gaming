@extends('layouts.app')
@section('content')
    <div class="featured-title titles">
        <h1 class="text-center">Top Played Games</h1>
    </div>
    <div class="container top-featured">
        <div>
            <a class="btn btn-success m-2" href="{{route('highscores.create')}}">New Highscore <i class="fas fa-gamepad pl-1"></i></a>
            <a class="btn btn-success m-2 float-right" href="{{route('games.create')}}">Add Game <i class="fas fa-plus pl-1"></i></a>
        </div>
        <p class="text-center">Games are sorted by the amount of highscores.</p>
        @foreach($games as $game)
            <div class="card mb-3 text-center bg-custom">
                <div class="top-game-image-container-lg">
                    <a href="{{route('games.show', $game->id)}}"><img src="{{$game->image}}" class="card-img-top img-fluid" alt="{{$game->name}} Image"></a>
                </div>
                <div class="card-body">
                    <h2 class="card-title"><a href="{{route('games.show', $game->id)}}">{{$game->title}}</a></h2>
                    <p class="card-text">{{$game->body}}</p>
                    <p class="card-text pt-2">{{$game->scoreCount}} Highscores</p>
                    <a class="btn btn-primary mt-2 d-inline-block mx-4" href="{{route('games.show', $game->id)}}">View Highscores <i class="fas fa-gamepad pl-1"></i></a>
                    <form action="{{ route('games.gotocreate') }}" method="post" class="d-inline-block">
                        @csrf
                        <input type="hidden" name="gameId" id="gameId" value="{{ $game->id }}">
                        <button type="submit" class="btn btn-success d-inline-block mt-2 mx-4">Add Highscore <i class="fas fa-gamepad pl-1"></i></button>
                    </form>
                </div>
            </div>   
        @endforeach
        <div>
            <a class="btn btn-success m-2" href="{{route('highscores.create')}}">New Highscore <i class="fas fa-gamepad pl-1"></i></a>
            <a class="btn btn-success m-2 float-right" href="{{route('games.create')}}">Add Game <i class="fas fa-plus pl-1"></i></a>
        </div> 
    </div>
    <div class="pagination justify-content-center">
        {{ $games->links() }}
    </div>        
@endsection