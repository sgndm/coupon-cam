<!DOCTYPE html>
<html lang="en-US">
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('resources/assets/template/images/favicon.png') }}">
        <title>{{ $title }}</title>
        
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('resources/assets/template/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/template/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/template/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/template/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/template/plugins/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/template/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet">
        
        <!-- Template css -->
        <link href="{{ asset('resources/assets/template-custom/css/pages/tab-page.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/template-custom/css/style.css') }}" rel="stylesheet">
        
        <!-- Custom CSS -->
        <link href="{{ asset('resources/assets/custom/css/override.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/custom/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('resources/assets/custom/css/custom-btns.css') }}" rel="stylesheet">
        
        <!-- You can change the theme colors from here -->
        <link href="{{ asset('resources/assets/template-custom/css/colors/default-dark.css') }}" id="theme" rel="stylesheet">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


        <!-- | Get custom css | -->
        @yield('custom_css')

        <script>
            window.Laravel = <?php echo json_encode([ 'csrfToken' => csrf_token(), ]); ?>
        </script>

    </head>
<body class="fix-header card-no-border fix-sidebar single-column">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure">
                <!--img src="{{ asset('resources/assets/template/images/favicon.png') }}" -->
            </div>
            <p class="loader__label">CouponCam</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="">
                        <!-- Logo icon -->
                        <img src="{{ asset('resources/assets/custom/images/logo-red.png') }}" alt="homepage" class="dark-logo" style="width: 100%;" />
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-sm-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu" style="font-size: 28px; color: #e80602;"></i></a> </li>
                        <!-- show toggle menu button in big screens -->
                        <!--li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li -->
                        <li class="nav-item hidden-sm-down"></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0 hidden-sm-down">
                        
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h6 style="color: #E80703;">{{ Auth::user()->name }}</h6>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <a href="{{ url('dashboard') }}" style="color: #E80703;">
                                            <i class="ti-user"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('user/profile') }}" style="color: #E80703;">
                                            <i class="ti-settings"></i> Profile
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #E80703;">
                                            <i class="fa fa-power-off"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar hidden-sm-up">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="user-profile">
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <span class="hide-menu">{{ Auth::user()->name }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                 <li>
                                    <a href="{{ url('user/profile') }}">
                                        <i class="ti-user"></i> Profile
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        <li class="nav-devider"></li>
                        <li> 
                            <a class="waves-effect waves-dark" href="{{ url('dashboard') }}" aria-expanded="false">
                                <img src="{{ asset('resources/assets/ccicons/3a.png') }}" style="width: 25px;">
                                <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;Stats</span>
                            </a>
                        </li>
                        <li> 
                            <a class="waves-effect waves-dark" href="{{ url('user/stores') }}" aria-expanded="false">
                                <img src="{{ asset('resources/assets/ccicons/4a.png') }}" style="width: 25px;">
                                <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;Stores</span>
                            </a>
                        </li>
                        <li> 
                            <a class="waves-effect waves-dark" href="{{ url('user/promos') }}" aria-expanded="false">
                                <img src="{{ asset('resources/assets/ccicons/5.png') }}" style="width: 25px;">
                                <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;Promos</span>
                            </a>
                        </li>
                        <li> 
                            <a class="waves-effect waves-dark" href="{{ url('user/coupons') }}" aria-expanded="false">
                                <img src="{{ asset('resources/assets/ccicons/6a.png') }}" style="width: 25px;">
                                <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;Coupons</span>
                            </a>
                        </li>
                        <li class="nav-devider"></li>
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                                <i class="fa fa-power-off"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">

                    <div class="col-md-12 align-self-center">
                        <ol class="breadcrumb">
                            
                        </ol>
                        
                        <div class="row hidden-xs-down">
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <a href="{{ url('dashboard') }}">
                                    <div class="card">
                                        @if(in_array(url()->current(),[url('dashboard')]) == true)
                                            <img src="{{ asset('resources/assets/custom/images/stat-w.png') }}" style="width: 100%;" >
                                        @else
                                            <img src="{{ asset('resources/assets/custom/images/stat-r.png') }}" style="width: 100%;" >
                                        @endif
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <a href="{{ url('user/stores') }}">
                                    <div class="card">
                                        @if(in_array(url()->current(),[url('user/stores/create'),url('user/stores'),url('user/stores/closed')]) == true)
                                            <img src="{{ asset('resources/assets/custom/images/store-w.png') }}" style="width: 100%;" >
                                        @else
                                            <img src="{{ asset('resources/assets/custom/images/store-r.png') }}" style="width: 100%;" >
                                        @endif
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <a href="{{ url('user/promos') }}">
                                    <div class="card">
                                        @if(in_array(url()->current(),[url('user/promos/create'),url('user/promos'),url('user/promos/closed')]) == true)
                                            <img src="{{ asset('resources/assets/custom/images/promos-w.png') }}" style="width: 100%;" >
                                        @else
                                            <img src="{{ asset('resources/assets/custom/images/promos-r.png') }}" style="width: 100%;" >
                                        @endif
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <a href="{{ url('user/coupons') }}">
                                    <div class="card">
                                        @if(in_array(url()->current(),[url('user/coupons/create'),url('user/coupons'),url('user/coupons/trash')]) == true)
                                            <img src="{{ asset('resources/assets/custom/images/coupons-w.png') }}" style="width: 100%;" >
                                        @else
                                            <img src="{{ asset('resources/assets/custom/images/coupons-r.png') }}" style="width: 100%;" >
                                        @endif
                                    </div>
                                </a>
                            </div>
                            
                            
                            
                            
                        </div>
                        
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}
                                <span class="pull-right" style="cursor: pointer" onclick="$('.alert').hide()">x</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}
                                <span class="pull-right" style="cursor: pointer" onclick="$('.alert').hide()">x</span>
                            </div>
                        @endif
                    </div>
                    @yield('content')
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    
    
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('resources/assets/template/plugins/jquery/jquery.min.js') }}"></script>
    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('resources/assets/template/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('resources/assets/template-custom/js/perfect-scrollbar.jquery.min.js') }}"></script>
    
    <!--Wave Effects -->
    <script src="{{ asset('resources/assets/template-custom/js/waves.js') }}"></script>
    
    <!--Menu sidebar -->
    <script src="{{ asset('resources/assets/template-custom/js/sidebarmenu.js') }}"></script>
    
    <!--stickey kit -->
    <script src="{{ asset('resources/assets/template/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('resources/assets/template/plugins/switchery/dist/switchery.min.js') }}"></script>
    
    <script src="{{ asset('resources/assets/template/plugins/dropify/dist/js/dropify.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('resources/assets/template-custom/js/custom.js') }}"></script>
    
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <!--script src="{{ asset('resources/assets/template/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script -->
    
    @yield('custom_js')
    
    <script type="text/javascript">
        $('.carousel').carousel({
            interval: false
        });
        
        $(document).ready(function() {
            set_stat_tile();
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });
        });
        
        $( window ).resize(function() {
            set_stat_tile();
        });
        
        function set_stat_tile() {
            var width = $('.stat-tile').innerWidth();
            var border_radius = (width * 15 / 100);
            var font_size = (width * 32 / 100);
            var font_size_p = (width * 8 / 100);
            var margin_top = (width * 21 / 100);
            var margin_bottom = (width * 8 / 100);
            
            $('.stat-tile').innerHeight(width);
            $('.stat-tile').css('border-radius',border_radius);
            $('.stat-larg-tile').innerHeight(width);
            $('.stat-larg-tile').css('border-radius',border_radius);
            
            $('.stat_count').css('font-size',font_size);
            $('.stat_count').css('margin-top',margin_top);
            $('.stat_count').css('margin-bottom',margin_bottom);
            
            $('.stat_lable').css('font-size',font_size_p);
            
        }
        

        $('.clockpicker').clockpicker({
            donetext: 'Done',
        }).find('input').change(function() {
            console.log(this.value);
        });
    

    </script>
    
</body>

</html>