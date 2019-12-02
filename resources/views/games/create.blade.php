@extends('layouts.app')
@section('content')
    <div class="featured-title titles">
        <h1 class="text-center">Add Game</h1>
    </div>
    <div class="container top-featured p-3">
        <form action="{{route('games.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Game Title</label>
                <input type="text" name="title" id="title" class="form-control {{$errors->has('title') ? 'is-invalid' : '' }}" value="{{old('title')}}" placeholder="Enter Title">
                @if($errors->has('title'))
                    <span class="invalid-feedback font-weight-bold">
                        * {{$errors->first('title')}}
                    </span>
                @endif
                
                <label for="game-image" class="col-form-label text-right">Game Picture</label>
                <p><small>Please provide an image with large dimensions (minimum width: 500px, minimum height: 350px).</small></p>
                <div class="col-sm-4">
                    <input type="file" name="game_image" class="form-control-file {{$errors->has('game_image') ? 'is-invalid' : ''}}" id="game_image">
                    @if($errors->has('game_image')) 
                    <span class="invalid-feedback font-weight-bold">
                        * {{$errors->first('game_image')}} {{-- <- Display the First validation error --}}
                    </span>
                @endif
                </div>
            </div>
            
            <div class="form-group">
                <label for="body">Game Description</label>
                <p><small>The Game Description could include details such as genre or developer(s). <a href="https://en.wikipedia.org">Stuck? Try using Wikipedia.</a></small></p>
                <textarea name="body" id="body" rows="4" class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}" placeholder="Enter Game Description">{{old('body')}}</textarea>
                @if($errors->has('body')) {{-- <-check if we have a validation error --}}
                    <span class="invalid-feedback font-weight-bold">
                        * {{$errors->first('body')}} {{-- <- Display the First validation error --}}
                    </span>
                @endif
            </div>
            <a href="{{ URL::previous() }}" class="btn btn-danger mb-3">< Cancel</a>
            <button type="submit" class="btn btn-success mb-3 float-right">Add Game <i class="fas fa-plus pl-1"></i></button>
        </form>
    </div>
@endsection