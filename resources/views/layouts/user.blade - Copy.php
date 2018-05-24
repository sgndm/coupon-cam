<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<!--    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>-->
    <link href="{{ asset('resources/assets/user/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/assets/user/plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/assets/user/plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/assets/user/plugins/datatables/css/jquery.datatables_themeroller.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/user/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/user/css/nav.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/user/css/custom-btns.css') }}">

    <!-- | Get custom css | -->
    @yield('custom_css')

    <script>
        window.Laravel = <?php
        echo json_encode([
            'csrfToken' => csrf_token(),
        ]);
        ?>
    </script>

</head>
<body>
<main>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="border-color: #E80703;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="background-color: #E80703;"></span>
                    <span class="icon-bar" style="background-color: #E80703;"></span>
                    <span class="icon-bar" style="background-color: #E80703;"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="{{ url('resources/assets/CouponCam-LogoRed.png') }}" title="{{ config('app.name', 'Laravel') }}"  alt="CouponCam" class="logo-img" />
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav hide-md">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #E80703;">Statistics <span class="caret pull-right"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i--> &nbsp;&nbsp;Stats By Store</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Stats By Promo</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Total Stats</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i--> &nbsp;&nbsp;Retarget Customers</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav hide-md">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #E80703;">Stores <span class="caret pull-right"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Create Store</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Open Stores</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Closed Stores</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav hide-md">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #E80703;">Promos <span class="caret pull-right"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Create Promos</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Active Promos</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Paused Promos</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Finished Promos</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav hide-md">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #E80703;">Coupons <span class="caret pull-right"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Create Coupons</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Active Coupons</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Paused Coupons</a></li>
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><!--i class="fa fa-user"></i-->  &nbsp;&nbsp;Closed Coupons</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #E80703;">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('user/profile') }}" style="color: #E80703;"><i class="fa fa-user"></i> &nbsp;&nbsp;Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('user/settings') }}" style="color: #E80703;"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #E80703;">
                                    <i class="fa fa-sign-out m-r-xs"></i>&nbsp;&nbsp;Logout
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form></li>
                        </ul>
                    </li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container-fluid custom-container">
        <div class="col-md-12">
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}<span class="pull-right" style="cursor: pointer" onclick="$('.alert').hide()">x</span></div>@endif
            @if (session('error'))<div class="alert alert-danger">{{ session('error') }}<span class="pull-right" style="cursor: pointer" onclick="$('.alert').hide()">x</span></div>@endif
        </div>

        <div class="col-md-12 col-sm-12 nav-btn-container" >
            <div class="">
                <a href="{{ url('dashboard') }}" class="col-md-3 col-sm-3 hide-sm first-btn-nav" >
                    @if(in_array(url()->current(),[url('dashboard')]) == true)
                        <img src="{{ url('resources/assets/CCnew/7.png') }}" class="main-nav-btn" />
                    @else
                        <img src="{{ url('resources/assets/CCnew/1.png') }}" class="main-nav-btn" />
                    @endif
                </a>
                <a href="{{ url('user/stores/create') }}" class="col-md-3 col-sm-3 second-btn-nav" >
                    @if(in_array(url()->current(),[url('user/stores/create'),url('user/stores'),url('user/stores/closed')]) == true)
                        <img src="{{ url('resources/assets/CCnew/8.png') }}" class="main-nav-btn"  />
                    @else
                        <img src="{{ url('resources/assets/CCnew/2.png') }}" class="main-nav-btn" />
                    @endif
                </a>
                <a href="{{ url('user/promos/create') }}" class="col-md-3 col-sm-3 third-btn-nav" >
                    @if(in_array(url()->current(),[url('user/promos/create'),url('user/promos'),url('user/promos/closed')]) == true)
                        <img src="{{ url('resources/assets/CCnew/6.png') }}" class="main-nav-btn" />
                    @else
                        <img src="{{ url('resources/assets/CCnew/3.png') }}" class="main-nav-btn"  />
                    @endif
                </a>
                <a href="{{ url('user/coupons/create') }}" class="col-md-3 col-sm-3 last-btn-nav" >
                    @if(in_array(url()->current(),[url('user/coupons/create'),url('user/coupons'),url('user/coupons/trash')]) == true)
                        <img src="{{ url('resources/assets/CCnew/4.png') }}" class="main-nav-btn" />
                    @else
                        <img src="{{ url('resources/assets/CCnew/5.png') }}" class="main-nav-btn" />
                    @endif
                </a>
            </div>
        </div>

        <div class="page-inner">
            @yield('upper_content')
            @yield('content')
        </div>

        {{--<div class="custom-footer text-center">--}}
        {{--<p class="no-s">CouponCam<sup>®</sup> {{ date('Y') }} &copy; All Rights Reserved CouponCam Inc.</p>--}}
        {{--</div>--}}

    <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:#e4e4e4 solid 1px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                        <input type="hidden" id="mediavalue" value="">
                    </div>
                    <div class="modal-body" style="height: 400px;">
                        <!--   -->
                        <iframe src="{{ url('media') }}" border="0" height="400" width="100%" style="border:none;" id="3dframe"></iframe>


                    </div>
                    <div class="modal-footer" style="border-bottom:#e4e4e4 solid 1px;">
                        <button id="usememodel" data-bind="" type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Use This Coupon</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>



<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/jquery/jquery-2.1.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/datatables/js/jquery.datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

@yield('custom_js')
<script type="text/javascript">
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $(document).ready(function () {

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="tooltip"]').tooltip();

        $('#example').DataTable({
            minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate())
        });

        $('#expiredPromoTable').DataTable({
            minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate())
        });

        $('#inactivePromoTable').DataTable({
            minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate())
        });

        $('#allPromoTable').DataTable({
            minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate())
        });


        $('.time-picker').timepicker({
            timeFormat: 'h:mm p',
            interval: 15,
            minTime: '24',
            maxTime: '11:55pm',
            //defaultTime: '12',
            startTime: '08:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });


    })
</script>
</body>
</html>