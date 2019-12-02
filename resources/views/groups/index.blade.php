@extends('layouts.app')
@section('content')
    <div class="container featured-title titles">
        <h1 class="text-center">All Groups</h1>
    </div>
    <div class="container top-featured p-3">
            @if(Auth::user()->group_id != null)
                <a class="btn btn-primary mb-3" href="{{route('groups.show', Auth::user()->group_id)}}">My Group <i class="fas fa-users"></i></a>
            @endif
            <a class="btn btn-success float-right mb-3" href="{{route('groups.create')}}">Create Group <i class="fas fa-plus"></i></a>
            <table class="table table-striped table-borderless" width="100%">
                <tr>
                    <th>Name</th>
                    <th>Members</th>
                    <th>Founded</th>  
                </tr>  
                @foreach($groups as $group)
                <tr>
                    <td><a href="{{route('groups.show', $group->id)}}" class="font-weight-bold">{{$group->name}}</a></td>
                    <td>{{$group->users->count()}}</td>
                    <td>{{$group->created_at->diffForHumans()}}</td> 
                </tr>
                @endforeach   
            </table>
            <div class="pagination justify-content-center">
                {{ $groups->links() }}
            </div>       
        <div>   
    </div>
@endsection