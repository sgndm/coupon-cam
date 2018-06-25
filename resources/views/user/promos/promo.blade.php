@extends('layouts.user')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <ul class="nav nav-tabs customtab" role="tablist">

                @if($has_promos == 0)
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab" onclick="create_tab();">
                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                        <span class="hidden-xs-down">CREATE PROMO</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" onclick="open_tab();">
                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                        <span class="hidden-xs-down">ACTIVE PROMOS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab" onclick="cloased_tab();">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">PUASED PROMOS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-4" role="tab" onclick="finished_tab();">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">FINISHED PROMOS</span>
                    </a>
                </li>
                @else 
                
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" onclick="open_tab();">
                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                        <span class="hidden-xs-down">ACTIVE PROMOS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab" onclick="cloased_tab();">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">PUASED PROMOS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-4" role="tab" onclick="finished_tab();">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">FINISHED PROMOS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#tab-pane-1" role="tab" onclick="create_tab();">
                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                        <span class="hidden-xs-down">CREATE PROMO</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-5" role="tab">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">
                        <table>
                            <tr>
                                <td>SEARCH</td>
                                <td><input type="text" class="custom-input" id="search_promo" ></td>
                                <td><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                            </tr>
                        </table>
                    </span>
                    </a>
                </li>

            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                @if($has_promos == 0)
                <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">
                @else
                <div class="tab-pane p-20" id="tab-pane-1" role="tabpanel">
                @endif
                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/promos/create_promo') }}" id="promo_form_1">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Store</label>
                                            <div class="col-sm-12 col-md-12 col-lg-12 store_p_container left_scroll" >
                                                <table class="category_table">
                                                    @foreach($stores as $key => $store)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{ $store->contact_name . " - " . $store->city }}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox" value="{{ $store->place_id }}" id="store{{ $store->place_id }}" name="store_ids_1[]" onclick="get_store_details({{ $store->place_id }});error_hide('promo_store_error_1');">
                                                                    <span class="checkmark"></span>
                                                                    <input type="hidden" value="{{$store->latitude}}" id="store_lat_{{ $store->place_id  }}" name="store_lat_{{ $store->place_id }}">
                                                                    <input type="hidden" value="{{$store->longitude}}" id="store_lng_{{ $store->place_id  }}" name="store_lng_{{ $store->place_id }}">
                                                                    <input type="hidden" value="0" id="store_loc_{{ $store->place_id  }}" name="store_loc_{{ $store->place_id }}">
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <h6 class="form-control-feedback text-danger" id="promo_store_error_1"> </h6>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">AR Coupon Location</label>
                                            <label class="btn-container">Outside Store
                                                <input type="radio" name="ar_placement" id="ar_inside" checked>
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Somewhere Else
                                                <input type="radio" name="ar_placement" id="ar_elsewhere">
                                                <span class="checkRadio"></span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Select Store Marker On Map</label>
                                            <input type="text" id="store_address_1" name="store_address" class="form-control" placeholder="Start Typing Full Address..." >
                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Promo Name</label>
                                            <input type="text" id="promo_name_1" name="promo_name" class="form-control" placeholder="Enter Name" required oninput="error_hide('promo_name_error_1');">
                                            <h6 class="form-control-feedback text-danger" id="promo_name_error_1"> </h6>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="control-label">Promo Description</label>
                                            <textarea id="promo_description_1" name="promo_description" class="form-control" placeholder="Describe Your Promo" required oninput="error_hide('promo_desc_error_1');"></textarea>
                                            <h6 class="form-control-feedback text-danger" id="promo_desc_error_1"> </h6>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="control-label">Promo Frequency</label>
                                            <label class="btn-container">Daily
                                                <input type="radio" name="repeat_promo_1" id="Daily_1" value="Daily" checked onclick="showHideRepeat('Daily',1);error_hide('promo_repeat_error_1');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Monday - Friday
                                                <input type="radio" name="repeat_promo_1" id="Week_1" value="Week" onclick="showHideRepeat('Week',1);error_hide('promo_repeat_error_1');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Saturday - Sunday
                                                <input type="radio" name="repeat_promo_1" id="Weekend_1" value="Weekend" onclick="showHideRepeat('Weekend',1);error_hide('promo_repeat_error_1');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">One Time Offer
                                                <input type="radio" name="repeat_promo_1" id="Date_1" value="Date" onclick="showHideRepeat('Date',1);error_hide('promo_repeat_error_1');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Custom
                                                <input type="radio" name="repeat_promo_1" id="Days_1" value="Days" onclick="showHideRepeat('Days',1);error_hide('promo_repeat_error_1');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <h6 class="form-control-feedback text-danger" id="promo_repeat_error_1"> </h6>
                                        </div>

                                        <div class="form-group repeat-me" style="margin-bottom:0px; clear:right;">
                                            <div class="fordate_1" style="display: none;">
                                                <label for="repeat_promo">Select Date</label><div class="clearfix"></div>
                                                <input type="date" name="promo_date" id="promo_date_1" class="form-control date-picker" oninput="error_hide('promo_repeat_date_error_1');"/>
                                                <h6 class="form-control-feedback text-danger" id="promo_repeat_date_error_1"> </h6>
                                            </div>
                                            <div class="fordays_1" style="display: none;">
                                                <label for="repeat_promo">Select Days</label>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="col-md-6 btn-container"  >Monday
                                                        <input type="checkbox" value="1" name="days_1[]" id="mon_1" onclick="error_hide('promo_repeat_days_error_1');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Tuesday
                                                        <input type="checkbox" value="2" name="days_1[]" id="tue_1" onclick="error_hide('promo_repeat_days_error_1');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Wednesday
                                                        <input type="checkbox" value="3" name="days_1[]" id="wed_1" onclick="error_hide('promo_repeat_days_error_1');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Thursday
                                                        <input type="checkbox" value="4" name="days_1[]" id="thu_1" onclick="error_hide('promo_repeat_days_error_1');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Friday
                                                        <input type="checkbox" value="5" name="days_1[]" id="fri_1" onclick="error_hide('promo_repeat_days_error_1');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Saturday
                                                        <input type="checkbox" value="6" name="days_1[]" id="sat_1" onclick="error_hide('promo_repeat_days_error_1');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Sunday
                                                        <input type="checkbox" value="7" name="days_1[]" id="sun_1" onclick="error_hide('promo_repeat_days_error_1');">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <h6 class="form-control-feedback text-danger" id="promo_repeat_days_error_1"> </h6>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Start Time </label>
                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                <input type="time" class="form-control" value="" name="promo_start" id="promo_start_1"  onclick="error_hide('promo_start_error_1');">

                                            </div>
                                            <h6 class="form-control-feedback text-danger" id="promo_start_error_1"> </h6>

                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Promo Length</label>
                                            <select class="form-control custom-select" name="promo_length" id="promo_length_1">
                                                @for($x = 1; $x <= 24; $x++)
                                                    <option val="{{$x}}">{{$x}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label class="control-label">Advanced Warning</label><br>
                                            <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="advance_warning" id="advance_warning_1" />
                                        </div>

                                        {{--<div class="form-group" style="display: none;">--}}
                                        {{--<img src="" style="width:100%;" id="qr_code_prev_1">--}}
                                        {{--<input type="hidden" name="promo_qr_code" id="promo_qr_code_1" >--}}
                                        {{--<input type="hidden" name="promo_qr_image" id="promo_qr_image_1" >--}}

                                        {{--<div class="row justify-content-center">--}}
                                        {{--<button type="button" class="custom_btn crt_qr_code col-md-8" style="margin:2px;" onclick="generate_qr_code(1);" id="crt_qr_1"></button>--}}

                                        {{--<!-- <a class="" style="margin:2px;" target="_blank" href="" id="print_code_1" >--}}
                                        {{--<img src="{{url('resources/assets/custom/images/eedit_qr_code.png')}}" style="width:140px; height: 40px; cursor:pointer;" alt="">--}}
                                        {{--</a> -->--}}

                                        {{--<button type="button" class="custom_btn view_qr_code col-md-8" style="margin:2px;" onclick="view_qr_code(1);" id="print_code_1"></button>--}}

                                        {{--<button type="button" class="custom_btn refresh_qr_code col-md-8" style="margin:2px;" onclick="refresh_qr(1);" id="refresh_qr_1"></button>--}}

                                        {{--</div>--}}

                                        {{--</div>--}}

                                        <div class="form-group">
                                            <button type="button" class="custom_btn save_c col-md-8" onclick="validate_form(1);"></button>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <h1 class="text-center" style="font-size: 26px;"> Drag Marker To Desired Location</h1>
                                <div id="map1" style="height: 400px;"></div>
                            </div>

                        </div>
                    </form>
                </div>
                @if($has_promos == 0)
                <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                @else
                <div class="tab-pane active p-20" id="tab-pane-2" role="tabpanel">
                @endif
                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/promos/update_promo') }}" id="promo_form_2">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="row">
                                    <input type="hidden" name="formid" id="formid_2">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Promo</label>
                                            <div class="col-sm-12 col-md-12 col-lg-12 store_p_container left_scroll" >
                                                <table class="category_table">
                                                    @foreach($activePromos as $promo)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{ $promo->promo_name }}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox"  value="{{ $promo->promo_id }}" id="store{{ $promo->promo_id }}" name="promos[]" onclick="get_promo_details({{ $promo->promo_id }},2);error_hide('promo_store_error_2');" class="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <h6 class="form-control-feedback text-danger" id="promo_store_error_2"> </h6>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">AR Coupon Location</label>
                                            <label class="btn-container">Outside Store
                                                <input type="radio" name="ar_placement" id="ar_inside" checked>
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Somewhere Else
                                                <input type="radio" name="ar_placement" id="ar_elsewhere">
                                                <span class="checkRadio"></span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Select Store Marker On Map</label>
                                            <input type="text" id="store_address_1" name="store_address" class="form-control" placeholder="Start Typing Full Address..." >
                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Promo Name</label>
                                            <input type="text" id="promo_name_2" name="promo_name" class="form-control" placeholder="Enter Name" required oninput="error_hide('promo_name_error_2');">
                                            <h6 class="form-control-feedback text-danger" id="promo_name_error_2"> </h6>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="control-label">Promo Description</label>
                                            <textarea id="promo_description_2" name="promo_description" class="form-control" placeholder="Describe Your Promo" required oninput="error_hide('promo_desc_error_2');"></textarea>
                                            <h6 class="form-control-feedback text-danger" id="promo_desc_error_2"> </h6>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="control-label">Promo Frequency</label>
                                            <label class="btn-container">Daily
                                                <input type="radio" name="repeat_promo_2" id="Daily_2" value="Daily" checked onclick="showHideRepeat('Daily',2);error_hide('promo_repeat_error_2');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Monday - Friday
                                                <input type="radio" name="repeat_promo_2" id="Week_2" value="Week" onclick="showHideRepeat('Week',2);error_hide('promo_repeat_error_2');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Saturday - Sunday
                                                <input type="radio" name="repeat_promo_2" id="Weekend_2" value="Weekend" onclick="showHideRepeat('Weekend',2);error_hide('promo_repeat_error_2');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">One Time Offer
                                                <input type="radio" name="repeat_promo_2" id="Date_2" value="Date" onclick="showHideRepeat('Date',2);error_hide('promo_repeat_error_2');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Custom
                                                <input type="radio" name="repeat_promo_2" id="Days_2" value="Days" onclick="showHideRepeat('Days',2);error_hide('promo_repeat_error_2');">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <h6 class="form-control-feedback text-danger" id="promo_repeat_error_2"> </h6>
                                        </div>

                                        <div class="form-group repeat-me" style="margin-bottom:0px; clear:right;">
                                            <div class="fordate_2" style="display: none;">
                                                <label for="repeat_promo">Select Date</label><div class="clearfix"></div>
                                                <input type="date" name="promo_date" id="promo_date_2" class="form-control date-picker" oninput="error_hide('promo_repeat_date_error_2');"/>
                                                <h6 class="form-control-feedback text-danger" id="promo_repeat_date_error_2"> </h6>
                                            </div>
                                            <div class="fordays_2" style="display: none;">
                                                <label for="repeat_promo">Select Days</label>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="col-md-6 btn-container"  >Monday
                                                        <input type="checkbox" value="1" name="days_2[]" id="a1" onclick="error_hide('promo_repeat_days_error_2');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Tuesday
                                                        <input type="checkbox" value="2" name="days_2[]" id="a2" onclick="error_hide('promo_repeat_days_error_2');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Wednesday
                                                        <input type="checkbox" value="3" name="days_2[]" id="a3" onclick="error_hide('promo_repeat_days_error_2');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Thursday
                                                        <input type="checkbox" value="4" name="days_2[]" id="a4" onclick="error_hide('promo_repeat_days_error_2');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Friday
                                                        <input type="checkbox" value="5" name="days_2[]" id="a5" onclick="error_hide('promo_repeat_days_error_2');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Saturday
                                                        <input type="checkbox" value="6" name="days[]" id="a6" onclick="error_hide('promo_repeat_days_error_2');">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Sunday
                                                        <input type="checkbox" value="7" name="days_2[]" id="a7" onclick="error_hide('promo_repeat_days_error_2');">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <h6 class="form-control-feedback text-danger" id="promo_repeat_days_error_2"> </h6>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Start Time </label>
                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                <input type="time" class="form-control" value="" name="promo_start" id="promo_start_2" oninput="error_hide('promo_start_error_2')">
                                            </div>
                                            <h6 class="form-control-feedback text-danger" id="promo_start_error_2"> </h6>

                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Promo Length</label>
                                            <select class="form-control custom-select" name="promo_length" id="promo_length_2">
                                                @for($x = 1; $x <= 24; $x++)
                                                    <option val="{{$x}}">{{$x}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label class="control-label">Advanced Warning</label><br>
                                            <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="advance_warning" id="advance_warning_2" />
                                        </div>

                                        {{--<div class="form-group"  style="display: none;">--}}
                                        {{--<img src="" style="width:100%;" id="qr_code_prev_2">--}}
                                        {{--<input type="hidden" name="promo_qr_code" id="promo_qr_code_2" >--}}
                                        {{--<input type="hidden" name="promo_qr_image" id="promo_qr_image_2" >--}}

                                        {{--<div class="row justify-content-center">--}}
                                        {{--<button type="button" class="custom_btn crt_qr_code col-md-8" style="margin:2px;" onclick="generate_qr_code(2);" id="crt_qr_2"></button>--}}

                                        {{--<button type="button" class="custom_btn view_qr_code col-md-8" style="margin:2px;" onclick="view_qr_code(2);" id="print_code_2"></button>--}}

                                        {{--<button type="button" class="custom_btn refresh_qr_code col-md-8" style="margin:2px;" onclick="refresh_qr(3);" id="refresh_qr_2"></button>--}}
                                        {{--<button type="submit" name="update_promo" class="col-md-8 custom_btn up_promo"></button>--}}
                                        {{--<button type="submit" name="pause_promo" class="col-md-8 custom_btn paus_promo"></button>--}}
                                        {{--</div>--}}



                                        {{--</div>--}}

                                        <div class="form-group">
                                            <button type="button" name="update_promo" class="col-md-8 custom_btn up_promo" onclick="validate_form(2);"></button>
                                            <button type="submit" name="pause_promo" class="col-md-8 custom_btn paus_promo"></button>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <h1 class="text-center" style="font-size: 26px;"> Drag Marker To Desired Location</h1>
                                <div id="map2" style="height: 400px;"></div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/promos/delete_promo') }}">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="row">

                                    <input type="hidden" name="formid" id="formid_3">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Promo</label>
                                            <div class="col-sm-12 col-md-12 col-lg-12 store_p_container left_scroll" >
                                                <table class="category_table">
                                                    @foreach($puasedPromos as $promo)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{ $promo->promo_name }}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox"  value="{{ $promo->promo_id }}" id="store{{ $promo->promo_id }}" name="promos[]" onclick="get_promo_details({{ $promo->promo_id }},3);" class="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">AR Coupon Location</label>
                                            <label class="btn-container">Outside Store
                                                <input type="radio" name="ar_placement" id="ar_inside" checked>
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Somewhere Else
                                                <input type="radio" name="ar_placement" id="ar_elsewhere">
                                                <span class="checkRadio"></span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Select Store Marker On Map</label>
                                            <input type="text" id="store_address_1" name="store_address" class="form-control" placeholder="Start Typing Full Address..." >
                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Promo Name</label>
                                            <input type="text" id="promo_name_3" name="promo_name" class="form-control" placeholder="Enter Name" required>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="control-label">Promo Description</label>
                                            <textarea id="promo_description_3" name="promo_description" class="form-control" placeholder="Describe Your Promo" required></textarea>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="control-label">Promo Frequency</label>
                                            <label class="btn-container">Daily
                                                <input type="radio" name="repeat_promo" id="Daily_3" value="Daily" checked onclick="showHideRepeat('Daily',3)">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Monday - Friday
                                                <input type="radio" name="repeat_promo" id="Week_3" value="Week" onclick="showHideRepeat('Week',3)">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Saturday - Sunday
                                                <input type="radio" name="repeat_promo" id="Weekend_3" value="Weekend" onclick="showHideRepeat('Weekend',3)">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">One Time Offer
                                                <input type="radio" name="repeat_promo" id="Date_3" value="Date" onclick="showHideRepeat('Date',3)">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Custom
                                                <input type="radio" name="repeat_promo" id="Days_3" value="Days" onclick="showHideRepeat('Days',3)">
                                                <span class="checkRadio"></span>
                                            </label>

                                        </div>

                                        <div class="form-group repeat-me" style="margin-bottom:0px; clear:right;">
                                            <div class="fordate_3" style="display: none;">
                                                <label for="repeat_promo">Select Date</label><div class="clearfix"></div>
                                                <input type="date" name="promo_date" id="promo_date_3" class="form-control date-picker"/>
                                            </div>
                                            <div class="fordays_3" style="display: none;">
                                                <label for="repeat_promo">Select Days</label>
                                                <div class="clearfix"></div>
                                                <div class="form-group">
                                                    <label class="col-md-6 btn-container"  >Monday
                                                        <input type="checkbox" value="1" name="days[]" id="p1">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Tuesday
                                                        <input type="checkbox" value="2" name="days[]" id="p2">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Wednesday
                                                        <input type="checkbox" value="3" name="days[]" id="p3">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Thursday
                                                        <input type="checkbox" value="4" name="days[]" id="p4">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Friday
                                                        <input type="checkbox" value="5" name="days[]" id="p5">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Saturday
                                                        <input type="checkbox" value="6" name="days[]" id="p6">
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <label class="col-md-6 btn-container"  >Sunday
                                                        <input type="checkbox" value="7" name="days[]" id="p7">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Start Time </label>
                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                <input type="time" class="form-control" value="" name="promo_start" id="promo_start_3">
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Promo Length</label>
                                            <select class="form-control custom-select" name="promo_length" id="promo_length_3">
                                                @for($x = 1; $x <= 24; $x++)
                                                    <option val="{{$x}}">{{$x}}</option>
                                                @endfor
                                            </select>
                                        </div>


                                        <div class="form-group" style="display: none;">
                                            <label class="control-label">Advanced Warning</label><br>
                                            <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="advance_warning" id="advance_warning_3" />
                                        </div>

                                        {{--<div class="form-group" style="display: none;">--}}
                                        {{--<img src="" style="width:100%;" id="qr_code_prev_3">--}}

                                        {{--</div>--}}



                                        <div class="row justify-content-center">
                                            <button type="submit" name="activate_promo" class="col-md-8 custom_btn act_promo"></button>
                                            <button type="submit" name="finish_promo" class="col-md-8 custom_btn finish_promo"></button>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <h1 class="text-center" style="font-size: 26px;"> Drag Marker To Desired Location</h1>
                                <div id="map3" style="height: 400px;"></div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="tab-pane p-20" id="tab-pane-4" role="tabpanel">
                    <div class="row">

                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="row">

                                <input type="hidden" name="formid" id="formid_4">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Select Promo</label>
                                        <div class="col-sm-12 col-md-12 col-lg-12 store_p_container left_scroll" >
                                            <table class="category_table">
                                                @foreach($finishedPromos as $promo)

                                                    <tr>
                                                        <td style="width:5%;">&nbsp;</td>
                                                        <td style="width:93%;">{{ $promo->promo_name }}</td>
                                                        <td style="width:2%;">
                                                            <label class="btn-container">
                                                                <input type="checkbox"  value="{{ $promo->promo_id }}" id="store{{ $promo->promo_id }}" name="promos[]" onclick="get_promo_details({{ $promo->promo_id }},4);" class="radio">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">AR Coupon Location</label>
                                        <label class="btn-container">Outside Store
                                            <input type="radio" name="ar_placement" id="ar_inside" checked>
                                            <span class="checkRadio"></span>
                                        </label>
                                        <label class="btn-container">Somewhere Else
                                            <input type="radio" name="ar_placement" id="ar_elsewhere">
                                            <span class="checkRadio"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Select Store Marker On Map</label>
                                        <input type="text" id="store_address_4" name="store_address" class="form-control" placeholder="Start Typing Full Address..." >
                                    </div>
                                </div>

                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Promo Name</label>
                                        <input type="text" id="promo_name_4" name="promo_name" class="form-control" placeholder="Enter Name" required>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label">Promo Description</label>
                                        <textarea id="promo_description_4" name="promo_description" class="form-control" placeholder="Describe Your Promo" required></textarea>
                                    </div> -->

                                    <div class="form-group">
                                        <label class="control-label">Promo Frequency</label>
                                        <label class="btn-container">Daily
                                            <input type="radio" name="repeat_promo" id="Daily_4" value="Daily" checked onclick="showHideRepeat('Daily',4)">
                                            <span class="checkRadio"></span>
                                        </label>
                                        <label class="btn-container">Monday - Friday
                                            <input type="radio" name="repeat_promo" id="Week_4" value="Week" onclick="showHideRepeat('Week',4)">
                                            <span class="checkRadio"></span>
                                        </label>
                                        <label class="btn-container">Saturday - Sunday
                                            <input type="radio" name="repeat_promo" id="Weekend_4" value="Weekend" onclick="showHideRepeat('Weekend',4)">
                                            <span class="checkRadio"></span>
                                        </label>
                                        <label class="btn-container">One Time Offer
                                            <input type="radio" name="repeat_promo" id="Date_4" value="Date" onclick="showHideRepeat('Date',4)">
                                            <span class="checkRadio"></span>
                                        </label>
                                        <label class="btn-container">Custom
                                            <input type="radio" name="repeat_promo" id="Days_4" value="Days" onclick="showHideRepeat('Days',4)">
                                            <span class="checkRadio"></span>
                                        </label>

                                    </div>

                                    <div class="form-group repeat-me" style="margin-bottom:0px; clear:right;">
                                        <div class="fordate_3" style="display: none;">
                                            <label for="repeat_promo">Select Date</label><div class="clearfix"></div>
                                            <input type="date" name="promo_date" id="promo_date_4" class="form-control date-picker"/>
                                        </div>
                                        <div class="fordays_3" style="display: none;">
                                            <label for="repeat_promo">Select Days</label>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <label class="col-md-6 btn-container"  >Monday
                                                    <input type="checkbox" value="1" name="days[]" id="f1">
                                                    <span class="checkmark"></span>
                                                </label>

                                                <label class="col-md-6 btn-container"  >Tuesday
                                                    <input type="checkbox" value="2" name="days[]" id="f2">
                                                    <span class="checkmark"></span>
                                                </label>

                                                <label class="col-md-6 btn-container"  >Wednesday
                                                    <input type="checkbox" value="3" name="days[]" id="f3">
                                                    <span class="checkmark"></span>
                                                </label>

                                                <label class="col-md-6 btn-container"  >Thursday
                                                    <input type="checkbox" value="4" name="days[]" id="f4">
                                                    <span class="checkmark"></span>
                                                </label>

                                                <label class="col-md-6 btn-container"  >Friday
                                                    <input type="checkbox" value="5" name="days[]" id="f5">
                                                    <span class="checkmark"></span>
                                                </label>

                                                <label class="col-md-6 btn-container"  >Saturday
                                                    <input type="checkbox" value="6" name="days[]" id="f6">
                                                    <span class="checkmark"></span>
                                                </label>

                                                <label class="col-md-6 btn-container"  >Sunday
                                                    <input type="checkbox" value="7" name="days[]" id="f7">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Time </label>
                                        <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                            <input type="time" class="form-control" value="" name="promo_start" id="promo_start_4">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Promo Length</label>
                                        <select class="form-control custom-select" name="promo_length" id="promo_length_4">
                                            @for($x = 1; $x <= 24; $x++)
                                                <option val="{{$x}}">{{$x}}</option>
                                            @endfor
                                        </select>
                                    </div>


                                    <div class="form-group" style="display: none;">
                                        <label class="control-label">Advanced Warning</label><br>
                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="advance_warning" id="advance_warning_4" />
                                    </div>

                                    <div class="form-group" style="display: none;">
                                        <img src="" style="width:100%;" id="qr_code_prev_4">

                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <h6 class="text-center" style=""> FINAL PROMO STATISTICS</h6>
                            <div class="stat-container">
                                <div class="col-12 row justify-content-center">
                                    <div class="stat-tile">
                                        <h2 class="text-center stat_count" id="day_count" >0</h2>
                                        <p class="text-center stat_lable" id="">TOTAL DAYS RUNNING</p>
                                    </div>
                                    <div class="stat-tile">
                                        <h2 class="text-center stat_count" id="coupon_count" >0</h2>
                                        <p class="text-center stat_lable" id="">TOTAL COUPONS ISSUED</p>
                                    </div>
                                </div>
                                <div class="col-12 row justify-content-center">
                                    <div class="stat-tile">
                                        <h2 class="text-center stat_count" id="customer_count" >0</h2>
                                        <p class="text-center stat_lable" id="">TOTAL NEW CUSTOMERS</p>
                                    </div>
                                    <div class="stat-tile">
                                        <h2 class="text-center stat_count" id="revisits_count" >0</h2>
                                        <p class="text-center stat_lable" id="">TOTAL RECORDED REVISITS</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane p-20" id="tab-pane-5" role="tabpanel">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Promo Name</th>
                            <th>Store Name(s)</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody id="search_result"></tbody>
                    </table>
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQOQYd6y3PeucI2ajI2hXzcPTXVwlGfgs&libraries=places"></script>
    <script>
        var map;
        var marker;
        var infowindow = new google.maps.InfoWindow();
        var Markers = new Array();
        var Stores = new Array();

        $(document).ready(function(){
            // set_stat_tile();
            load_map(1);
            get_active_stores();

            $('#crt_qr_1').show();
            $('#print_code_1').hide();
            $('#refresh_qr_1').hide();
        });

        function create_tab() {
            load_map(1);
            get_active_stores();
            // set_stat_tile();

            $('#crt_qr_1').show();
            $('#print_code_1').hide();
            $('#refresh_qr_1').hide();
        }

        function open_tab() {
            load_map(2);
            get_active_stores();
            // set_stat_tile();

            $('#crt_qr_2').hide();
            $('#print_code_2').hide();
            $('#refresh_qr_2').hide();
        }

        function cloased_tab(){
            load_map(3);
            get_active_stores();
//            set_stat_tile();

            $('#crt_qr_3').show();
            $('#print_code_3').hide();
            $('#refresh_qr_3').hide();
        }

        function finished_tab(){
            set_stat_tile();
            $('#crt_qr_4').show();
            $('#print_code_4').hide();
            $('#refresh_qr_4').hide();
        }

        function mapInit(id){
            var latlng = new google.maps.LatLng(37.8271784,-122.2913078);
            map = new google.maps.Map(document.getElementById('map'+id), {
                center: latlng,
                zoom: 13
            });
            marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29)
            });

            Markers.push(marker);

            get_address();
            //drag_marker();
        }

        function get_address(){
            var input = document.getElementById('store_address_1');
            //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            var geocoder = new google.maps.Geocoder();
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            var infowindow = new google.maps.InfoWindow();

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    /// map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                map.setZoom(20);

                var address = place.address_components;

                var street_num = "";
                var street_name = "";
                var city = "";
                var state = "";
                var postal_code = "";
                var country = "";
                var country_short = "";
                var latitude = marker.getPosition().lat();
                var longitude = marker.getPosition().lng();
                var full_address = place.formatted_address;

                for(var k = 0; k < address.length; k++){
                    if(address[k]['types'].includes('street_number')){
                        street_num = address[k]['long_name'];
                    }
                    if(address[k]['types'].includes('route')){
                        street_name = address[k]['long_name'];
                    }
                    if((address[k]['types'].includes('sublocality')) || (address[k]['types'].includes('sublocality_level_1')) || (address[k]['types'].includes('administrative_area_level_2'))){
                        city = address[k]['long_name'];
                    }
                    if(address[k]['types'].includes('administrative_area_level_1')){
                        state = address[k]['long_name'];
                    }
                    if(address[k]['types'].includes('postal_code')){
                        postal_code = address[k]['long_name'];
                    }
                    if(address[k]['types'].includes('country')){
                        country = address[k]['long_name'];
                        country_short = address[k]['short_name'];

                    }
                }


                bind_data_location(store_id,latitude,longitude,1);
                //bind_data_address(1,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address,country_short);

                infowindow.setContent(place.formatted_address);
                infowindow.open(map, marker);

            });
        }

        function drag_marker(){
            var geocoder = new google.maps.Geocoder();
            google.maps.event.addListener(marker, 'dragend', function() {
                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        console.log(results);
                        if (results[0]) {

                            var address = results[0]['address_components'];

                            var street_num = "";
                            var street_name = "";
                            var city = "";
                            var state = "";
                            var postal_code = "";
                            var country = "";
                            var country_short = "";
                            var latitude = marker.getPosition().lat();
                            var longitude = marker.getPosition().lng();
                            var full_address = results[0].formatted_address;

                            for(var k = 0; k < address.length; k++){
                                if(address[k]['types'].includes('street_number')){
                                    street_num = address[k]['long_name'];
                                }
                                if(address[k]['types'].includes('route')){
                                    street_name = address[k]['long_name'];
                                }
                                if((address[k]['types'].includes('sublocality')) || (address[k]['types'].includes('sublocality_level_1')) || (address[k]['types'].includes('administrative_area_level_2'))){
                                    city = address[k]['long_name'];
                                }
                                if(address[k]['types'].includes('administrative_area_level_1')){
                                    state = address[k]['long_name'];
                                }
                                if(address[k]['types'].includes('postal_code')){
                                    postal_code = address[k]['long_name'];
                                }
                                if(address[k]['types'].includes('country')){
                                    country = address[k]['long_name'];
                                    country_short = address[k]['short_name'];
                                }
                            }

//                            bind_data_location(store_id,latitude,longitude,1);
                            // bind_data_address(1,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address, country_short);
                            //alert(street_num + "-" +street_name);
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);

                        }else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });

            });
        }

        function load_map(id){
            Marker = [];
            google.maps.event.addDomListener(window, 'load', mapInit(id));
        }

        $(".left_scroll").perfectScrollbar();

        $(".radio").change(function() {
            $(".radio").prop('checked', false);
            $(this).prop('checked', true);
        });

        function showHideRepeat(id,index){
            if(id == 'Days'){
                ForDays(index);
            } else if(id == 'Date'){
                ForDate(index);
            } else {
                hideDateDays(index);
            }
        }

        function ForDate(id){
            $('.fordate_'+id).css("display","block").attr("required","required").css('margin-bottom',15);
            $('.fordays_'+id).css("display","none");
        }

        function ForDays(id){
            $('.fordays_'+id).css("display","block");
            $('.fordate_'+id).css("display","none").removeAttr("required");
        }

        function hideDateDays(id){
            $('.fordays_'+id).css("display","none");
            $('.fordate_'+id).css("display","none").removeAttr("required");
        }

        function get_store_details(id) {


            var store_lat = $('#store_lat_'+id).val();
            var store_lng = $('#store_lng_'+id).val();
            var is_outside = $('#store_loc_'+id).val();
            //alert(is_outside);

            $('#ar_inside').prop('checked', true);


            for(var i = 0; i < Markers.length; i++){
                if(Markers[i][0] == id){
                    var tmpMark = Markers[i][2];
                    var tmpCont = Markers[i][1];
                    var infowindow = new google.maps.InfoWindow();
                    infowindow.setContent(tmpCont);
                    infowindow.open(map, tmpMark);
                }
            }

            var temp = new Array();
            temp.push(id,store_lat,store_lng,is_outside);
            Stores.push(temp);

            //alert(Stores);
        }

        function get_active_stores(){
            marker.setMap(null);
            Markers = [];

            $.get("{{ url('user/get_active_store') }}",function(data){

                for(var x = 0; x < data.length; x++){
                    var lat = data[x]['latitude'];
                    var lng = data[x]['longitude'];
                    var store_id = data[x]['place_id'];
                    var store_name = data[x]['contact_name'];

                    var center = new google.maps.LatLng(lat,lng);

                    marker = new google.maps.Marker({
                        position: center,
                        map: map,
                        draggable: true,
                        anchorPoint: new google.maps.Point(0, -29)

                    });


                    var temp = new Array();
                    temp.push(store_id, store_name, marker);

                    Markers.push(temp);
                    //console.log(Markers);

                    google.maps.event.addListener(marker, 'click', (function(marker, x) {

                        return function() {
                            var infowindow = new google.maps.InfoWindow();
                            infowindow.setContent(data[x]['contact_name']);
                            infowindow.open(map, marker);
                            //get_store_details(data[x]['place_id']);
                            $('#store'+data[x]['place_id']).prop('checked', true);
                        }

                    })(marker, x));

                    google.maps.event.addListener(marker, 'dragend', (function(marker, x) {

                        return function() {
                            var geocoder = new google.maps.Geocoder();
                            geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                                if (status === google.maps.GeocoderStatus.OK) {
                                    console.log(results[0]);
                                    if (results[0]) {

                                        var address = results[0]['address_components'];

                                        var latitude = marker.getPosition().lat();
                                        var longitude = marker.getPosition().lng();
                                        var full_address = results[0].formatted_address;

                                        bind_data_location(data[x]['place_id'],latitude,longitude,1);
                                        var infowindow = new google.maps.InfoWindow();
                                        infowindow.setContent(results[0].formatted_address);
                                        infowindow.open(map, marker);

                                    }else {
                                        window.alert('No results found');
                                    }
                                } else {
                                    window.alert('Geocoder failed due to: ' + status);
                                }
                            });
                        }

                    })(marker, x));

                    map.setCenter(center);
                    map.setZoom(16);

                    //drag_marker(2);

                }

            });
        }

        function bind_data_location(store_id,latitude,longitude,is_outside){
            $('#store_lat_'+store_id).val(latitude);
            $('#store_lng_'+store_id).val(longitude);
            $('#store_loc_'+store_id).val(is_outside);
            // alert( $('#store_loc_'+store_id).val());
            //alert(store_id);
        }

        function get_promo_details(promo_id,id){
            $.get("{{ url('user/get_promo_details') }}/"+parseInt(promo_id),function(data){
                // console.log(data);

                if(data['status'] == 1){
                    var promo = data['details'][0];

                    $('#formid_'+id).val('');
                    $('#promo_name_'+id).val('');
                    $('#promo_description_'+id).val('');
                    $('#promo_start_'+id).val('');
                    $('#qr_code_prev_'+id).attr('src',"{{url('resources/assets/custom/images/no-image.png')}}");

//                    if(id <= 2){
//                        $('#promo_qr_code_'+id).val('');
//                        $('#promo_qr_image_'+id).val('');
//                    }

                    // $('#advance_warning_'+id).prop('checked', false);

                    $("[name='repeat_promo']").prop('checked', false);


                    // bind values to form
                    $('#formid_'+id).val(promo['promo_id']);
                    $('#promo_name_'+id).val(promo['promo_name']);
                    // $('#promo_description_'+id).val(promo['main_clue']);
                    $('#promo_start_'+id).val(promo['start_at_local']);

                    $('#promo_length_'+id).val(promo['promo_length']);

                    {{--$('#qr_code_prev_'+id).attr('src',"{{url('resources/assets/qr_codes')}}/"+promo['qr_image']);--}}

                    // show buttons
//                    $('#print_code_' + id).show();
//                    $('#refresh_qr_' + id).show();

//                    if(id <= 2){
//                        $('#promo_qr_code_'+id).val(promo['qr_code']);
//                        $('#promo_qr_image_'+id).val(promo['qr_image']);
//                    }


                    var promo_repeate = promo['promo_repeat'];
                    var promo_repeate_val = promo['promo_repeat_values'];

                    $('#'+promo_repeate+'_'+id).prop('checked', true);

                    if(promo_repeate == "Days"){
                        ForDays(id);

                        if(id == 2){
                            for(var x = 0; x < promo_repeate_val.length; x++ ){
                                $('#a'+promo_repeate_val[x]).prop('checked', true);
                            }
                        } else if(id == 3){
                            for(var x = 0; x < promo_repeate_val.length; x++ ){
                                $('#p'+promo_repeate_val[x]).prop('checked', true);
                            }
                        }
                        else if(id == 4){
                            for(var x = 0; x < promo_repeate_val.length; x++ ){
                                $('#f'+promo_repeate_val[x]).prop('checked', true);
                            }
                        }


                    } else if(promo_repeate == "Date"){
                        ForDate(id);
                        var date = new Date(promo_repeate_val);
                        var day = ("0" + date.getDate()).slice(-2);
                        var month = ("0" + (date.getMonth() + 1)).slice(-2);

                        var promo_date = date.getFullYear()+"-"+(month)+"-"+(day) ;


                        $('#promo_date_'+id).val(promo_date);
                    } else {
                        hideDateDays(id);
                    }

                    var advance_warning = promo['advance_warning'];

                    if(advance_warning == '1'){
                        if($('#advance_warning_'+id).is(":checked")){
                            
                        } else {
                            $('#advance_warning_'+id).parent().find(".switchery").trigger("click");
                        }
                    } else {
                        if($('#advance_warning_'+id).is(":checked")){
                            $('#advance_warning_'+id).parent().find(".switchery").trigger("click");
                        }
                    }


                    var stores = promo['place_id'];
                    //alert(stores);
                    for(var j = 0; j < stores.length; j++){

                        for(var i = 0; i < Markers.length; i++){
                            if(Markers[i][0] == stores[j]){
                                var tmpMark = Markers[i][2];
                                var tmpCont = Markers[i][1];
                                var infowindow = new google.maps.InfoWindow();
                                infowindow.setContent(tmpCont);
                                infowindow.open(map, tmpMark);
                            }
                        }

                    }

                    input_validate_custom(id);

                } else {

                }


            });

            if(id == 4) {
                //alert("rerere");
                $.get("{{ url('user/get_final_promo_stats') }}/"+parseInt(promo_id),function(data){
                    // alert('success');
                    //  console.log(data);
                    $('#day_count').html(data['days_running'])
                    $('#coupon_count').html(data['coupons_issued'])
                    $('#customer_count').html(data['new_customers'])
                    $('#revisits_count').html(data['revisits'])
                });
            }
        }

        function generate_qr_code(id) {

            $('#crt_qr_'+id).hide();

            $.get("{{ url('user/generate_new_qr') }}",function(data){

                $('#qr_code_prev_'+id).attr('src', "{{url('resources/assets/qr_codes')}}/"+data['qr_image']);
                // $('#print_code_'+id).attr('href', "{{url('resources/assets/qr_codes')}}/"+data['qr_image']);
                $('#promo_qr_image_'+id).val(data['qr_image']);
                $('#promo_qr_code_'+id).val(data['qr_content']);

            });

            $('#print_code_'+id).show();
            $('#refresh_qr_'+id).show();
        }

        function refresh_qr(id) {
            // get image qr code name
            var old_qr = $('#promo_qr_image_'+id).val();
            $('#qr_code_prev_'+id).attr('src', "{{url('resources/assets/custom/images/no-image.png')}}");
            $.get("{{ url('user/delete_old_qr') }}/"+old_qr,function(data){});

            generate_qr_code(id);
        }

        $('#search_promo').on('input', function(){
            var input = $('#search_promo').val();

            if(input.length > 0) {
                $.get("{{ url('user/search_promos') }}/"+input,function(data){
                    $('#search_result').html('');


                    for(var y = 0; y < data.length; y++){
                        var stores = data[y]['store_name'];
                        var store_list = '<ul>';
                        for(var x = 0; x < stores.length; x++){
                            store_list += '<li>'+stores[x]+"</li>";
                        }

                        store_list += '</ul>';

                        var row = '<tr><td>'+data[y]['promo_name']+'</td><td>'+store_list+'</td><td>'+data[y]['created_at']+'</td></tr>';

                        $('#search_result').append(row);
                    }



                    console.log(data);
                });
            }


        });

        function view_qr_code(id) {
            var src = $('#qr_code_prev_' + id).attr('src');
            window.open(src);
            // alert(src);
        }



    </script>

    <script>

        function input_validate_custom(id){
            var err_1 = "This field is required";

            if(id == 1) {
                var stores = 0;
                if ($('input[name="store_ids_1[]"]').is(':checked')) {
                    stores = 1;
                }

                if(stores == 1) {
                    $('#promo_store_error_' + id).html('');
                } else {
                    $('#promo_store_error_' + id).html(err_1);
                }
            } else if(id ==2) {
                var stores = 0;
                if ($('input[name="promos[]"]').is(':checked')) {
                    stores = 1;
                }

                if(stores == 1) {
                    $('#promo_store_error_' + id).html('');
                } else {
                    $('#promo_store_error_' + id).html(err_1);
                }
            }


            var promo_name = $('#promo_name_' + id).val();
            if(promo_name.length > 0) {
                $('#promo_name_error_' + id).html('');
            } else {
                $('#promo_name_error_' + id).html(err_1);
            }

            var promo_start = $('#promo_start_' + id).val();
            if(promo_start.length > 0) {
                $('#promo_start_error_' + id).html('');
            } else {
                $('#promo_start_error_' + id).html(err_1);
            }

            // var promo_desc = $('#promo_description_' + id).val();
            // if(promo_desc.length > 0) {
            //     $('#promo_desc_error_' + id).html('');
            // } else {
            //     $('#promo_desc_error_' + id).html(err_1);
            // }

            var promo_repeat = 0;
            if(id == 1) {
                if ($('input[name="repeat_promo_1"]').is(':checked')) {
                    promo_repeat = 1;
                }

                if(promo_repeat == 1) {
                    $('#promo_repeat_error_' + id).html('');
                } else {
                    $('#promo_repeat_error_' + id).html(err_1);
                }
            } else if(id ==2) {
                if ($('input[name="repeat_promo_2"]').is(':checked')) {
                    promo_repeat = 1;
                }

                if(promo_repeat == 1) {
                    $('#promo_repeat_error_' + id).html('');
                } else {
                    $('#promo_repeat_error_' + id).html(err_1);
                }
            }


            $('#Date_' + id).on('click', function (){
                var date = $('#promo_date_' + id).val();
                if(date.length > 0) {
                    $('#promo_repeat_date_error_' + id).html('');
                } else {
                    $('#promo_repeat_date_error_' + id).html(err_1);
                }

            });

            var date_checked = 0;
            var date_set = 0;
            if ($('#Date_' + id).is(':checked')) {
                date_checked = 1;

                var date_t = $('#promo_date_' + id).val();
                if(date_t.length > 0) {
                    date_set = 1;
                    $('#promo_repeat_date_error_' + id).html('');
                } else {
                    $('#promo_repeat_date_error_' + id).html(err_1);
                }
            }

            if(id == 1) {

                $('#Days_' + id).on('click', function (){
                    var days = 0;
                    if ($('input[name="days_1[]"]').is(':checked')) {
                        days = 1;
                    }

                    if(days == 1) {
                        $('#promo_repeat_days_error_' + id).html('');
                    } else {
                        $('#promo_repeat_days_error_' + id).html(err_1);
                    }

                });

                var days_checked = 0;
                var days_set = 0;
                if ($('#Days_' + id).is(':checked')) {
                    days_checked = 1;

                    var days_t = 0;
                    if ($('input[name="days_1[]"]').is(':checked')) {
                        days_t = 1;
                        days_set = 1;
                    }

                    if(days_t == 1) {
                        $('#promo_repeat_days_error_' + id).html('');
                    } else {
                        $('#promo_repeat_days_error_' + id).html(err_1);
                    }
                }
            }
            else if(id == 2) {

                $('#Days_' + id).on('click', function (){
                    var days = 0;
                    if ($('input[name="days_2[]"]').is(':checked')) {
                        days = 1;
                    }


                    if(days == 1) {
                        $('#promo_repeat_days_error_' + id).html('');
                    } else {
                        $('#promo_repeat_days_error_' + id).html(err_1);
                    }

                });


                var days_checked = 0;
                var days_set = 0;
                if ($('#Days_' + id).is(':checked')) {
                    days_checked = 1;

                    var days_t = 0;
                    if ($('input[name="days_2[]"]').is(':checked')) {
                        days_t = 1;
                        days_set = 1;
                    }

                    if(days_t == 1) {
                        $('#promo_repeat_days_error_' + id).html('');
                    } else {
                        $('#promo_repeat_days_error_' + id).html(err_1);
                    }
                }
            }






            if( (stores == 1) && (promo_name.length > 0) && (promo_start.length > 0) && (promo_start.length > 0) && (promo_repeat == 1) ) {

                if(date_checked == 1) {

                    if(date_set == 1) {
                        return 1;
                    } else {
                        return 0;
                    }

                } else if(days_checked == 1){
                    if(days_set == 1) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return 1;
                }

            } else {
                return 0;
            }



        }

        function validate_form(id){
            var valid = input_validate_custom(id);

            if(valid == 1) {
                $('#promo_form_' + id).submit();
            } else {
                alert("Please Fill the missing data..")
            }
        }

        function error_hide(field_id) {
            $('#'+ field_id).html('');
        }
    </script>
@endsection
