{{-- This page shows the group in more details including the highscores--}} @extends('layouts.app') @section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    
    th,
    td {
        text-align: left;
        padding: 8px;
    }
    
    #palyer_information {
        float: left;
        width: 40vh;
    }
    
    #profile_table {
        float: right !important;
        width: 58%;
        margin-top: 0px;
    }
    
    h2 {
        margin-top: 48px;
    }
    
    th {
        font-size: 15px;
    }
</style>
<div class="containertest">
    <div class="div-inlinebox">
    </div>
    <div class="container featured-title titles">
        <h1 class="text-center">{{$group->name}}</h1>
    </div>
    @if($group->image)
    <div class="top-game-image-container">
        <img class="img-fluid top-game-image" src="{{asset($group->image)}}" alt="{{$group->name}} image">
    </div>
    @endif
    <div class="container top-featured p-3">
        <p class="text-center text-light-custom">{{$group->description}}</p>
        <div class="card-body">
            @if(Auth::user()->group_id == $group->id)
            <a href="javascript:;" data-toggle="modal" onclick="leaveGroup()" data-target="#LeaveModal" class="btn btn-danger float-right"><i class="fas fa-door-open"></i> Leave Group</a>
            <div id="LeaveModal" class="modal fade text-danger" role="dialog">
                <div class="modal-dialog ">
                    <!-- Modal content-->
                    <form action="" id="leaveForm" method="post">
                        @csrf
                        <div class="modal-content text-light-custom">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title text-center">Leave Group?</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                    @if(Auth::user()->id == $group->owner_id)
                                <p class="text-center text-danger">You will no longer be the owner of this group.</p>
                                    @endif
                                <p class="text-center">You will need to be re-added to this group once you leave.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success float-left" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="" class="btn btn-danger float-right" data-dismiss="modal" onclick="formSubmit()">Leave Group</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            @if(Auth::user()->id == $group->owner_id)
                <a href="{{route('groups.showaddusers', $group->id)}}" class="btn btn-success"><i class="fas fa-user-plus"></i> Add Users</a> 
                @if($group->users->count() == 1)
                    <a href="{{route('groups.showremoveusers', $group->id)}}" class="btn btn-danger disabled ml-4"><i class="fas fa-user-minus"></i> Remove Users</a> 
                @else
                    <a href="{{route('groups.showremoveusers', $group->id)}}" class="btn btn-danger ml-4"><i class="fas fa-user-minus"></i> Remove Users</a> 
                @endif
                    <a href="{{route('groups.edit', $group->id)}}" class="btn btn-primary ml-4"><i class="fas fa-edit"></i> Edit Group</a>
             @endif
             <div class="profile-information text-light-custom">
                <div class="text-center featured-title titles mt-4 text-uppercase">
                    <h3 class="font-weight-bold">Group Information</h3>
                </div>
                <h4 class="p-3 text-light-custom">Owner: 
                @if($group->owner_id)<a href="{{route('players.show', $user_owner->id)}}">{{$user_owner->username}}</a>
                @else
                No One Owns This Group.
                @endif</h4>
                <h4 class="p-3 text-light-custom">Created: {{$group->created_at->diffForHumans()}}</h4>
                <h4 class="p-3 text-light-custom">Members: {{$group->users->count()}}</h4>
            </div>
            <div class="profile-information">
                <div class="text-center featured-title titles mt-4">
                    <h3>Members</h3>
                </div>
                <table class="table table-striped table-borderless mt-2" width="60%">
                        <tr>
                            <th>Username</th>
                            <th>Highscores</th>
                            <th>Joined Mikrosoft Gaming</th>
                            @forelse($group->users as $user)
                            <tr>
                                <td><a href="{{route('players.show', $user->id)}}">{{$user->username}}</a></td>
                                <td>{{$user->highscores->count()}}</td>
                                <td>{{$user->created_at->diffForHumans()}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4"><p class="text-light-custom">There are no members of this group.</p></td>
                            </tr>
                            @endforelse
                        </tr>
                    </table>
                    {{ $users->links() }}
            </div>
            <div class="profile-information">
                <div class="text-center featured-title titles">
                    <h3>Highscores</h3>
                </div>
                <div class="text-center">
                    <table class="table table-striped table-borderless mt-2" width="60%">
                        <tr>
                            <th>Username</th>
                            <th>Game</th>
                            <th>Score Title</th>
                            <th>Score Value</th>
                            <th>Added</th>
                        </tr>
                            @foreach($group->users as $user)
                                @foreach($user->highscores as $highscore)
                                <tr>
                                    <td><a href="{{route('players.show', $user->id)}}">{{$highscore->user->username}}</a></td>
                                    <td><a href="{{route('games.show', $highscore->game->id)}}">{{$highscore->game->title}}</a></td>
                                    <td>{{$highscore['title']}}</td>
                                    <td>{{$highscore['score']}}</td>
                                    <td>{{$highscore['created_at']}}</td>
                                </tr>
                                @endforeach
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function leaveGroup() {
        var url = '{{ route("groups.removeUser", $group->id) }}';
        $("#leaveForm").attr('action', url);
    }

    function formSubmit() {
        $("#leaveForm").submit();
    }
</script>
@endsection