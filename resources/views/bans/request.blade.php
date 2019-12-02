@extends('layouts.app')
@section('content')
    <div class="text-center featured-title titles">
        <h2>Request Ban: {{$user_to_be_banned->username}}</h2>
    </div>
    <div class="top-featured text-center p-2">
        <form action="{{route('bans.store')}}" id="banform" method="post">
            @csrf
            <input type="hidden" name="user_id_to_ban" id="user_id_to_ban" value="{{$user_to_be_banned->id}}">
            <input type="hidden" name="submitBanRequest" id="submitBanRequest" value="submitBanRequest">
            <div class="form-group">
                <label for="reason">Ban Reason</label>
                <textarea name="reason" id="reason" rows="4" class="form-control {{$errors->has('reason') ? 'is-invalid' : ''}} ban-request-text-area" placeholder="Enter Ban Reason">{{old('body')}}</textarea>
                @if($errors->has('reason')) {{-- <-check if we have a validation error --}}
                    <span class="invalid-feedback">
                        {{$errors->first('reason')}} {{-- <- Display the First validation error --}}
                    </span>
                @endif
            </div>
            <h5 class="text-danger p-2">Once this user receives at least 2 ban requests this month, they will be suspended.</h4>
            <a href="javascript:;" data-toggle="modal" onclick="requestBan()" data-target="#BanModal" class="btn btn-danger">Request Ban</a>
            <div id="BanModal" class="modal fade text-danger" role="dialog">
                <div class="modal-dialog ">
                    <!-- Modal content-->
                    <form action="" id="requestForm" method="post">
                        @csrf
                        <div class="modal-content text-light-custom">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title text-center">Request Ban?</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p class="text-danger">Are you sure you want to request this user to be banned?</p>
                                <p class="text-danger font-weight-bold">Do not abuse this system.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success float-left" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="" class="btn btn-danger float-right" data-dismiss="modal" onclick="formSubmit()">Yes, Request Ban</button>
                            </div>
                        </div>
                    </form>
                </div>
    </div>

        </form>
    </div>

<script type="text/javascript">
    function requestBan() {
        var url = '{{ route("bans.store") }}';
        $("#requestForm").attr('action', url);
    }

    function formSubmit() {
        $("#banform").submit();
    }
</script>
@endsection