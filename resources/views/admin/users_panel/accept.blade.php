<!DOCTYPE html>
<html>
    <head>

        <!-- Title -->
        <title>Coupon GO</title>

        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />

        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="{{ asset('resources/assets/user') }}/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>

        <!-- Theme Styles -->
        <link href="{{ asset('resources/assets/user') }}/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/css/themes/white.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user') }}/css/custom.css" rel="stylesheet" type="text/css"/>

        <script src="{{ asset('resources/assets/user') }}/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="{{ asset('resources/assets/user') }}/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="page-lock-screen">
        <main class="page-content" style="background-color: #FFF;">
            <div class="page-inner" style="background-color: #FFF; padding-bottom: 20px;">
                <div id="main-wrapper" style="margin: .5% 5%;">
                    <div class="row">
                        <div class="col-md-10 center">
                            <div class="login-box">
                                 <div class="col-md-12 m-b-md" style="padding: 0px 50px 0px 0px; text-align: center; margin-bottom: 0px;">
                                        <img src="{{ url('resources/assets/custom/images/logo-red.png') }}" class="m-t-xxs" style="height: 140px; width: auto;" alt="">
                                    </div>
                                <div class="user-box m-t-lg row">

                                    <div class="col-md-12">
                                        <p class="lead no-m text-center">Welcome</p>
                                        <p class="text-sm text-center">Please read our terms & conditions</p>
                                        <form role="form" method="POST" action="{{ url('user/accept') }}">
                                            {{ csrf_field() }}
                                            <div class="col-sm-12" id="term_condition" style="height: 200px; background-color: #FFF; border: #e4e4e4 solid 1px; padding: 5px 10px; overflow-x: hidden; margin-bottom: 10px;">
                                                <h3 class="text-center">OUR BUSINESS AGREEMENT WITH YOUR COMPANY</h3>
<br/>
<p>CouponCam Inc. and associated companies will NOT charge your company any fees for using our service to promote your business. This includes but is not limited to, set up costs, advertising costs, percentages, commissions and cancelation fees.</p>

<p>Your company is not bound to any contract to continue using our service but you must adhere to the terms outlined in this agreement and terms and conditions below to use our service.</p>

<p>You have to right to cease use of the service at anytime but must honour any coupons already issued.</p>

<p>Your personal data is kept secure and will not be sold or shared with any third parties.</p>




<h3 class="text-center">UNDERSTANDING THE FEATURES</h3>
<h5 class="text-center">(Merchant & User)</h5>
<br/>
<p>You, the merchant will add coupons, which will be available to users via the CouponCam app.</p>

<p>When creating coupons via your account, you the merchant can set terms and conditions and claim times for individual coupons, it is your responsibility to ensure this information is correct, users cannot be refused the usage of coupons for terms and conditions not available to them via the app.</p>

<p>Users will find coupons via the app and present their mobile device to a staff member of your store in order to claim a coupon.</p>

<p>Coupons are level based and the availability of level 1,2 and 3 is set by you, level 4 coupons are unlimited.</p>

<p>Once a coupon is used it will become void and cannot be used again by the device holder unless the coupon has loyalty activated.</p>

<p>Loyalty Coupons allow users to be reissued coupons multiple times based on repeat spend within your store, once a user returns to your store an amount of times set by you, they will become eligible to use a coupon again.</p>





<h3  class="text-center">TERMS & CONDITIONS</h3>

<ol style="margin: 0; padding: 0 25px 10px 25px;">
    <li>You will honor all promotions and coupons you add to this site and understand that they will be added to the CouponCam app.</li>

<li>You will not upload explicit or offensive material.</li>

<li>You are responsible for any images posted to the app via your account, you own the copyright or have permission to use them.</li>

<li>Promotions and coupons cannot be removed from the app while active.</li>

<li>If you pause or cancel any promotion or coupon they will be removed from the app at the end of the day.
    You will not claim coupons for your own business.</li>

<li>Please fill your first name, last name and legal company name to agree to our business agreement with your company, your understanding of the features and the terms and conditions of using our service.</li>
</ol>

<strong  class="text-center">Please fill your first name, last name and company name to agree to these terms and conditions. </strong>
                                            </div>
                                            <span id="readit" style="display: none;">
                                                <input type="hidden" value="{{ Auth::user()->email }}" name="formid" />
                                            <div class="form-group col-sm-6 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Enter First Name">
                                                @if ($errors->has('first_name'))
                                                <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                                @endif
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Enter Last Name">
                                                @if ($errors->has('last_name'))
                                                <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                                @endif
                                            </div>
                                            <div class="form-group col-sm-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name">Company Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                                @if ($errors->has('name'))
                                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                                @endif
                                            </div>

                                            <div class="form-group col-sm-3 center">
                                                <button type="submit" class="btn btn-primary">Accept</button>
                                            </div>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->


        <!-- Javascripts -->
        <script type="text/javascript" src="{{ url('resources/assets/user/plugins/jquery/jquery-2.1.3.min.js') }}"></script>

        <script type="text/javascript">
        $(document).ready(function(){
            $('#term_condition').on("scroll",function(){
                var tcheight = $(this).innerHeight();
                var scrolled = $(this).scrollTop();
                if(parseInt(scrolled) >= 550){
                    //$('#term_condition').css("height",200);
                    $('#readit').css("display","block");
                }
            });
        });
        </script>
    </body>
</html>
