@extends('layouts.admin')
@section('content')
    <form role="form" method="POST" action="{{ url('/profile/update') }}">
        {{ csrf_field() }}
        @if(Auth::user()->usertype == 0)
            <input type="hidden" name="formid" value="{{ $user->id }}" />
        @else
            <input type="hidden" name="formid" value="{{ Auth::id() }}" />
        @endif
        <div class="form-group col-sm-6 {{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name',$user->first_name) }}" placeholder="Enter First Name">
            @if ($errors->has('first_name'))
                <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
            @endif
        </div>
        <div class="form-group col-sm-6 {{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name',$user->last_name) }}" placeholder="Enter Last Name">
            @if ($errors->has('last_name'))
                <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
            @endif
        </div>
        <div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Company Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$user->name) }}" placeholder="Enter Name">
            @if ($errors->has('name'))
                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>
        <div class="form-group col-sm-6 {{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email',$user->email) }}" placeholder="Enter email">
            @if ($errors->has('email'))
                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </div>
        <div class="form-group col-sm-6 {{ $errors->has('address') ? ' has-error' : '' }}">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" placeholder="Enter Address">{{ old('address',$user->address) }}</textarea>
            @if ($errors->has('address'))
                <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
            @endif
        </div>
        <div class="form-group col-sm-6 {{ $errors->has('contact_details') ? ' has-error' : '' }}">
            <label for="contact_details">Contact Details</label>
            <textarea class="form-control" id="contact_details" name="contact_details" placeholder="Enter Details">{{ old('contact_details',$user->contact) }}</textarea>
            @if ($errors->has('contact_details'))
                <span class="help-block"><strong>{{ $errors->first('contact_details') }}</strong></span>
            @endif
        </div>



        <div class="form-group col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>

    <br/>
    <hr style="border-bottom:#e4e4e4 solid 2px;"/>
    <br/>

    <div class="col-sm-12">

        <h3 class="text-center">Deactivate Account</h3>
        <p class="text-center">This will permanently remove all stores, promos and coupons. This Action cannot be undone.</p>
        <p class="text-center"><button type="button" class="btn btn-primary" id="debtn">Deactivate Account</button> </p>
        <br/><br/>
    </div>
    <div class="col-md-8" style="margin:0 auto; float:none; display:none;" id="dcon">
        <h4 class="text-center" style="color:#f25656;">We are sorry to hear you want to deactivate your account. Someone will contact you shortly to confirm your deactivation.</h4>
        <br/><br/>
        <div class="col-xs-12" style="margin: 0 auto;">
            <div class="msg text-center">
                <div class="clearfix"></div>
                <div style="width:180px; margin: 0 auto;"><button type="button" class="btn btn-primary" id="cobtn" style="width:180px; margin: 0 auto;">CONTACT US</button></div>
                <br/>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="address col-md-12 text-center" style="display:none;">
            <h3 class="text-center" style="line-height: 25px; margin-top: -5px;">
                diactivate@couponcam.com<br/>
                <!--
                UK – +44 203 868 5633<br/>
                USA - +1 408 622 1282<br/>
                Australia +61 2 8417 2658 -->
            </h3>
            <div class="clearfix"></div>
            <div><a href="{{ url('deactivate') }}" class="btn btn-primary" id="deadtn" style="width:180px; clear:both;">DEACTIVATE ACCOUNT</a></div>
        </div>
    </div>
    <div id="decaccount"></div>
@endsection

@section('custom_js')
    <script type="text/javascript">
        $('#cobtn').on("click",function(){
            $('.address').show();
            $('#x1').hide();
            $('#x2').hide();
        });


        $('#debtn').on("click",function(){
            $(this).hide(); $('#dcon').slideDown(); window.location='#decaccount';
        });
    </script>
@endsection