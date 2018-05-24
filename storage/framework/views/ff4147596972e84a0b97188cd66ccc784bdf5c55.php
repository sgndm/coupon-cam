<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('resources/assets/template/images/favicon.png')); ?>">
        <title>CouponCam</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            @import  url(https://fonts.googleapis.com/css?family=Roboto:300);

            .login-page {
                width: 360px;
                padding: 1% 0 8% 0;
                margin: auto;
            }
            .form {
                position: relative;
                z-index: 1;
                background: #FFF;
                max-width: 360px;
                margin: 0 auto 100px;
                padding: 45px;
                text-align: left;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }
            .form input {
                font-family: "Roboto", sans-serif;
                outline: 0;
                background: #f2f2f2;
                width: 100%;
                border: 0;
                margin: 0 0 15px;
                padding: 15px;
                box-sizing: border-box;
                font-size: 14px;
            }
            .form button {
                font-family: "Roboto", sans-serif;
                text-transform: uppercase;
                outline: 0;
                background: #e80702;
                width: 100%;
                border: 0;
                padding: 15px;
                color: #FFFFFF;
                font-size: 14px;
                -webkit-transition: all 0.3 ease;
                transition: all 0.3 ease;
                cursor: pointer;
            }
            .form button:hover,.form button:active,.form button:focus {
                background: #ec3430;
            }
            .form .message {
                margin: 15px 0 0;
                color: #b3b3b3;
                font-size: 12px;
            }
            .form .message a {
                color: #4CAF50;
                text-decoration: none;
            }
            .form .register-form {
                display: none;
            }
            .container {
                position: relative;
                z-index: 1;
                max-width: 300px;
                margin: 0 auto;
            }
            .container:before, .container:after {
                content: "";
                display: block;
                clear: both;
            }
            .container .info {
                margin: 50px auto;
                text-align: center;
            }
            .container .info h1 {
                margin: 0 0 15px;
                padding: 0;
                font-size: 36px;
                font-weight: 300;
                color: #1a1a1a;
            }
            .container .info span {
                color: #4d4d4d;
                font-size: 12px;
            }
            .container .info span a {
                color: #000000;
                text-decoration: none;
            }
            .container .info span .fa {
                color: #EF3B3A;
            }
            body {
  background: #e80702; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #e80702, #e80702);
  background: -moz-linear-gradient(right, #e80702, #e80702);
  background: -o-linear-gradient(right, #e80702, #e80702);
  background: linear-gradient(to left, #e80702, #e80702);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
            a{
                color: #ec3430;
                text-decoration: none;
            }
            
            @media(max-width:359px){
            	.login-page { width: 305px; }
            }
            
            .modal-dialog {
    		width: 90% !important;
    		margin: 30px auto;
	   }
        </style>
        <script type="text/javascript">
            $('.message a').click(function () {
                $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
            });
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div style="text-align:center; padding: 10px 0 0px 0;">
                <img src="<?php echo e(url('resources/assets/CouponCam-Logo.png')); ?>" style="height:100px; width: auto;">
            </div>
            <div class="login-page">
                <!-- <p class="lead no-m text-center" style="text-align: center; color: #FFF; font-size: 30px; font-weight: 800; margin: 10px 0;">Welcome to Coupon Go</p> -->
                <?php if(url()->current() == url('login') || url()->current() == url('/') ): ?>
                <p class="text-sm text-center" style="text-align: center; color: #FFF; font-size: 17px;">Please sign in to access your promotions.</p>
                <?php elseif(url()->current() == url('password/reset')): ?>
                <p class="text-sm text-center" style="text-align: center; color: #FFF; font-size: 17px;">Please enter email to recover your password.</p>
                <?php else: ?>
                <p class="text-sm text-center" style="text-align: center; color: #FFF; font-size: 17px;">Please enter email and password to reset password.</p>
                <?php endif; ?>
                <div class="form">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <script src="/js/app.js"></script>
    </body>
</html>
