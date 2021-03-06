@extends('layouts.user')

@section('content')
    <div class="col-md-12">

        <ul>
            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <ul class="nav nav-tabs customtab" role="tablist">

                @if($has_stores == 0)
                    @if($is_member == 0)
                    <li class="nav-item" onclick="generate_qr_code(1);">
                        <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab" onclick="create_tab();">
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">CREATE STORE</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" onclick="open_tab();">
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">ACTIVE STORES</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab" onclick="cloased_tab();">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">INACTIVE STORES</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-pane-2" role="tab" onclick="open_tab();">
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">ACTIVE STORES</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab" onclick="cloased_tab();">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">INACTIVE STORES</span>
                        </a>
                    </li>
                    @if($is_member == 0)
                    <li class="nav-item" onclick="generate_qr_code(1);">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-1" role="tab" onclick="create_tab();">
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">CREATE STORE</span>
                        </a>
                    </li>
                    @endif
                @endif
                <li class="nav-item">
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-5" role="tab">
                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                        <span class="hidden-xs-down">
                        <table>
                            <tr>
                                <td>SEARCH</td>
                                <td><input type="text" class="custom-input" id="search_store" ></td>
                                <td><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                            </tr>
                        </table>
                    </span>
                    </a>
                </li>

            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                @if($is_member == 0)
                @if($has_stores == 0)
                <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">
                @else
                <div class="tab-pane p-20" id="tab-pane-1" role="tabpanel">
                @endif

                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/stores/create_store') }}" id="store_form_1">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">

                                        <div class="form-group">
                                            <label class="control-label">Store Name</label>
                                            <input type="text" id="store_name_1" name="store_name" class="form-control" placeholder="Enter Name" required oninput="error_hide('store_name_error_1');" >
                                            <h6 class="form-control-feedback text-danger" id="store_name_error_1"> </h6>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Store Address</label>
                                            <input type="text" id="store_address_1" name="store_address" class="form-control" placeholder="Start Typing Full Address..." required oninput="error_hide('store_address_error_1');">
                                            <h6 class="form-control-feedback text-danger" id="store_address_error_1"> </h6>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Cant Find Address?</label>
                                            <label class="btn-container"> Input Manually
                                                <input type="checkbox" name="manually" onchange="ChangeAutofill(1)" value="0" id="check_add_manually_1" onclick="error_hide('input_manual_error_1');">
                                                <span class="checkmark"></span>
                                            </label>
                                            <h6 class="form-control-feedback text-danger" id="input_manual_error_1"> </h6>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group" id="manual_add_1" style="display: none;">
                                            <label class="control-label col-md-12 col-lg-12">Enter Full Address</label>
                                            <input type="text" id="street_num_1" name="street_num" class="form-control col-sm-12 col-md-3 col-lg-3" placeholder="Number" >
                                            <input type="text" id="street_name_1" name="street_name" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Street Name" required>
                                            <input type="text" id="city_1" name="city" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Town / City" required>
                                            <input type="text" id="state_1" name="state" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="State / County" required>
                                            <input type="text" id="postal_code_1" name="postal_code" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Zip / Postal Code" required>
                                            <input type="text" id="country_1" name="country" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Country" required>

                                            <input type="hidden" id="store_lat_1" name="store_lat" required>
                                            <input type="hidden" id="store_lng_1" name="store_lng" required>
                                            <input type="hidden" id="country_short_1" name="country_short" required>
                                        </div>
                                        <h6 class="form-control-feedback text-danger" id="street_error_1"> </h6>
                                        <h6 class="form-control-feedback text-danger" id="town_error_1"> </h6>
                                        <h6 class="form-control-feedback text-danger" id="state_error_1"> </h6>
                                        <h6 class="form-control-feedback text-danger" id="zip_code_error_1"> </h6>
                                        <h6 class="form-control-feedback text-danger" id="country_error_1"> </h6>
                                        <h6 class="form-control-feedback text-danger" id="store_lat_error_1"> </h6>
                                        <h6 class="form-control-feedback text-danger" id="store_lng_error_1"> </h6>
                                        <h6 class="form-control-feedback text-danger" id="country_short_error_1"> </h6>
                                    </div>

                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label class="control-label">Coupon Code</label><br>
                                        <img src="" style="width:70%;" id="qr_code_prev_1">
                                        <input type="hidden" name="promo_qr_code" id="promo_qr_code_1" >
                                        <input type="hidden" name="promo_qr_image" id="promo_qr_image_1" >

                                        <h6 class="form-control-feedback text-danger" id="qr_code_error_1"> </h6>
                                        <div class="row">
                                            <button type="button" class="custom_btn crt_qr_code col-md-8" style="margin:2px;" onclick="generate_qr_code(1);error_hide('qr_code_error_1');" id="crt_qr_1"></button>

                                            <button type="button" class="custom_btn view_qr_code col-md-8" style="margin:2px;" onclick="view_qr_code(1);" id="print_code_1"></button>

                                            <button type="button" class="custom_btn refresh_qr_code col-md-8" style="margin:2px;" onclick="refresh_qr(1);error_hide('qr_code_error_1');" id="refresh_qr_1"></button>
                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select A Business Type</label>

                                            @if(sizeof($business_types) > 0)
                                                @foreach($business_types as $type)
                                                    <label class="btn-container">{{ $type->business }}
                                                        <input type="radio" name="radio_1" onclick="get_categories({{$type->id}}, 1);error_hide('business_type_error_1');">
                                                        <span class="checkRadio"></span>
                                                    </label>
                                                @endforeach
                                            @endif
                                            <h6 class="form-control-feedback text-danger" id="business_type_error_1"> </h6>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Relevant Category</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 category_container left_scroll" >
                                                <table class="category_table" id="category_table_1">

                                                </table>

                                            </div>
                                            <h6 class="form-control-feedback text-danger" id="category_error_1"> </h6>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="col-md-8 custom_btn save_c" onclick="validate_crt(1)"></button>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <h1 class="text-center" style="font-size: 26px;"> Check Location Is Correct Before Continuing</h1>
                                <div id="map1" style="height: 400px;"></div>
                            </div>

                        </div>
                    </form>
                </div>

                @if($has_stores == 0)
                <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                @else
                <div class="tab-pane active p-20" id="tab-pane-2" role="tabpanel">
                @endif

                @else
                <div class="tab-pane active p-20" id="tab-pane-2" role="tabpanel">
                @endif

                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/stores/update_store') }}" id="store_form_2">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">

                                        <div class="form-group">
                                            <label class="control-label col-md-12 col-lg-12">Select Store</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 store_container left_scroll">
                                                <table class="category_table">
                                                    @foreach($openStores as $store)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{$store->contact_name}}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox" value="{{ $store->place_id }}" id="store2{{ $store->place_id }}" name="store[]" onclick="get_store_details({{ $store->place_id }}, 2);" class="radio">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </table>
                                            </div>
                                            <h6 class="form-control-feedback text-danger" id="store_name_error_2"> </h6>

                                            <div class="form-group">
                                                <br>
                                                <label class="control-label">Store Name</label>
                                                <input type="text" id="store_name_2" name="store_name" class="form-control" placeholder="Enter Name" required oninput="error_hide('store_name_error_1');" >
                                                <h6 class="form-control-feedback text-danger" id="store_name_error_1"> </h6>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">

                                        <div class="form-group">
                                            <label class="control-label">Store Address</label>
                                            <input type="text" id="store_address_2" name="store_address" class="form-control" placeholder="Start Typing Full Address..."  oninput="error_hide('store_address_error_2');">
                                            <h6 class="form-control-feedback text-danger" id="store_address_error_2"> </h6>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-12 col-lg-12">Enter Full Address</label>
                                            <input type="text" id="street_num_2" name="street_num" class="form-control col-sm-12 col-md-3 col-lg-3" placeholder="Number" >
                                            <input type="text" id="street_name_2" name="street_name" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Street Name" required>
                                            <input type="text" id="city_2" name="city" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Town / City" required>
                                            <input type="text" id="state_2" name="state" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="State / County" required>
                                            <input type="text" id="postal_code_2" name="postal_code" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Zip / Postal Code" required>
                                            <input type="text" id="country_2" name="country" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Country" required>

                                            <input type="hidden" id="store_lat_2" name="store_lat" required>
                                            <input type="hidden" id="store_lng_2" name="store_lng" required>
                                            <input type="hidden" id="country_short_2" name="country_short" required>
                                            <input type="hidden" id="formid_2" name="formid" required>
                                            {{--<input type="hidden" id="store_name_2" name="store_name" required>--}}
                                            <input type="hidden" id="store_image_hidden_2" name="store_image_hidden" required>
                                            <input type="hidden" id="store_ar_hidden_2" name="store_ar_hidden" required>
                                            <input type="hidden" id="store_marker_hidden_2" name="store_marker_hidden" required>


                                            <h6 class="form-control-feedback text-danger" id="street_error_2"> </h6>
                                            <h6 class="form-control-feedback text-danger" id="town_error_2"> </h6>
                                            <h6 class="form-control-feedback text-danger" id="state_error_2"> </h6>
                                            <h6 class="form-control-feedback text-danger" id="zip_code_error_2"> </h6>
                                            <h6 class="form-control-feedback text-danger" id="country_error_2"> </h6>
                                            <h6 class="form-control-feedback text-danger" id="store_lat_error_2"> </h6>
                                            <h6 class="form-control-feedback text-danger" id="store_lng_error_2"> </h6>
                                            <h6 class="form-control-feedback text-danger" id="country_short_error_2"> </h6>
                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <div class="row">

                                </div>
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label class="control-label">Coupon Code</label><br>
                                        <img src="" style="width:70%;" id="qr_code_prev_2">
                                        <input type="hidden" name="promo_qr_code" id="promo_qr_code_2" >
                                        <input type="hidden" name="promo_qr_image" id="promo_qr_image_2" >

                                        <h6 class="form-control-feedback text-danger" id="qr_code_error_2"> </h6>
                                        <div class="row justify-content-center">
                                            <button type="button" class="custom_btn crt_qr_code col-md-8" style="margin:2px;" onclick="generate_qr_code(2);error_hide('qr_code_error_2');" id="crt_qr_2"></button>

                                            <button type="button" class="custom_btn view_qr_code col-md-8" style="margin:2px;" onclick="view_qr_code(2);" id="print_code_2"></button>

                                            <button type="button" class="custom_btn refresh_qr_code col-md-8" style="margin:2px;" onclick="refresh_qr(2);error_hide('qr_code_error_2');" id="refresh_qr_2"></button>

                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select A Business Type</label>
                                            @if(sizeof($business_types) > 0)
                                                @foreach($business_types as $type)
                                                    <label class="btn-container">{{ $type->business }}
                                                        <input type="radio" name="radio_2" onclick="get_categories({{$type->id}}, 2);error_hide('business_type_error_2');" id="business_type_2_{{$type->id}}" >
                                                        <span class="checkRadio"></span>
                                                    </label>
                                                @endforeach
                                            @endif
                                            <h6 class="form-control-feedback text-danger" id="business_type_error_2"> </h6>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Relevant Category</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 category_container left_scroll" >
                                                <table class="category_table" id="category_table_2">

                                                </table>
                                            </div>
                                            <h6 class="form-control-feedback text-danger" id="category_error_2"> </h6>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" name="update_store" class="col-md-8 custom_btn up_store" onclick="validate_crt(2);"></button>
                                            <button type="submit" onclick="beforeSubmit();" name="close_store" class="col-md-8 custom_btn cls_store"></button>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <h1 class="text-center" style="font-size: 26px;"> Check Location Is Correct Before Continuing</h1>
                                <div id="map2" style="height: 400px;"></div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/stores/delete_store') }}">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">

                                        <div class="form-group">
                                            <label class="control-label col-md-12 col-lg-12">Select Store</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 store_container left_scroll">
                                                <table class="category_table">
                                                    @foreach($closedStores as $store)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{$store->contact_name}}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox" value="{{ $store->place_id }}" id="store3{{ $store->place_id }}" name="store[]" onclick="get_store_details({{ $store->place_id }}, 3);" class="radio">
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
                                            <label class="control-label col-md-12 col-lg-12">Enter Full Address</label>
                                            <input type="text" id="street_num_3" name="street_num" class="form-control col-sm-12 col-md-3 col-lg-3" placeholder="Number" >
                                            <input type="text" id="street_name_3" name="street_name" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Street Name" >
                                            <input type="text" id="city_3" name="city" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Town / City" >
                                            <input type="text" id="state_3" name="state" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="State / County" >
                                            <input type="text" id="postal_code_3" name="postal_code" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Zip / Postal Code" requied>
                                            <input type="text" id="country_3" name="country" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Country" >

                                            <input type="hidden" id="store_lat_3" name="store_lat" >
                                            <input type="hidden" id="store_lng_3" name="store_lng" >
                                            <input type="hidden" id="country_short_3" name="country_short" >
                                            <input type="hidden" id="formid_3" name="formid" required>
                                            <input type="hidden" id="store_name_3" name="store_name" >
                                            <input type="hidden" id="store_image_hidden_3" name="store_image_hidden" >
                                            <input type="hidden" id="store_ar_hidden_3" name="store_ar_hidden" >
                                        </div>
                                    </div>

                                </div>


                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select A Business Type</label>
                                            @if(sizeof($business_types) > 0)
                                                @foreach($business_types as $type)
                                                    <label class="btn-container">{{ $type->business }}
                                                        <input type="radio" name="radio" onclick="get_categories({{$type->id}}, 3)" id="business_type_3_{{$type->id}}" >
                                                        <span class="checkRadio"></span>
                                                    </label>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Relevant Category</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 category_container left_scroll">
                                                <table class="category_table" id="category_table_3">

                                                </table>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <button type="submit" onclick="beforeSubmit();" name="reopen_store" class="col-md-8 custom_btn reop_store"></button>
                                            <button type="submit" onclick="beforeSubmit();" name="delete_store" class="col-md-8 custom_btn del_store"></button>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-5">
                                <h1 class="text-center" style="font-size: 26px;"> Check Location Is Correct Before Continuing</h1>
                                <div id="map3" style="height: 400px;"></div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="tab-pane p-20" id="tab-pane-5" role="tabpanel">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Store Name</th>
                            <th>Company Name</th>
                            <th>Address</th>
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
        var has_stores = {{ $has_stores }};
        var map;
        var marker;
        var infowindow = new google.maps.InfoWindow();
        var Markers = new Array();

        $(document).ready(function(){

            if(has_stores == 1) {
                open_tab();
            } else {
                create_tab();
            }


            $('.dropify').dropify();

        });

        function create_tab() {
            load_map(1);
            $('#crt_qr_1').hide();
            $('#print_code_1').hide();
            $('#refresh_qr_1').hide();
        }

        function open_tab() {
            load_map(2);
            get_active_stores();
            $('#crt_qr_2').hide();
            $('#print_code_2').hide();
            $('#refresh_qr_2').hide();
        }

        function cloased_tab(){
            load_map(3);
            get_closed_stores();
        }

        function mapInit(id){
            var latlng = new google.maps.LatLng(37.794357,-122.5607304);
            map = new google.maps.Map(document.getElementById('map'+id), {
                center: latlng,
                zoom: 10
            });
            marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29)
            });

            Markers.push(marker);

            get_address();
            get_address2();
            drag_marker();
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
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

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

                // console.log(full_address);

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


                bind_data_address(1,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address,country_short);

                infowindow.setContent(place.formatted_address);
                infowindow.open(map, marker);

            });
        }

        function get_address2(){
            var input = document.getElementById('store_address_2');
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
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

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

                //console.log(full_address);

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


                bind_data_address(2,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address,country_short);

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


                            bind_data_address(1,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address, country_short);
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

        function create_marker(lat, lng, place_id, id, info, zoom) {
            var center = new google.maps.LatLng(lat,lng);

            marker = new google.maps.Marker({
                position: center,
                map: map,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29)

            });

            infowindow = new google.maps.InfoWindow({
                content: info
            });

            infowindow.open(map, marker);

            Markers.push(marker);
            //console.log(Markers);

            google.maps.event.addListener(marker, 'click', (function(marker, x) {

                return function() {
                    get_store_details(place_id, id);
                }

            })(marker));

            google.maps.event.addListener(marker, 'dragend', (function(marker,x) {

                return function() {
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            console.log(results[0]);
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


                                bind_data_address(2,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address,country_short);

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

            })(marker));

            map.setCenter(center);
            map.setZoom(zoom);
        }

        function setMapOnAll(map) {
            for (var i = 0; i < Markers.length; i++) {
                Markers[i].setMap(map);
            }
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

        function bind_data_address(id,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address, country_short){
            $('#store_address_'+id).val('');
            $('#street_num_'+id).val('');
            $('#street_name_'+id).val('');
            $('#city_'+id).val('');
            $('#state_'+id).val('');
            $('#postal_code_'+id).val('');
            $('#country_'+id).val('');
            $('#store_lat_'+id).val('');
            $('#store_lng_'+id).val('');
            $('#country_short_'+id).val('');


            $('#store_address_'+id).val(full_address);
            $('#street_num_'+id).val(street_num);
            $('#street_name_'+id).val(street_name);
            $('#city_'+id).val(city);
            $('#state_'+id).val(state);
            $('#postal_code_'+id).val(postal_code);
            $('#country_'+id).val(country);
            $('#store_lat_'+id).val(latitude);
            $('#store_lng_'+id).val(longitude);
            $('#country_short_'+id).val(country_short);

        }

        function get_store_details(store_id, id){

            clearMarkers();

            if($('#store'+id+store_id).prop('checked', false)){
                $('.radio').prop('checked', false);
                $('#store'+id+store_id).prop('checked', true);
            }

            $.get("{{ url('user/get_store_details') }}/"+parseInt(store_id),function(data){

                if(data['status'] == 1){
                    var store = data['details'];
                    var categories = data['categories'];
                    var business = data['business'];

                    // empty form
                    $('#formid_'+id).val('');
                    $('#store_name_'+id).val('');
                    $('#store_promo_'+id).val('');
                    $('#street_num_'+id).val('');
                    $('#street_name_'+id).val('');
                    $('#city_'+id).val('');
                    $('#state_'+id).val('');
                    $('#postal_code_'+id).val('');
                    $('#country_'+id).val('');
                    $('#store_lat_'+id).val('');
                    $('#store_lng_'+id).val('');
                    $('#country_short_'+id).val('');
                    $('#store_description_'+id).val('');
                    if(id == 2) {
                        $('#store_marker_hidden_2').val('');
                    }

                    $('#qr_code_prev_'+id).attr('src', "{{url('resources/assets/custom/images/no-image.png')}}");
                    $('#promo_qr_code_'+id).val('');
                    $('#promo_qr_image_'+id).val('');

                    $('#category_table_' + id).html('');

                    // uncheck all checkbox
                    $('.cat_check').prop('checked',false);

                    $("input:radio[name='radio']").each(function(i) {
                        this.checked = false;
                    });

                    var st_lat = store[0]['latitude'];
                    var st_lng = store[0]['longitude'];
                    var st_info = store[0]['contact_name'];

                    create_marker(st_lat, st_lng, store_id, id, st_info, 14);

                    //console.log(store);
                    $('#formid_'+id).val(store[0]['place_id']);
                    $('#store_name_'+id).val(store[0]['contact_name']);
                    $('#store_promo_'+id).val(store[0]['store_promo']);
                    $('#street_num_'+id).val(store[0]['street_number']);
                    $('#street_name_'+id).val(store[0]['street_address']);
                    $('#city_'+id).val(store[0]['city']);
                    $('#state_'+id).val(store[0]['state']);
                    $('#postal_code_'+id).val(store[0]['postal_code']);
                    $('#country_'+id).val(store[0]['country']);
                    $('#store_lat_'+id).val(store[0]['latitude']);
                    $('#store_lng_'+id).val(store[0]['longitude']);
                    $('#country_short_'+id).val(store[0]['country_short']);
                    $('#store_description_'+id).val(store[0]['store_description']);



                    if(id == 2) {
                        $('#promo_qr_code_'+id).val(store[0]['qr_code']);
                        $('#promo_qr_image_'+id).val(store[0]['qr_image']);


                        if((store[0]['qr_image']).length > 0) {
                            $('#qr_code_prev_'+id).attr('src',"{{url('resources/assets/qr_codes')}}/"+store[0]['qr_image']);
                            $('#crt_qr_2').hide();
                            $('#print_code_2').show();
                            $('#refresh_qr_2').show();
                        } else {
                            $('#crt_qr_2').show();
                            $('#print_code_2').hide();
                            $('#refresh_qr_2').hide();
                        }
                    }



                    var give_away = store[0]['is_give_away'];


                    var business_id = business[0]['id'];

                    $('#business_type_' + id + "_" + business_id).prop('checked', true);
                    get_categories_select(business_id, id, categories);


                    input_validate_custom(id);

                }else {
                    alert('unable to find store please refresh and try again');
                }


            });


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

                    create_marker(lat, lng, store_id, 2, store_name, 7);
                }

            });
        }

        function get_closed_stores(){
            marker.setMap(null);
            Markers = [];

            $.get("{{ url('user/get_closed_store') }}",function(data){

                for(var x = 0; x < data.length; x++){
                    var lat = data[x]['latitude'];
                    var lng = data[x]['longitude'];
                    var store_id = data[x]['place_id'];
                    var store_name = data[x]['contact_name'];

                    create_marker(lat, lng, store_id, 3, store_name, 7);
                }

            });
        }

        $('#search_store').on('input', function (){
            var input = $('#search_store').val();

            if(input.length > 0){
                $.get("{{ url('user/search_stores') }}/"+input,function(data){
                    $('#search_result').html('');


                    for(var y = 0; y < data.length; y++){

                        var row = '<tr><td>'+data[y]['contact_name']+'</td><td>'+data[y]['name']+'</td><td>'+data[y]['address']+'</td><td>'+data[y]['created_at']+'</td></tr>';

                        $('#search_result').append(row);
                    }

                });
            }

        });

        function load_map(id){
            Marker = [];
            google.maps.event.addDomListener(window, 'load', mapInit(id));
        }

        $(".left_scroll").perfectScrollbar();

        $(".radio").change(function() {
            $(".radio").prop('checked', false);
            $(this).prop('checked', true);
        });

        function ChangeAutofill(id){
            if( $('#check_add_manually_' + id).prop('checked') == true ){
                $('#manual_add_' + id).show();
            } else {
                $('#manual_add_' + id).hide();
            }

        }

        function generate_qr_code(id) {
            progressSpinner('Creating Coupon Code...');
            $('#crt_qr_'+id).hide();

            $.get("{{ url('user/generate_new_qr') }}",function(data){

                $('#qr_code_prev_'+id).attr('src', "{{url('resources/assets/qr_codes')}}/"+data['qr_image']);
                // $('#print_code_'+id).attr('href', "{{url('resources/assets/qr_codes')}}/"+data['qr_image']);
                $('#promo_qr_image_'+id).val(data['qr_image']);
                $('#promo_qr_code_'+id).val(data['qr_content']);

            });

            $('#print_code_'+id).show();
            $('#refresh_qr_'+id).show();

            hideProgressSpinner();

        }

        function refresh_qr(id) {
            progressSpinner('Refreshing Coupon Code...');
            // get image qr code name
            var old_qr = $('#promo_qr_image_'+id).val();
            $('#qr_code_prev_'+id).attr('src', "{{url('resources/assets/custom/images/no-image.png')}}");

            hideProgressSpinner();
            generate_qr_code(id);
        }

        function view_qr_code(id) {
            var src = $('#qr_code_prev_' + id).attr('src');

            window.open(src);
            // alert(src);
        }


        function get_categories(type_id, id){
            $.get("{{ url('user/get_categories') }}/"+parseInt(type_id),function(data){
                // console.log(data);
                // empty category list
                $('#category_table_' + id).html('');

                var html_t = [];

                if(data.length > 0) {
                    for(var i = 0; i < data.length; i++) {
                        var row = "<tr>" +
                            "<td style='width:5%;'>&nbsp;</td>"+
                            "<td style='width:93%;'>" + data[i]['category'] + "</td>"+
                            "<td style='width:2%;'>"+
                            "<label class='btn-container'>"+
                            "<input type='checkbox' value='" + data[i]['id'] + "' id='category_" + id + "_" + data[i]['id'] + "' name='category_" + id +"[]' onclick=\"error_hide('category_error_" + id + "');\">"+
                            "<span class='checkmark'></span>"+
                            "</label>"+
                            "</td>"+
                            "</tr>";

                        html_t.push(row);
                    }
                }

                $('#category_table_' + id).html(html_t);

            });
        }

        function get_categories_select(type_id, id, categories){
            $.get("{{ url('user/get_categories') }}/"+parseInt(type_id),function(data){
                $('#category_table_' + id).html('');

               // console.log(categories);

                var html_t = [];

                if(data.length > 0) {
                    for(var i = 0; i < data.length; i++) {
                       // console.log(data[i]['id']);

                        if($.inArray(data[i]['id'].toString(), categories) != -1){
                            var row = "<tr>" +
                                "<td style='width:5%;'>&nbsp;</td>"+
                                "<td style='width:93%;'>" + data[i]['category'] + "</td>"+
                                "<td style='width:2%;'>"+
                                "<label class='btn-container'>"+
                                "<input type='checkbox' value='" + data[i]['id'] + "' id='category_" + id + "_" + data[i]['id'] + "' name='category_" + id +"[]' checked='checked' onclick=\"error_hide('category_error_" + id + "');\" > "+
                                "<span class='checkmark'></span>"+
                                "</label>"+
                                "</td>"+
                                "</tr>";

                            html_t.push(row);
                        }
                        else {
                            var row = "<tr>" +
                                "<td style='width:5%;'>&nbsp;</td>"+
                                "<td style='width:93%;'>" + data[i]['category'] + "</td>"+
                                "<td style='width:2%;'>"+
                                "<label class='btn-container'>"+
                                "<input type='checkbox' value='" + data[i]['id'] + "' id='category_" + id + "_" + data[i]['id'] + "' name='category_" + id +"[]' onclick=\"error_hide('category_error_" + id + "');\">"+
                                "<span class='checkmark'></span>"+
                                "</label>"+
                                "</td>"+
                                "</tr>";

                            html_t.push(row);
                        }

                    }
                }

                $('#category_table_' + id).html(html_t);
            });
        }

    </script>
    <script>
        // validate store
        function input_validate_custom(id){
            var err_1 = "This field is required";

            var st_name = $('#store_name_' + id).val();
            if(st_name.length > 0) {
                $('#store_name_error_' + id).html('');
            } else {
                $('#store_name_error_' + id).html(err_1);
            }

            var street_name = $('#street_name_' + id).val();
            if(street_name.length > 0) {
                $('#street_error_' + id).html('');
                $('#input_manual_error_' + id).html('');
            } else {
                $('#input_manual_error_' + id).html("Click 'Input Manually' to fill the address manually");
            }

            var town = $('#city_' + id).val();
            if(town.length > 0) {
                $('#town_error_' + id).html('');
            } else {
                $('#input_manual_error_' + id).html("Click 'Input Manually' to fill the address manually");
            }
            var state = $('#state_' + id).val();
            if(state.length > 0) {
                $('#state_error_' + id).html('');
            } else {
                $('#input_manual_error_' + id).html("Click 'Input Manually' to fill the address manually");
            }
            var zipcode = $('#postal_code_' + id).val();
            if(zipcode.length > 0) {
                $('#zip_code_error_' + id).html('');
            } else {
                $('#input_manual_error_' + id).html("Click 'Input Manually' to fill the address manually");
            }
            var country = $('#country_' + id).val();
            if(country.length > 0) {
                $('#country_error_' + id).html('');
            } else {
                $('#input_manual_error_' + id).html("Click 'Input Manually' to fill the address manually");
            }

            var st_lat = $('#store_lat_' + id).val();
            if(st_lat.length > 0) {
                $('#store_lat_error_' + id).html('');
            } else {
            }
            var st_lng = $('#store_lng_' + id).val();
            if(st_lng.length > 0) {
                $('#store_lng_error_' + id).html('');
            } else {
            }
            var country_short = $('#country_short_' + id).val();
            if(country_short.length > 0) {
                $('#country_short_error_' + id).html('');
            } else {
            }

            var qr_code = $('#promo_qr_code_' + id).val();
            if(qr_code.length > 0) {
                $('#qr_code_error_' + id).html('');
            } else {
                $('#qr_code_error_' + id).html(err_1);
            }
            var qr_img = $('#promo_qr_image_' + id).val();
            if(qr_img.length > 0) {
                $('#qr_code_error_' + id).html('');
            } else {
                $('#qr_code_error_' + id).html(err_1);
            }

            var business = 0;
            if(id == 1) {
                if ($("input[name='radio_1']").is(':checked')) {
                    business = 1;
                }
            } else if(id == 2) {
                if ($("input[name='radio_2']").is(':checked')) {
                    business = 1;
                }
            }

            if(business == 1) {
                $('#business_type_error_' + id).html('');
            } else {
                $('#business_type_error_' + id).html(err_1);
            }

            var category = 0;
            if(id == 1) {
                if ($('input[name="category_1[]"]').is(':checked')) {
                    category = 1;
                }
            }  else if(id == 2) {
                if ($('input[name="category_2[]"]').is(':checked')) {

                    category = 1;
                }
            }

            if(category == 1) {
                $('#category_error_' + id).html('');
            } else {
                $('#category_error_' + id).html(err_1);
            }

            // images
            var c_st_img = 1;
            var c_st_ar = 1;

            if( (st_name.length > 0) && (street_name.length > 0) && (town.length > 0) && (state.length > 0) && (zipcode.length > 0) && (country.length > 0) && (qr_code.length > 0) && (qr_img.length > 0) && (st_lat.length > 0) && (st_lng.length > 0) && (country_short.length > 0) && (business == 1) && (category == 1) &&(c_st_img == 1) && (c_st_ar == 1) ) {
                return 1;
            } else {
                return 0;
            }

        }

        function validate_crt(id) {
            progressSpinner('Processing...');
            var validator = input_validate_custom(id);

            if(validator == 1) {
                $('#store_form_' + id).submit();
            } else {
                hideProgressSpinner();
                alert("Please Fill the missing data..");
            }

        }

        function error_hide(field_id) {
            $('#'+ field_id).html('');
        }

        function submit_form(event, id){
            progressSpinner('Processing...');
            $('#store_form_' + id).submit();
            hideProgressSpinner();
        }

        function beforeSubmit(){
            progressSpinner('Processing...');
        }

    </script>

@endsection
