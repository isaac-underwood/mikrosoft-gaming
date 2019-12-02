@extends('layouts.app')
@section('content')
    <div class="container featured-title titles">
        <h1 class="text-center">Edit Group</h1>
    </div>
    <div class="container top-featured p-3">
        <form action="{{ route('groups.update', $group->id) }}" method="post" enctype="multipart/form-data">
            @csrf {{method_field('PATCH')}}
            <div class="form-group">
                <label for="name">Name of Group</label>
                <input type="text" name="name" id="name" class="form-control {{$errors->has('name') ? 'is-invalid' : '' }}" value="{{$group->name}}" placeholder="Enter: Name of Group">
                @if($errors->has('name'))
                    <span class="invalid-feedback">
                        {{$errors->first('name')}}
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Description of Group</label>
                <input type="text" name="description" id="description" class="form-control {{$errors->has('description') ? 'is-invalid' : '' }}" value="{{$group->description}}" placeholder="Enter: Description of Group">
                @if($errors->has('description'))
                    <span class="invalid-feedback">
                        {{$errors->first('description')}}
                    </span>
                @endif
            </div>
            <div class="form-group">
            <label for="group-image" class="col-form-label text-right">Group Image</label>
            <p><small>Please provide an image with large dimensions (minimum width: 500px, minimum height: 350px).</small></p>
            @if($group->image)
            <p><small>Current Image:</small></p>
            <img class="img-fluid group-image-home mb-2" src="{{asset($group->image)}}">
            @endif
                <div class="col-sm-4">
                    <input type="file" name="group_image" class="form-control-file {{$errors->has('group_image') ? 'is-invalid' : ''}}" id="group_image">
                    @if($errors->has('group_image')) 
                    <span class="invalid-feedback font-weight-bold">
                     {{$errors->first('group_image')}} {{-- <- Display the First validation error --}}
                    </span>
                     @endif
                </div>
            </div>
            <div class="form-group pb-4">
                <a href="{{ URL::previous() }}" class="btn btn-danger float-left">< Cancel</a>
                <button type="submit" class="btn btn-success float-right">Update Group</button>
            </div>
        </form>
    </div>
@endsection