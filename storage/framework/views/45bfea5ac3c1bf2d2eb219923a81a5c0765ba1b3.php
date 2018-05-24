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
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>

        <!-- Theme Styles -->
        <link href="<?php echo e(asset('resources/assets/user')); ?>/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/css/themes/white.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(asset('resources/assets/user')); ?>/css/custom.css" rel="stylesheet" type="text/css"/>

        <script src="<?php echo e(asset('resources/assets/user')); ?>/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="<?php echo e(asset('resources/assets/user')); ?>/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>

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
                                        <img src="<?php echo e(url('resources/assets/custom/images/logo-red.png')); ?>" class="m-t-xxs" style="height: 140px; width: auto;" alt="">
                                    </div>
                                <div class="user-box m-t-lg row">

                                    <div class="col-md-12">
                                        <p class="lead no-m text-center">Welcome</p>
                                        <p class="text-sm text-center">Please read our terms & conditions</p>
                                        <form role="form" method="POST" action="<?php echo e(url('user/accept')); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="col-sm-12" id="term_condition" style="height: 200px; background-color: #FFF; border: #e4e4e4 solid 1px; padding: 5px 10px; overflow-x: hidden; margin-bottom: 10px;">
                                                <h3 class="text-center">OUR BUSINESS AGREEMENT WITH YOUR COMPANY</h3>
<br/>
<p>Coupon GO Ltd. and associated companies will not charge your company any fees for using our service to promote your business. This includes but is not limited to, marketing fees, percentages and commissions.</p>

<p>Your company is not bound to any contract other than the terms and conditions outlined in this agreement.</p>

<p>You have to right to cease use of the service at anytime and will not be subject to any cancelations charges.</p>

<p>Your personal data is kept secure and will not be sold or shared with any third parties.</p>




<h3 class="text-center">UNDERSTANDING OF FEATURES</h3>
<h5 class="text-center">(Merchant & User)</h5>
<br/>
<p>You, the merchant will add coupons, which will be available to users via the app.</p>

<p>You, the merchant will add terms and conditions and expiry dates to each coupon if they are required.</p>

<p>Users will find coupons via the app and present their mobile device to a staff member in order to claim a coupon.</p>

<p>You, the merchant will honor coupons unless they are outside the preset terms and conditions or expiry date.</p>

<p>Once a coupon is used it will become void and cannot be used again by the device holder.</p>





<h3  class="text-center">COUPON GO TERMS & CONDITIONS</h3>

<p>By continuing on this site you are agreeing to the following terms of and conditions. </p>
<ol style="margin: 0; padding: 0 25px 10px 25px;">
    <li>You will honor all promotions and coupons you add to this site and understand that they will be added to the Coupon GO app.</li>

<li>You will not upload explicit or offensive material.</li>

<li>You own copyright of any images you post or have permission to use them.</li>

<li>Promotions and coupons cannot be removed from the app while active.</li>

<li>If you pause or cancel any promotion or coupon they will be removed from the app at the end of the current cycle (Max cycle 48 hours)</li>

<li>You will not claim coupons for your own business or from businesses on the same street address as you.</li>
</ol>

<strong  class="text-center">Please fill your first name, last name and company name to agree to these terms and conditions. </strong>
                                            </div>
                                            <span id="readit" style="display: none;">
                                                <input type="hidden" value="<?php echo e(Auth::user()->email); ?>" name="formid" />
                                            <div class="form-group col-sm-6 <?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo e(old('first_name')); ?>" placeholder="Enter First Name">
                                                <?php if($errors->has('first_name')): ?>
                                                <span class="help-block"><strong><?php echo e($errors->first('first_name')); ?></strong></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group col-sm-6 <?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e(old('last_name')); ?>" placeholder="Enter Last Name">
                                                <?php if($errors->has('last_name')): ?>
                                                <span class="help-block"><strong><?php echo e($errors->first('last_name')); ?></strong></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group col-sm-12 <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                                <label for="name">Company Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Name">
                                                <?php if($errors->has('name')): ?>
                                                <span class="help-block"><strong><?php echo e($errors->first('name')); ?></strong></span>
                                                <?php endif; ?>
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
        <script type="text/javascript" src="<?php echo e(url('resources/assets/user/plugins/jquery/jquery-2.1.3.min.js')); ?>"></script>

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
