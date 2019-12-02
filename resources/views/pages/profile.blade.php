{{--This is the profile page--}}
@extends('layouts.app')
@section('title', {{$user->username}}'s Profile)
@section('content')       
    <form action="{{ route('bans.gotorequest') }}" method="post" class="float-right div-inlinebox">
        @csrf
        <input type="hidden" name="userId" id="userId" value="{{$user->id}}">
        <button type="submit" class="btn btn-danger div-inlinebox float-right">Request Ban</button>
    </form>
    <div class="text-center featured-title titles">
        <h2>{{ $user->username }}'s Profile</h2>
    </div>
    <div class="top-featured p-2">
        <p class="mt-5">Real Name: {{ $user->real_name }}</p>
        <p class="mt-2">Location: {{ $user->location }}</p>
        <p class="mt-2">Interests: {{ $user->interests }}</p>
        <p class="mt-2">Favourite Games: {{ $user->favourite_games }}</p>
   </div>
    <div>
        <h2 class = "text-center">{{ $user->username }}'s HighScores</h2>
        <table>
        <tr>
        <th>Game</th>
        <th>Score Catergory</th>   
        <th>Score Value</th>
        <th>Date</th>
        </tr>
        @foreach($highscores as $highscore)
            @if ($user->id == $highscore->user_id)
                <tr>
                    <td>{{$highscore->game->title}}</td>
                    <td>{{$highscore['title']}}</td>                 
                    <td>{{$highscore['score']}}</td>
                    <td>{{$highscore['created_at']}}</td>
                </tr>
                @endif
        @endforeach
        </tr>        
        </table>
        {{ $highscores->links() }}
    </div>
@endsection