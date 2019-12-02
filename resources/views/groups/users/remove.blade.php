@extends('layouts.app')
@section('content')
    <div class="container featured-title titles">
        <h1 class="text-center">{{$group->name}}</h1>
    </div>
    <div class="container top-featured p-3 pb-5">
        <h3 class="text-light-custom text-center">Remove Users</h3>
        @if(!$users->count())
            <h6 class="text-danger text-center">The group is empty, there are no users to remove.</h6>
        @else
        <h6 class="text-light-custom text-center">Please select users that you wish to remove from the group.</h6>
        @endif
        <form action="{{ route('groups.removeusers', $group->id) }}" method="post">
            @csrf
            <div class="form-group">
            </div>
            @include('layouts.groups.users')
            <a href="{{route('groups.show', $group->id)}}" class="btn btn-danger float-left">< Cancel</a>
            @if($users->count())
                <button type="submit" class="btn btn-success float-right">Remove Users</button>
            @else
                <button type="submit" class="btn btn-success float-right" disabled>Remove Users</button>
            @endif
        </form>
    </div>
@endsection