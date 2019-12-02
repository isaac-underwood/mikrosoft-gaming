@extends('layouts.app')
@section('content')
    <div class="text-center featured-title titles">
        <h2>All Players</h2>
    </div>
    <div class="top-featured p-2">
        <p class="text-center">All Players registered within Mikrosoft Gaming. Oldest member accounts are displayed first.</p>
        <table class="table table-striped table-borderless" width="100%">
            <tr>
                <th>Username</th>
                <th>Group</th>
                <th>Highscores</th>
                <th>Member Since</th>  
            </tr>
        @foreach($users as $player)
            <tr>
                <td><a href="{{route('players.show', $player->id)}}" class="font-weight-bold">{{$player->username}}</a></td>
                <td>@if($player->group != null)<a href="{{route('groups.show', $player->group->id)}}" class="font-weight-bold">{{$player->group->name}}</a>@endif</td>
                <td>@if($player->highscores != null){{$player->highscores->count()}}@endif</td>
                <td>{{$player->created_at->diffForHumans()}}</td> 
            </tr>
        @endforeach  
        </table>
        <div class="pagination justify-content-center">
            {{ $users->links() }}
        </div>    
    </div>
@endsection