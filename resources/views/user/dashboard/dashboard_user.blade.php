@extends('layouts.user')

@section('content')
    <div class="col-md-12">
        <div class="card">

            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab">
                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                        <span class="hidden-xs-down">STATS BY STORE</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab">
                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                        <span class="hidden-xs-down">STATS BY PROMO</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-5" role="tab">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">LOYALTY STATS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">TOTAL STATS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-4" role="tab" onclick="cloased_tab();">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">RETARGET CUSTOMERS</span>
                    </a>
                </li>
                

            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="tab-pane-1" role="tabpanel">
                    {{--{{$coupon_level_get}}--}}
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if(sizeof($stores) > 0)
                                    <div id="store_slider_stat" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <?PHP $storeCount = sizeof($stores); ?>

                                            <div class="carousel-item active">

                                                <h3 class="text-center m-b-5 text-danger"> {{ strtoupper($stores[0]['store_name']) }}</h3>
                                                <h6 class="text-center m-b-20  text-danger"> {{ strtoupper($stores[0]['city']) }}</h6>
                                                <div class="row">

                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['recent_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['recent_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['recent_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['recent_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['recent_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER ON MOST RECENT DAY</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['7_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['7_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['7_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['7_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['7_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 7 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['30_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['30_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['30_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['30_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['30_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 30 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['all']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['all']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['all']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['all']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $stores[0]['all']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER SINCE STARTING THE PROMO</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            @for($x = 1; $x < $storeCount; $x++)
                                                <div class="carousel-item">

                                                    <h3 class="text-center m-b-5 text-danger"> {{ strtoupper($stores[$x]['store_name']) }}</h3>
                                                    <h6 class="text-center m-b-2$x  text-danger"> {{ strtoupper($stores[$x]['city']) }}</h6>
                                                    <div class="row">

                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['recent_day']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['recent_day']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['recent_day']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['recent_day']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['recent_day']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER ON MOST RECENT DAY</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['7_day']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['7_day']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['7_day']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['7_day']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['7_day']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 7 DAYS</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['30_day']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['30_day']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['30_day']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['30_day']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['30_day']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 30 DAYS</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['all']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['all']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['all']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['all']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $stores[$x]['all']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER SINCE STARTING THE PROMO</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            @endfor



                                        </div>


                                        <a class="carousel-control-prev" href="#store_slider_stat" role="button" data-slide="prev">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow_left.png')}}" style="width: 70px;" > </span>
                                            <span class="sr-only">Prev</span>
                                        </a>
                                        <a class="carousel-control-next" href="#store_slider_stat" role="button" data-slide="next">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow.png')}}" style="width: 70px;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                @else
                                    {{'You have No store.. Please create a store.. '}}
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="tab-pane-2" role="tabpanel">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if(sizeof($promos) > 0)
                                    <div id="promo_slider_store" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox" >

                                            <?PHP $promoCount = sizeof($promos); ?>

                                            <div class="carousel-item active">

                                                <h3 class="text-center m-b-5 text-danger"> {{ strtoupper($promos[0]['promo_name']) }}</h3>
                                                <h6 class="text-center m-b-20  text-white"><br></h6>
                                                <div class="row">

                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER ON MOST RECENT DAY</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 7 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 30 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER SINCE STARTING THE PROMO</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            @for($x = 1; $x < $promoCount; $x++)
                                                <div class="carousel-item">

                                                    <h3 class="text-center m-b-5 text-danger stat-header-h3"> {{ strtoupper($promos[$x]['promo_name']) }}</h3>
                                                    <h6 class="text-center m-b-20  text-white"><br></h6>
                                                    <div class="row">

                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER ON MOST RECENT DAY</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 7 DAYS</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 30 DAYS</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['cp_1'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['cp_2'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['cp_3'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['cp_4'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['new_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">NEW CUSTOMER SINCE STARTING THE PROMO</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            @endfor

                                        </div>

                                        <a class="carousel-control-prev" href="#promo_slider_store" role="button" data-slide="prev">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow_left.png')}}" style="width: 70px;" > </span>
                                            <span class="sr-only">Prev</span>
                                        </a>
                                        <a class="carousel-control-next" href="#promo_slider_store" role="button" data-slide="next">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow.png')}}" style="width: 70px;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                @else
                                    {{ 'You have No Promos.. Please create a Promo.. '}}

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="tab-pane-3" role="tabpanel">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if(sizeof($all_stats) > 0)
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">

                                                <h3 class="text-center m-b-5 text-danger"> ALL STATS </h3>
                                                <h6 class="text-center m-b-20  text-white"><br></h6>
                                                <div class="row">

                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['recent_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['recent_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['recent_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['recent_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['recent_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER ON MOST RECENT DAY</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['7_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['7_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['7_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['7_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['7_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 7 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['30_day']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['30_day']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['30_day']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['30_day']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['30_day']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER IN LAST 30 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['all']['cp_1'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['all']['cp_2'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['all']['cp_3'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['all']['cp_4'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $all_stats[0]['all']['new_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER SINCE STARTING THE PROMO</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        {{--<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">--}}
                                        {{--<span> <img src="{{asset('resources/assets/custom/images/arrow.png')}}" style="width: 70px;" > </span>--}}
                                        {{--<span class="sr-only">Next</span>--}}
                                        {{--</a>--}}
                                    </div>
                                @else
                                    {{ 'You have No Stats.. '}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane p-20 " id="tab-pane-4" role="tabpanel">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="row">

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <form class="" action="user/retarget/create" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6">

                                            <div class="form-group">
                                                <label class="control-label col-md-12 col-lg-12">Select Store</label>
                                                <div class="col-sm-12 col-md-8 col-lg-8 store_container left_scroll">
                                                    <table class="category_table">
                                                        @if(sizeof($active_stores)>0)
                                                            @foreach($active_stores as $store)

                                                                <tr>
                                                                    <td style="width:5%;">&nbsp;</td>
                                                                    <td style="width:93%;">{{$store->contact_name}}</td>
                                                                    <td style="width:2%;">
                                                                        <label class="btn-container">
                                                                            <input type="checkbox" value="{{ $store->place_id }}" id="store2{{ $store->place_id }}" name="store[]" onclick="get_retarget_coupons({{ $store->place_id }}, 2);" class="radio">
                                                                            <span class="checkmark"></span>

                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </table>
                                                    <input type="hidden" name="store_id" id="store_id_1" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Coupon Name</label>
                                                <input type="text" id="coupon_name_1" name="coupon_name" class="form-control" placeholder="Enter Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Estimated Value</label>
                                                <input type="number" id="coupon_value_1" name="coupon_value" class="form-control" placeholder="" required min="0" step="0.1">
                                            </div>
                                            

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">

                                            <div class="form-group">
                                                <label class="control-label">Coupon Photo</label>
                                                <div id="img_cropper_c_1">
                                                    <div class="uploader" id="uploader_c_1">

                                                        <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                        <b>Drag and drop a file here or click</b>

                                                        <input type="file" name="coupon_photo" id="coupon_photo_c_1" class="filePhoto cropit-image-input" >
                                                    </div>
                                                        
                                                    <div class="cropit-preview" id="cropper_prev_c_1"></div>
                                                    <input type="range" class="cropit-image-zoom-input" id="ranger_c_1"/>
                                                    

                                                    <button id="crop_btn_c_1" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                    <button id="rem_c_1" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                    <input type="hidden" name="cp_img_name_1" id="cp_img_name_c_1">
                                                </div>

                                                <!-- <input type="file" id="coupon_photo_1" name="coupon_photo" class="dropify" data-height="100"  required /> -->
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="control-label">Choose Or Upload AR Coupon</label>
                                                <table id="searc_ar_model">
                                                    <tr>
                                                        <td style="color: #e80602;"><br><br>SEARCH</td>
                                                        <td><br><br><input type="text" class="custom-input" id="search_coupon_1" oninput="search_ar_models(1,this.value);" ></td>
                                                        <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="ar_search_res" id="ar_search_result_1"></div>
                                                    </div>
                                                    <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_1" >
                                                    <input type="hidden" name="ar_coupon_name" id="ar_coupon_name_1">
                                                    <input type="hidden" name="ar_marker_name" id="ar_marker_name_1">
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <label class="control-label">Coupon Info & Basic Conditions</label>
                                                <textarea id="coupon_info_1" name="coupon_info" class="form-control" placeholder="" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Detailed Terms & Conditions</label>
                                                <textarea id="coupon_condition_1" name="coupon_condition" class="form-control" placeholder="" required></textarea>
                                            </div>


                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <button type="submit" class="custom_btn_2 col-12 send_push" name="send_push"></button>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <button type="submit" class="custom_btn_2 col-12 start_geo" name="start_geo" id="geo_start"></button>
                                                    <button type="submit" class="custom_btn_2 col-12 stop_geo" name="stop_geo" id="geo_stop" style="display: none"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="stat-container">
                                            <br>
                                            <h5 class="text-center text-danger" style=""><b> PUSH STATS</b></h5>
                                            <p class="text-center text-danger"><b>( Current )</b></p>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_push_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">RECEIVED LAST PUSH COUPON</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_push_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">USED LAST PUSH COUPON</p>
                                                </div>
                                            </div>
                                            <br>
                                            <p class="text-center text-danger"><b>( All Time )</b></p>
                                            <br>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_push_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL PUSH COUPONS RECEIVED</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_push_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL PUSH COUPONS USED</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="stat-container">
                                            <br>
                                            <h5 class="text-center text-danger" style=""><b> GEO STATS</b></h5>
                                            <p class="text-center text-danger"><b>( Current )</b></p>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_geo_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">GEO COUPONS RECEIVED</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_geo_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">GEO COUPONS USED</p>
                                                </div>
                                            </div>
                                            <br>
                                            <p class="text-center text-danger"><b>( All Time )</b></p>
                                            <br>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_geo_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL GEO COUPONS RECEIVED</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_geo_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL GEO COUPONS USED</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab-pane-5" role="tabpanel">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                            @if(sizeof($promos) > 0)
                                    <div id="loyalty_slider_store" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <?PHP $promoCount = sizeof($promos); ?>

                                            <div class="carousel-item active">

                                                <h3 class="text-center m-b-5 text-danger"> {{ strtoupper($promos[0]['promo_name']) }}</h3>
                                                <h6 class="text-center m-b-20  text-white"><br></h6>
                                                <div class="row">

                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['ret_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['loy_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['recent_day']['revenue'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">REVENUE ON THE MOST RECENT DAY</p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['ret_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['loy_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['7_day']['revenue'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">REVENUE IN LAST 7 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['ret_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['loy_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['30_day']['revenue'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">REVENUE IN LAST 30 DAYS</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['ret_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['loy_c'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" >{{ $promos[0]['all']['revenue'] }}</h2>
                                                                        <p class="text-center stat_lable" id="">REVENUE SINCE STARTING THE PROMO</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            @for($x = 1; $x < $promoCount; $x++)
                                                <div class="carousel-item">

                                                    <h3 class="text-center m-b-5 text-danger"> {{ strtoupper($promos[$x]['promo_name']) }}</h3>
                                                <h6 class="text-center m-b-20  text-white"><br></h6>
                                                    <div class="row">

                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['ret_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['loy_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['recent_day']['revenue'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">REVENUE ON THE MOST RECENT DAY</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['ret_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['loy_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['7_day']['revenue'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">REVENUE IN LAST 7 DAYS</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['ret_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['loy_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['30_day']['revenue'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">REVENUE IN LAST 30 DAYS</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['ret_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">RETURNING CUSTOMERS</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['loy_c'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">LOYALTY  COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">LOYALTY COUPONS BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" >{{ $promos[$x]['all']['revenue'] }}</h2>
                                                                            <p class="text-center stat_lable" id="">REVENUE SINCE STARTING THE PROMO</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
VE
                                                    </div>

                                                </div>
                                            @endfor

                                        </div>


                                        <a class="carousel-control-next" href="#loyalty_slider_store" role="button" data-slide="next">
                                        <a class="carousel-control-prev" href="#promo_slider_store" role="button" data-slide="prev">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow_left.png')}}" style="width: 70px;" > </span>
                                            <span class="sr-only">Prev</span>
                                        </a>
                                        <a class="carousel-control-next" href="#loyalty_slider_store" role="button" data-slide="next">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow.png')}}" style="width: 70px;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                @else
                                    {{ 'You have No Promos.. Please create a Promo.. '}}

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

<!-- | Custom css for this page only | -->
@section('custom_css')
@endsection

<!-- | Custom js for this page only | -->
@section('custom_js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dropify').dropify();

            //$('#loyalty_coupon_c_1').prop('checked', true);
            $('.cropit-preview').hide();
            $('.crop_btn').hide();
            $('.res_btn').hide();
            $('.cropit-image-zoom-input').hide();
        });

        function cloased_tab(){
//      set_stat_tile();
        }

        $('#img_cropper_c_1').cropit();

        function crop_image(page, id) {

            var imageData = $('#img_cropper_' + page + '_' + id).cropit('export');
            $('#cp_img_name_' + page + '_' + id).val(imageData);
            // $('#image_' + page + '_' + id).attr('src', imageData);

        }

        function activate_cropper(page, id) {
            $('#uploader_' + page + '_' + id).hide();
            $('#cropper_prev_' + page + '_' + id).show();
            $('#ranger_' + page + '_' + id).show();
            $('#crop_btn_' + page + '_' + id).show();
            $('#rem_' + page + '_' + id).show();
        }

        function clear_cropper(page, id) {
            $('#uploader_' + page + '_' + id).show();
            $('#cropper_prev_' + page + '_' + id).hide();
            $('#ranger_' + page + '_' + id).hide();
            $('#crop_btn_' + page + '_' + id).hide();
            $('#rem_' + page + '_' + id).hide();

            $('#cp_img_name_' + page + '_' + id).val('');
            // $('#image_' + page + '_' + id).attr('src',"{{ asset('resources/assets/user/images/imageplaceholder.png') }}" );
        }

        $('#coupon_photo_c_1').on('change', function() {
            activate_cropper('c', 1);
        });

        $('#crop_btn_c_1').on('click',function () {
            crop_image('c', 1);
        });

        $('#rem_c_1').on('click', function() {
            clear_cropper('c', 1);
        });

        $(".radio").change(function() {
            $(".radio").prop('checked', false);
            $(this).prop('checked', true);
        });

        function search_ar_models(id, input) {
            $.get("{{ url('user/search_ar_models') }}/"+input,function(data){
                console.log(data);
                var list = '<ul>';
                for(var x =0; x < data.length; x++){
                    var ar_image = data[x]['image_thumbnail'];
                    var ar_name = data[x]['image_tags'];
                    var ar_marker = data[x]['marker'];
                    list += "<li><p class='ar_list' onclick='showInPrev("+id+",\""+ar_image+"\",\""+ar_marker+"\");'>"+ar_name+"</p></li>";

                }
                list+="</ul>";

                $('#ar_search_result_'+id).html(list);
            });
        }

        function showInPrev(id,ar_image, ar_marker){
            $('#ar_prev_'+id).attr('src', "{{url('resources/assets/media')}}/"+ar_image);
            $('#ar_coupon_name_'+id).val(ar_image);
            $('#ar_marker_name_'+id).val(ar_marker);

           $('#ar_search_result_'+id).hide();
        }

        function get_retarget_coupons(store_id) {
            // set store id
            $('#store_id_1').val(store_id);

            // get retarget coupon details
            $.get("{{ url('user/retarget/get_details') }}/"+parseInt(store_id),function(data){
//                alert(data);
                console.log(data);

                // empty form
                $('#coupon_name_1').val('');
                $('#coupon_value_1').val('');
                $('#coupon_info_1').val('');
                $('#coupon_condition_1').val('');
                $('#ar_coupon_name_1').val('');
                $('#ar_marker_name_1').val('');

                $('#ar_prev_1').attr('src',"{{url('resources/assets/custom/images/no-image.png')}}");


                // set data to form
                var coupon = data['coupon_data'];


                if(coupon.length > 0) {
                    console.log(coupon);

                    $('#coupon_name_1').val(coupon[0]['coupon_name']);
                    $('#coupon_value_1').val(coupon[0]['estimated_value']);
                    $('#coupon_info_1').val(coupon[0]['coupon_info']);
                    $('#coupon_condition_1').val(coupon[0]['coupon_details']);
                    $('#ar_coupon_name_1').val(coupon[0]['coupon_ar']);
                    $('#ar_marker_name_1').val(coupon[0]['coupon_marker']);

                    $('#coupon_photo_1').prop('required', false);
                    $('#ar_prev_1').attr('src', "{{url('resources/assets/media')}}/" + coupon[0]['coupon_ar']);

                    $('#geo_start').hide();
                    $('#geo_stop').show();
                } else {
                    $('#geo_start').show();
                    $('#geo_stop').hide();
                }



                // set stat
                var last_push = data['last_push'];
                var all_push = data['all_push'];
                var last_geo = data['last_geo'];
                var all_geo = data['all_geo'];

                $('#last_push_rec').html(last_push['received']);
                $('#last_push_used').html(last_push['used']);
                $('#all_push_rec').html(all_push['received']);
                $('#all_push_used').html(all_push['used']);
                $('#last_geo_rec').html(last_geo['received']);
                $('#last_geo_used').html(last_geo['used']);
                $('#all_geo_rec').html(all_geo['received']);
                $('#all_geo_used').html(all_geo['used']);


            });
        }



    </script>
@endsection
