{{-- Page shows own user's profile, includes the edit profile button and removes request ban --}}
@extends('layouts.app')
@section('title')
{{$user->username}}'s Profile
@endsection
@section('content')
    <div class="text-center featured-title titles d-inline-block">
        <h2 class="font-weight-bold">{{ $user->username }}'s Profile</h2>
    </div>
    <div class="top-featured p-2">
        <div class="row">
            <div class="profile-information">
                <img class="img-fluid profile-image m-4" src="{{asset($user->profile_image)}}" alt="{{$user->username}} image">
                @if (!$user_banned->count() && !$user_already_requested_ban->count())
                    <form action="{{ route('bans.gotorequest') }}" method="post" class="float-right div-inlinebox mt-4">
                        @csrf
                        <input type="hidden" name="userId" id="userId" value="{{$user->id}}">
                        <button type="submit" class="btn btn-danger div-inlinebox float-right">Request Ban <i class="fas fa-ban"></i></button>
                    </form>
                @elseif($user_banned->count())
                    <h3 class="text-danger float-right font-weight-bold d-inline-block mt-4">Account Suspended <i class="fas fa-ban"></i></h3>
                @endif
                <h5 class="m-4 text-light-custom">Real Name: {{ $user->real_name }}</h5>
                <h5 class="m-4 text-light-custom">Location: {{ $user->location }}</h5>
                <h5 class="m-4 text-light-custom">Interests: {{ $user->interests }}</h5>
                <h5 class="m-4 text-light-custom">Favourite Games: {{ $user->favourite_games }}</h5>
            </div>
        </div>
        <div class="profile-information">
            <div class="text-center featured-title titles mt-4">
                <h3>Group</h3>
            </div>
            @if($user->group != null)
                <h4 class="text-center text-light-custom mt-2"><a href="{{route('groups.show', $user->group->id)}}">{{$user->group->name}}</a></h4>
                <div class="mx-auto text-center m-2">
                    <a href="route('groups.show', $user->group->id)"><img class="img-fluid group-image-home" src="{{asset($user->group->image)}}" alt="{{$user->group->name}} image"></a>
                </div>
                <h5 class="text-light-custom text-center">{{$user->group->users->count()}} Member(s)</h5>
            @else
                <h6 class="text-center text-light-custom mt-2">You are not currently in a group.</h6>
            @endif
        </div>
        <div class="profile-information">
            <div class="text-center featured-title titles">
                <h3>Highscores</h3>
            </div>
            <div class="text-center profile-information">
                <table class="table table-striped table-borderless mt-2" width="60%">
                    <tr>
                    <th>Game</th>
                    <th>Score Title</th>   
                    <th>Score Value</th>
                    <th>Date</th>
                    @forelse($highscores as $highscore)
                        <tr>
                            <td>{{$highscore->game->title}}</td>
                            <td>{{$highscore['title']}}</td>                 
                            <td>{{$highscore['score']}}</td>
                            <td>{{$highscore['created_at']}}</td>
                        </tr>
                    @endforeach
                    </tr>                
                </table>
                {{ $highscores->links() }}
            </div>
        </div>
    </div>
@endsection