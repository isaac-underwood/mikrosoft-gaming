{{-- This page shows the game in more details including the highscores--}}
@extends('layouts.app')
@section('content')
    <div class="text-center featured-title titles">
        <h2>{{$game->title}}</h2>
    </div>
    <div class="top-game-image-container">
        <img class="img-fluid top-game-image" src="{{asset($game->image)}}" alt="{{$game->name}} image">
    </div>
    <div class="top-featured p-2">
        <div class="game-body">
            <h5 class="text-center">{{ $game->body }}</h5> 
        </div>
        <h5 class="text-light-custom float-left">{{$game->highscores->count()}} Total Highscores</h5>
        <form action="{{ route('games.gotocreate') }}" method="post" class="float-right d-inline-block mb-2">
                @csrf
                <input type="hidden" name="gameId" id="gameId" value="{{ $game->id }}">
                <button type="submit" class="btn btn-success d-inline-block float-right">Add Highscore <i class="fas fa-plus pl-1"></i></button>
        </form>
        {{-- DISPLAY HIGHSCORES --}}
        <table class="table table-striped table-borderless" width="100%">
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Title</th>
                <th>Score</th>
                <th>Added</th>
            </tr>
            @foreach($highscores as $highscore)
                @if($loop->iteration == 1)
                    <tr>
                        <td class="bg-gold font-weight-bold stripe-bg-img text-light-custom">{{$loop->iteration}}</td> {{-- Use Loop Iteration to display rank --}}
                        <td class="bg-gold font-weight-bold stripe-bg-img text-light-custom"><a class="text-dark" href="{{route('players.show', $highscore->user->id)}}">{{$highscore->user->username}}</a></td>  
                        <td class="bg-gold font-weight-bold stripe-bg-img text-light-custom">{{$highscore['title']}}</td>             
                        <td class="bg-gold font-weight-bold stripe-bg-img text-light-custom">{{$highscore['score']}}</td>
                        <td class="bg-gold font-weight-bold stripe-bg-img text-light-custom">{{$highscore->created_at->diffForHumans()}}</td>
                    </tr>
                @elseif($loop->iteration == 2)
                    <tr>
                        <td class="bg-silver font-weight-bold stripe-bg-img">{{$loop->iteration}}</td> {{-- Use Loop Iteration to display rank --}}
                        <td class="bg-silver font-weight-bold stripe-bg-img"><a class="text-dark" href="{{route('players.show', $highscore->user->id)}}">{{$highscore->user->username}}</a></td>  
                        <td class="bg-silver font-weight-bold stripe-bg-img">{{$highscore['title']}}</td>             
                        <td class="bg-silver font-weight-bold stripe-bg-img">{{$highscore['score']}}</td>
                        <td class="bg-silver font-weight-bold stripe-bg-img">{{$highscore->created_at->diffForHumans()}}</td>
                    </tr>
                @elseif($loop->iteration == 3)
                    <tr>
                        <td class="bg-bronze text-light stripe-bg-img">{{$loop->iteration}}</td> {{-- Use Loop Iteration to display rank --}}
                        <td class="bg-bronze text-light stripe-bg-img"><a class="font-weight-bold" href="{{route('players.show', $highscore->user->id)}}">{{$highscore->user->username}}</a></td>  
                        <td class="bg-bronze text-light stripe-bg-img">{{$highscore['title']}}</td>             
                        <td class="bg-bronze text-light stripe-bg-img">{{$highscore['score']}}</td>
                        <td class="bg-bronze text-light stripe-bg-img">{{$highscore->created_at->diffForHumans()}}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{$loop->iteration}}</td> {{-- Use Loop Iteration to display rank --}}
                        <td><a href="{{route('players.show', $highscore->user->id)}}">{{$highscore->user->username}}</a></td>  
                        <td>{{$highscore['title']}}</td>             
                        <td>{{$highscore['score']}}</td>
                        <td>{{$highscore->created_at->diffForHumans()}}</td>
                    </tr>
                @endif
            @endforeach
        </table>
        <div class="pagination justify-content-center">
            {{ $highscores->links() }}
        </div>
    </div>
@endsection