@extends('layouts.app')
@section('content')
    <div id ="homepage">
        <div class="featured-title titles">
            <h1 class="text-center">Top Played Games</h1>
        </div>
        <div class="container top-featured top-games"> <!-- Games -->   
            @foreach($top5 as $game)
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="top-game-image-container">
                            <a href="{{route('games.show', $game->id)}}"><img class="img-fluid top-game-image" src="{{asset($game->image)}}" alt="{{$game->name}} image"></a>
                        </div>
                        <div class="card mb-3 top-game-card">
                            <div class="card-body">
                                <h3 class="card-title text-uppercase text-light font-weight-bold"><a href="{{route('games.show', $game->id)}}">{{$game->title}}</a></h3>
                                <p class="card-text my-4 text-light text-center">{{str_limit($game->body, $limit = 150, $end = '...')}}</p>
                                <a class="btn btn-primary" href="{{route('games.show', $game->id)}}">View Game</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="featured-title titles">
                <h1 class="text-center">Top Players</h1>
        </div>
        <div class="container top-featured top-players"> <!-- Players -->  
            <div class="row">
                @forelse($users as $user)
                    <div class="col-4 mt-4  text-center">
                        <h4 class=""><a href="{{route('players.show', $user->id)}}">{{$user->username}}</a></h4>
                        <a href="{{route('players.show', $user->id)}}"><img class="img-fluid user-image-normal mb-2" src="{{asset($user->image)}}"></a>
                        @if ($user->highscores->count() > 1)
                            <p class="text-purple font-weight-bold">{{$user->highscores->count()}} Highscores</p> {{-- User has multiple highscores --}}
                        @else
                            <p>{{$user->highscores->count()}} Highscore</p> {{-- User has 1 highscore --}}
                        @endif
                        <h6 class="text-light">Highest Score:</h6>
                        <p>{{$user->highscores->max('score')}}</p>
                        <a class="btn btn-primary mb-4" href="{{route('players.show', $user->id)}}">View Profile</a>
                    </div>
                @empty
                    <div class="text-center mx-auto">
                        <h4 class="text-center">Oh no! There are no top players yet :-(</h4>
                        <h4 class="text-center">Start adding highscores to become a top player!</h4>
                    </div>
                @endforelse
            </div>
        </div>
        
        <div class="featured-title titles">
            <h1 class="text-center">Top Groups</h1>
        </div>
        <div class="container top-featured top-players mb-4">
            <div class="row">
                @forelse($groups as $group)
                    <div class="col-4 mt-4 text-center">
                        <h4 class=""><a href="{{route('groups.show', $group->id)}}">{{$group->name}}</a></h4>
                        @if ($group->image)
                            <a href="{{route('groups.show', $group->id)}}"><img class="img-fluid group-image-home mb-2" src="{{asset($group->image)}}"></a>
                        @else
                            <p class="italics"><small>No group photo.</small></p>
                        @endif
                        <h5 class="text-purple font-weight-bold">{{$group->highscore_count}} Total Highscores</h5>
                        <a class="btn btn-primary mt-2 mb-4" href="{{route('groups.show', $group->id)}}">View Group</a>
                    </div>
                @empty
                    <div class="text-center mx-auto">
                        <h4 class="text-center">Oh no! There are no top groups yet :-(</h4>
                        <h4 class="text-center">Start by creating a group and adding highscores to become a top group!</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>        
@endsection