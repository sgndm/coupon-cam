@extends('layouts.business')
@section('content')

<div class="col-md-12">
    <div class="card">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab" onclick="create_tab();">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                    <span class="hidden-xs-down">ACCOUNT INFO</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" onclick="open_tab();">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                    <span class="hidden-xs-down">CHANGE PASSWORD</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab" onclick="cloased_tab();">
                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                    <span class="hidden-xs-down">DEACTIVATE ACCOUNT</span>
                </a>
            </li>
            <li class="nav-item"></li>
            <li class="nav-item"></li>


        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">

                <form role="form" method="POST" action="{{ url('/profile/update') }}" id="user_form">
                    {{ csrf_field() }}
                    @if(Auth::user()->usertype == 0)
                    <input type="hidden" name="formid" value="{{ $user->id }}" />
                    @else
                    <input type="hidden" name="formid" value="{{ Auth::id() }}" />
                    @endif


                    <div class="col-sm-12 col-md-12 col-lg-12">

                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Company Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="" value="{{ $user->name }}" required oninput="error_hide('comp_name_error');">
                            <h6 class="form-control-feedback text-danger" id="comp_name_error"> </h6>

                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Company Representitive</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="" value="{{ $user->first_name}}" required oninput="error_hide('user_name_error');">
                            <h6 class="form-control-feedback text-danger" id="user_name_error"> </h6>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Position</label>
                            <input type="text" id="u_position" name="position" class="form-control" placeholder="" value="{{ $user->position }}" required oninput="error_hide('user_pos_error');">
                            <h6 class="form-control-feedback text-danger" id="user_pos_error"> </h6>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="" value="{{ $user->email }}" required oninput="error_hide('user_email_error');">
                            <h6 class="form-control-feedback text-danger" id="user_email_error"> </h6>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Phone Number</label>
                            <input type="tel" id="contact_details" name="contact_details" class="form-control" placeholder="" value="{{ $user->contact }}" required oninput="error_hide('user_phone_error');">
                            <h6 class="form-control-feedback text-danger" id="user_phone_error"> </h6>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Country</label>
                            <input type="text" id="country" name="country" class="form-control" placeholder="" value="{{ $user->country }}" required oninput="error_hide('user_country_error');" >
                            <h6 class="form-control-feedback text-danger" id="user_country_error"> </h6>
                        </div>

                        <div class="form-group">
                            <button type="button" name="userProf" class="col-md-8 custom_btn update" onclick="validate_user()"></button>
                        </div>


                    </div>


                </form>

            </div>
            <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                <form role="form" method="POST" action="{{ url('/settings') }}">
                    {{ csrf_field() }}

                    @if(Auth::user()->usertype == 0)
                    <input type="hidden" name="formid" value="{{ $user->id }}" />
                    @else
                    <input type="hidden" name="formid" value="{{ Auth::id() }}" />
                    @endif

                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                        <label class="control-label">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter Current Password" value="" required>
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                        <label class="control-label">New Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter New Password" value="" required oninput="check_pass();" minlength="6">
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                        <label class="control-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re Enter New Password" value="" required oninput="check_pass();" minlength="6">
                    </div>

                    <h6 class="form-control-feedback text-danger" id="password_error"> </h6>

                    <div class="form-group">
                        <button type="submit" name="userSett" id="userSett_btn" class="col-md-8 custom_btn save_c"></button>
                    </div>


                </form>
            </div>
            <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                <h3 class="text-center">Deactivate Account</h3>
                <p class="text-center">This will permanently remove all stores, promos and coupons. This Action cannot be undone.</p>
                <p class="text-center"><button type="button" class="btn btn-danger" id="debtn">Deactivate Account</button> </p>
                <br/><br/>
                <div class="col-md-8" style="margin:0 auto; float:none; display:none;" id="dcon">
                    <h4 class="text-center" style="color:#f25656;">We are sorry to hear you want to deactivate your account. Someone will contact you shortly to confirm your deactivation.</h4>
                    <br/><br/>
                    <div class="col-xs-12" style="margin: 0 auto;">
                        <div class="msg text-center">
                            <div class="clearfix"></div>
                            <div style="width:180px; margin: 0 auto;"><button type="button" class="btn btn-danger" id="cobtn" style="width:180px; margin: 0 auto;">CONTINUE </button></div>
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
                        <div><a href="{{ url('deactivate') }}" class="btn btn-danger" id="deadtn" style="width:180px; clear:both;">DEACTIVATE ACCOUNT</a></div>
                    </div>
                </div>
                <div id="decaccount"></div>
            </div>

            </div>
        </div>
    </div>
</div>

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

        function check_pass() {
            var pass = $('#password').val();
            var pass2 = $('#password_confirmation').val();

            if(pass == pass2) {
                $('#password_error').html("");
                $('#userSett_btn').prop('disabled',false);
            }
            else {
                $('#password_error').html("Passwords doesn't match..");
                $('#userSett_btn').prop('disabled',true);
            }

        }

        function validate_user() {
            var err_1 = "Required Field";
            var name = $('#name').val();

            if(name.length > 0) {
                $('#comp_name_error').html('');
            } else {
                $('#comp_name_error').html(err_1);
            }

            var u_name = $('#first_name').val();

            if(u_name.length > 0) {
                $('#user_name_error').html('');
            } else {
                $('#user_name_error').html(err_1);
            }

            var position = $('#u_position').val();

            if(position.length > 0) {
                $('#user_pos_error').html('');
            } else {
                $('#user_pos_error').html(err_1);
            }

            var email = $('#email').val();

            if(email.length > 0) {
                $('#user_email_error').html('');
            } else {
                $('#user_email_error').html(err_1);
            }

            var phone = $('#contact_details').val();

            if(phone.length > 0) {
                $('#user_phone_error').html('');
            } else {
                $('#user_phone_error').html(err_1);
            }

            var country = $('#country').val();

            if(country.length > 0) {
                $('#user_country_error').html('');
            } else {
                $('#user_country_error').html(err_1);
            }


            if( (name.length > 0) && (position.length > 0) && (email.length > 0) && (u_name.length > 0) && (phone.length > 0) && (country.length > 0) ) {
                $('#user_form').submit();
            } else {
                alert("Please Fill the missing data..");
            }
        }

        function error_hide(field_id) {
            $('#'+ field_id).html('');
        }

    </script>
@endsection