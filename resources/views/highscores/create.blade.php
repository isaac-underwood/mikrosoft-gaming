@extends('layouts.app')
@section('content')
    <div class="text-center featured-title titles">
        <h2>New Highscore</h2>
    </div>
    <div class="top-featured p-2">
        <form action="{{ route('highscores.store') }}" method="post">
            @csrf
            @if($gameId == null)
                <div class="form-group">
                    <label for="gameIDs">Game</label>
                    <br>
                    <select name="gameIDs[]" id="game-select" class="form-control">
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->title }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="form-group">
                <label for="title">Title of Highscore</label>
                <p><small>Example: Total Kills</small></p>
                <input type="text" name="title" id="title" class="form-control {{$errors->has('title') ? 'is-invalid' : '' }}" value="{{old('title')}}" placeholder="Title of Highscore">
                @if($errors->has('title'))
                    <span class="invalid-feedback">
                        {{$errors->first('title')}}
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="score">Highscore</label>
                <input type="number" name="score" id="score" class="form-control {{$errors->has('score') ? 'is-invalid' : ''}}" placeholder="Enter Score">{{old('score')}}</textarea>
                @if($errors->has('score')) {{-- <-check if we have a validation error --}}
                    <span class="invalid-feedback">
                        {{$errors->first('score')}} {{-- <- Display the First validation error --}}
                    </span>
                @endif
            </div>
            @if($gameId != null)
                {{-- INPUT FOR GAME ID --}}
                <input type="hidden" name="gameId" id="gameId" value="{{ $gameId }}">
            @endif
            <button type="submit" class="btn btn-success float-right">Add Highscore <i class="fas fa-plus pl-1"></i></button>
        </form>
        @if($gameId != null)
            <a class="btn btn-danger" href="{{route('games.show',$gameId)}}">< Back to Game</a>
        @else
            <a class="btn btn-danger" href="{{ URL::previous() }}">< Cancel</a>
        @endif
    </div>
@endsection