@extends('layouts.user')
@section('content')
<form role="form" method="POST" action="{{ url('/settings') }}">
    {{ csrf_field() }}

    
    <div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
        <label for="current_password">Current Password</label>
        <input type="password" class="form-control" id="current_password" value="" name="current_password" placeholder="current password">
        @if ($errors->has('current_password'))
        <span class="help-block"><strong>{{ $errors->first('current_password') }}</strong></span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" value="" name="password" placeholder="Password">
        @if ($errors->has('password'))
        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" value="" name="password_confirmation" placeholder="Confirm Password">
        @if ($errors->has('password_confirmation'))
        <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-12">
        <button name="userSett" type="submit" class="btn btn-primary">Save Changes</button>
    </div>

</form>
@endsection