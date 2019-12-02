@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You are logged in!
                        <form action="{{ route('groups.gotocreate') }}" method="post" class="float-right div-inlinebox">
                            @csrf
                            <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-primary div-inlinebox float-right">Add Group</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
