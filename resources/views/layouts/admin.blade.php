<!DOCTYPE html>
<html>
    <head>
        <!-- Title -->
        <title>{{ $title }}</title>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="{{ asset('resources/assets/user/plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet"/>
        <link href="{{ asset('resources/assets/user/plugins/uniform/css/uniform.default.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('resources/assets/user/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/offcanvasmenueffects/css/menu_cornerbox.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/3d-bold-navigation/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/datatables/css/jquery.datatables_themeroller.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css"/>
        <!-- Theme Styles -->
        <link href="{{ asset('resources/assets/user/css/modern.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('resources/assets/user/css/themes/red.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
        <!-- <link href="{{ asset('resources/assets/user/css/custom.css') }}" rel="stylesheet" type="text/css"/> -->

        <script src="{{ asset('resources/assets/user/plugins/3d-bold-navigation/js/modernizr.js') }}"></script>
        <script src="{{ asset('resources/assets/user/plugins/offcanvasmenueffects/js/snap.svg-min.js') }}"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        @yield('custom_css')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Scripts -->
        <script>
window.Laravel = <?php
echo json_encode([
    'csrfToken' => csrf_token(),
]);
?>
        </script>
        <style type="text/css">
            @media(max-width:1024px){
                .navbar .logo-box { background: #f50000 !important; color: #FFFFFF; }
                .navbar .logo-box img{ width: auto !important; height: 50px !important; }
                .navbar-inner .fa{ color: #FFFFFF; }
                .search-button a { display:none !important; }
            }
            .modal-dialog {
                width: 90% !important;
                margin: 30px auto;
            }
            .nav-tabs > li > a { border-bottom: 1px solid #E80702; }
            .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
                color: #fff;
                cursor: default;
                background-color: #e80702;
                border-bottom-color: #e80702;
            }
			a,a:hover,a:active,a:focus{ text-decoration: none; }
            .navbar .logo-box { width: 100%; text-align: center; display: inline-flex; padding-left: 160px; }
            .push-sidebar, .push-sidebar:hover { color: #FFF; }
            .small-sidebar .navbar .logo-box { width: 100%; }
            .navbar-nav.navbar-right { position: absolute; right: 0; }
            .top-menu .navbar-nav > li > a,.top-menu .navbar-nav > li > a:hover,.top-menu .navbar-nav > li > a:focus,.top-menu .navbar-nav > li > a:active { color: #fff; }
			h2{ font-size: 33px; }
			.page-title { padding: 29px 20px; }
        </style>
    </head>
    <body class="page-header-fixed">
        <!-- <div class="overlay"></div> -->

        <form class="search-form" action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
            </div><!-- Input Group -->
        </form><!-- Search Form -->
        <main class="page-content content-wrap">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box text-center">
                        <a href="{{ url('home') }}" class="logo-text"><img src="{{ url('resources/assets/CouponCam-Logo.png') }}" title="{{ config('app.name', 'Laravel') }}" style="width:auto; height: 60px;" alt=""/></a>

                    </div><!-- Logo Box -->
                    <div class="search-button">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </div>
                    <div class="topmenu-outer">
                        <div class="top-menu" style="display:block">
                            <!--<ul class="nav navbar-nav navbar-left">
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                                </li>
                            </ul> -->
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name">{{ Auth::user()->name }}<i class="fa fa-angle-down"></i></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                        <li role="presentation"><a href="{{ url('profile') }}"><i class="fa fa-user"></i>Profile</a></li>
                                        <li role="presentation"><a href="{{ url('settings') }}"><i class="fa fa-cogs"></i>Change Password</a></li>
                                        <li role="presentation" class="divider" style="margin: 0;"></li>
                                        <li role="presentation">
                                            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out m-r-xs"></i>Logout
                                            </a>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!-- Nav -->
                        </div><!-- Top Menu -->
                    </div>
                </div>
            </div><!-- Navbar -->
            <div class="page-sidebar sidebar">
                <div class="page-sidebar-inner slimscroll">
                    <ul class="menu accordion-menu">

                      <li class=" @if(in_array(url()->current(),[url('dashboard')]) == true) active @endif"><a href="{{ url('dashboard') }}" class="waves-effect waves-button"><img src="{{ url('resources/assets/stats.png') }}" style="height: 20px;margin-bottom: 10px; width: auto;" /><p>Stats</p></a></li>

                      <li class="droplink @if(in_array(url()->current(),[url('admin/red_promos/create'),url('admin/red_promos')]) == true) active @endif"><a href="#" class="waves-effect waves-button"><img src="{{ url('resources/assets/promo.png') }}" style="height: 20px;margin-bottom: 10px; width: auto;" /><p>Red Friday Promos</p></a>
                          <ul class="sub-menu">
                              <li><a href="{{ url('admin/red_promos/create') }}">Create Promo</a></li>
                              <li><a href="{{ url('admin/red_promos/add_coupons') }}">Add Coupons</a></li>
                              <li><a href="{{ url('admin/red_promos') }}">List of Promos</a></li>
                              <!-- <li><a href="{{ url('admin/red_promos/give_away') }}">Give Away Price</a></li> -->
                          </ul>
                      </li>

                      <!-- <li class="droplink @if(in_array(url()->current(),[url('admin/give_away/stores'), url('admin/give_away/coupon'),url('admin/give_away/promos'),url('admin/give_away/coupon_list')]) == true) active @endif"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-gift"></span><p>Give Away </p></a>
                          <ul class="sub-menu">
                              <li><a href="{{ url('admin/give_away/stores') }}">Create Store</a></li>
                              <li><a href="{{ url('admin/give_away/promos') }}">Create Promos</a></li>
                              <li><a href="{{ url('admin/give_away/coupon') }}">Create Coupons</a></li>
                              <li><a href="{{ url('admin/give_away/coupon_list') }}">List of Coupons</a></li>
                          </ul>
                      </li> -->

                      <li class=" @if(in_array(url()->current(),[url('admin/app_settings')]) == true) active @endif"><a href="{{ url('admin/app_settings') }}" class="waves-effect waves-button"><!--img src="{{ url('resources/assets/stats.png') }}" style="height: 20px;margin-bottom: 10px; width: auto;" /--> <i class="fa fa-gear"></i><p>Settings</p></a></li>

                        @if(Auth::user()->usertype == 0)
                        <li class="droplink @if(in_array(url()->current(),[url('admin/users/create'),url('admin/users')]) == true) active @endif"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>Users</p></a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/users/create') }}">New user</a></li>
                                <li><a href="{{ url('admin/users') }}">List of users</a></li>
                            </ul>
                        </li>

                        <li class="droplink @if(in_array(url()->current(),[url('admin/stores/create'),url('admin/stores'),url('admin/stores/closed'),url('admin/stores/category')]) == true) active @endif"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Stores</p></a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/stores/create') }}">New Store</a></li>
                                <li><a href="{{ url('admin/stores') }}">List of Stores</a></li>
                                <li><a href="{{ url('admin/stores/closed') }}">Closed Stores</a></li>
                                <li><a href="{{ url('admin/stores/category') }}">Categories</a></li>
                            </ul>
                        </li>

                        <li class="droplink @if(in_array(url()->current(),[url('admin/promos/create'),url('admin/promos'),url('admin/promos/closed')]) == true) active @endif"><a href="#" class="waves-effect waves-button"><img src="{{ url('resources/assets/promo.png') }}" style="height: 20px;margin-bottom: 10px; width: auto;" /><p>Promos</p></a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/promos/create') }}">New Promo</a></li>
                                <li><a href="{{ url('admin/promos') }}">List of promos</a></li>
                                <li><a href="{{ url('admin/promos/closed') }}">Closed promos</a></li>
                            </ul>
                        </li>
                        <li class="droplink @if(in_array(url()->current(),[url('admin/coupons/create'),url('admin/coupons')]) == true) active @endif"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-gift"></span><p>Coupons</p></a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/coupons/create') }}">New Coupons</a></li>
                                <li><a href="{{ url('admin/coupons') }}">List of Coupons</a></li>
                            </ul>
                        </li>
						<li><a href="#" class="waves-effect waves-button openmodel" data-bind="1" data-id="3d_photo_1" data-toggle="modal" data-target="#myModal"><span class="menu-icon glyphicon glyphicon-upload"></span><p>Media</p></a></li>
                        @endif
                        @if(Auth::user()->usertype == 1)
							<li><a href="{{ url('coupon/quickform') }}" class="waves-effect waves-button"><img src="{{ url('resources/assets/easysetup.png') }}" style="height: 30px;margin-bottom: 10px; width: auto;" /><p>Easy Setup</p></a></li>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Stores</p><span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('user/stores/create') }}">New Store</a></li>
                                <li><a href="{{ url('user/stores') }}">List of Stores</a></li>
                                <li><a href="{{ url('user/stores/closed') }}">Closed Stores</a></li>
                                <li><a href="{{ url('user/stores/category') }}">Store Categories</a></li>
                            </ul>
                        </li>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><img src="{{ url('resources/assets/promo.png') }}" style="height: 20px;margin-bottom: 10px; width: auto;" /><p>Promos</p><span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('user/promos/create') }}">New Promo</a></li>
                                <li><a href="{{ url('user/promos') }}">List of promos</a></li>
                                <li><a href="{{ url('user/promos/closed') }}">Closed promos</a></li>
                            </ul>
                        </li>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-gift"></span><p>Coupons</p></a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('user/coupons/create') }}">New Coupons</a></li>
                                <li><a href="{{ url('user/coupons') }}">List of Coupons</a></li>
                            </ul>
                        </li>
						<li><a href="{{ url('dashboard') }}" class="waves-effect waves-button"><img src="{{ url('resources/assets/stats.png') }}" style="height: 20px;margin-bottom: 10px; width: auto;" /><p>Stats</p></a></li>
                        @endif
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="menu-icon glyphicon glyphicon-log-out"></span><p>Logout</p>
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div><!-- Page Sidebar Inner -->
            </div><!-- Page Sidebar -->
            <div class="page-inner">
                <div class="page-title">
                    <h3>{{ $title }}</h3>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('success'))<div class="alert alert-success">{{ session('success') }}<span class="pull-right" style="cursor: pointer" onclick="$('.alert').hide()">x</span></div>@endif
                            @if (session('error'))<div class="alert alert-danger">{{ session('error') }}<span class="pull-right" style="cursor: pointer" onclick="$('.alert').hide()">x</span></div>@endif
                            @yield('upper_content')
                        </div>
                        <div class="<?PHP echo isset($col) ? 'col-md-6' : 'col-md-12'; ?>">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
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
          <button id="usememodel" data-bind="" type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Use This 3D Coupon</button>
      </div>
    </div>
  </div>
</div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <div class="page-footer">
                    <p class="no-s"> CouponCam<sup>®</sup> {{ date('Y') }} &copy; All Rights Reserved CouponCam Inc.</p>
                </div>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
        <div class="cd-overlay"></div>


        <!-- Javascripts -->
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/jquery/jquery-2.1.3.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/pace-master/pace.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/jquery-blockui/jquery.blockui.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/switchery/switchery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/uniform/jquery.uniform.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/offcanvasmenueffects/js/classie.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/offcanvasmenueffects/js/main.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/waves/waves.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/3d-bold-navigation/js/main.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/summernote-master/summernote.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/jquery-counterup/jquery.counterup.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/datatables/js/jquery.datatables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>


        <script type="text/javascript" src="{{ asset('resources/assets/user/js/pages/form-elements.js') }}"></script>
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
        <script type="text/javascript" src="{{ asset('resources/assets/user/js/modern.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/user/js/pages/dashboard.js') }}"></script>
    </body>
</html>
