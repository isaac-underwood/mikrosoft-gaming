{{-- Edit Page for currently logged in user--}} 
@extends('layouts.app') 
@section('title') Edit Profile 
@endsection
@section('content')
    <div class="text-center featured-title titles d-inline-block">
        <h2 class="font-weight-bold">Editing Your Profile</h2>
    </div>
    <div class="top-featured p-2">
        <form method="POST" action="{{route('profile.update', Auth::user()->id)}}" enctype="multipart/form-data" class="mx-auto">
            {{csrf_field()}} {{method_field('PATCH')}}
            <div class="form-group row">
                <label for="profile-image" class="col-sm-4 col-form-label text-right edit-form-label">Profile Picture</label>
                <div class="col-sm-4">
                    <input type="file" name="profile_image" class="form-control-file" id="profile_image">
                    @if (auth()->user()->image)
                        <code>{{ auth()->user()->image }}</code>
                    @endif
                </div>
                @if($errors->has('profile_image')) {{-- <-check if we have a validation error --}}
                    <span class="invalid-feedback">
                        {{$errors->first('profile_image')}} {{-- <- Display the First validation error --}}
                    </span>
                @endif
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-4 col-form-label text-right edit-form-label">Username</label>
                <div class="col-sm-2">
                    <input type="text" name="username" value="{{Auth::user()->username}}"  placeholder="New Username" disabled>
                    @if($errors->has('username')) {{-- <-check if we have a validation error --}}
                        <span class="invalid-feedback">
                            {{$errors->first('username')}} {{-- <- Display the First validation error --}}
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-right edit-form-label">Email</label>
                <div class="col-sm-2">
                    <input type="email" name="email" value="{{Auth::user()->email}}" placeholder="New Email" disabled>
                    @if($errors->has('email')) {{-- <-check if we have a validation error --}}
                        <span class="invalid-feedback">
                            {{$errors->first('email')}} {{-- <- Display the First validation error --}}
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="real_name" class="col-sm-4 col-form-label text-right edit-form-label">Real Name</label>
                <div class="col-sm-2">
                    <input type="text" name="real_name" class="form-control {{ $errors->has('real_name') ? 'is-invalid' : '' }}" value="{{Auth::user()->real_name}}" placeholder="Real Name">
                    @if($errors->has('real_name')) {{-- <-check if we have a validation error --}}
                        <span class="invalid-feedback">
                            {{$errors->first('real_name')}} {{-- <- Display the First validation error --}}
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="interests" class="col-sm-4 col-form-label text-right edit-form-label">Interests</label>
                <div class="col-sm-2">
                    <textarea rows="6" cols="35" name="interests" placeholder="Your Interests">{{Auth::user()->interests}}</textarea>
                    @if($errors->has('interests')) {{-- <-check if we have a validation error --}}
                        <span class="invalid-feedback">
                            {{$errors->first('interests')}} {{-- <- Display the First validation error --}}
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="favourite_games" class="col-sm-4 col-form-label text-right edit-form-label">Favourite Games</label>
                <div class="col-sm-2">
                    <textarea rows="8" cols="35" name="favourite_games" placeholder="Your Favourite Games">{{Auth::user()->favourite_games}}</textarea>
                    @if($errors->has('favourite_games')) {{-- <-check if we have a validation error --}}
                        <span class="invalid-feedback">
                            {{$errors->first('favourite_games')}} {{-- <- Display the First validation error --}}
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="location" class="col-sm-4 col-form-label text-right edit-form-label">Location</label>
                <div class="col-sm-2">
                    <input type="text" name="location" value="{{Auth::user()->location}}" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" placeholder="Location">
                    @if($errors->has('location')) {{-- <-check if we have a validation error --}}
                        <span class="invalid-feedback">
                            {{$errors->first('location')}} {{-- <- Display the First validation error --}}
                        </span>
                    @endif
                </div>
            </div>
            <hr>
            <div class="text-center">
                <a href="{{route('profile.index')}}" class="btn btn-danger">< Cancel</a>
                <button type="submit" class="btn btn-success ml-4">Update Profile</button>
            </div>
        </form>
    </div>
@endsection