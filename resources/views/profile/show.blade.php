{{--This is the profile page--}}
@extends('layouts.app')
@section('title')
{{$user->username}}'s Profile
@endsection
@section('content')
    <style>
    table {
    border-collapse: collapse;
    width: 100%;
    }
    th, td {
    text-align: left;
    padding: 8px;
    }
    tr:nth-child(even) {background-color: #f2f2f2;}

    #palyer_information{
        float: left;
        width: 40vh;
    }
    #profile_table{
        
        float: right !important;
        width: 58%;
        margin-top: 0px;
    }
    h2{
        margin-top: 48px;
    }
    th{
        font-size:15px;
    }
    </style>
    {{-- THIS IS FOR TESTING:
        Need to change to username of current user's profile, not the one logged in --}}      
    {{-- Check if user viewing profile is owner of profile, if true then display edit button--}}
    @if($user->id == Auth::user()->id)
    <a class="btn btn-primary" href="{{route('profile.edit', $user->id)}}">Edit Profile</a>
    @else
        <form action="{{ route('bans.gotorequest') }}" method="post" class="float-right div-inlinebox">
            @csrf
            <input type="hidden" name="userId" id="userId" value="{{$user->id}}">
            <button type="submit" class="btn btn-danger div-inlinebox float-right">Request Ban <i class="fas fa-ban"></i></button>
        </form>
    @endif
    <div id = "palyer_information">
        <h2 class="mt-5 mb-3">{{ $user->username }}'s Profile</h2>
        <p class="mt-5">Real Name: {{ $user->real_name }}</p>
        <p class="mt-2">Location: {{ $user->location }}</p>
        <p class="mt-2">Interests: {{ $user->interests }}</p>
        <p class="mt-2">Favourite Games: {{ $user->favourite_games }}</p>
    </div>
    <div id = "profile_table">
        <h2 class = "text-center">{{ $user->username }}'s HighScores</h2>
        <table>
            <tr>
            <th>{{--@sortablelink--}}Game</th>
            <th>{{--@sortablelink--}}Score Catergory</th>   
            <th>{{--@sortablelink--}}Score Value</th>
            <th>{{--@sortablelink--}}Date</th>
            @foreach($highscores as $highscore)
                    <tr>
                        <td>{{$highscore->game->title}}</td>   
                        <td>{{$highscore->title}}</td>                 
                        <td>{{$highscore->score}}</td>
                        <td>{{$highscore->created_at}}</td>
                    </tr>
            @endforeach
            </tr>
            <tr>
        </table>
        {{ $highscores->links() }}
    </div>
@endsection