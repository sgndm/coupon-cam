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
                @if($is_member == 0)
                <li class="nav-item">
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
                <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">

                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/stores/create_store') }}" id="create_store_form">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">

                                        <div class="form-group">
                                            <label class="control-label">Store Name</label>
                                            <input type="text" id="store_name_1" name="store_name" class="form-control" placeholder="Enter Name" required onblur="validate_store_name(1);">
                                            <small class="form-control-feedback text-danger" id="store_name_error_1"> </small>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Store Address</label>
                                            <input type="text" id="store_address_1" name="store_address" class="form-control" placeholder="Start Typing Full Address..." required onblur="validate_address(id);">
                                            <small class="form-control-feedback text-danger" id="store_address_error_1"> </small>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Cant Find Address?</label>
                                            <label class="btn-container"> Input Manually
                                                <input type="checkbox" name="manually" onchange="ChangeAutofill(1)" value="0" id="check_add_manually_1">
                                                <span class="checkmark"></span>
                                            </label>
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
                                    </div>

                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Store Photo/Logo</label>
                                            <input type="file" id="store_image_1" name="store_image" class="dropify" data-height="100" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Store AR Image</label>
                                            <input type="file" id="store_ar_1" name="store_ar" class="dropify" data-height="100"  required/>
                                            <small class="form-control-feedback text-center">Please upload only pngs </small>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Store Description</label>
                                            <textarea id="store_description_1" name="store_description" class="form-control" required ></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label class="control-label">Coupon Code</label>
                                        <img src="" style="width:100%;" id="qr_code_prev_1">
                                        <input type="hidden" name="promo_qr_code" id="promo_qr_code_1" >
                                        <input type="hidden" name="promo_qr_image" id="promo_qr_image_1" >

                                        <div class="row justify-content-center">
                                            <button type="button" class="custom_btn crt_qr_code col-md-8" style="margin:2px;" onclick="generate_qr_code(1);" id="crt_qr_1"></button>

                                        <!-- <a class="" style="margin:2px;" target="_blank" href="" id="print_code_1" >
                                          <img src="{{url('resources/assets/custom/images/eedit_qr_code.png')}}" style="width:140px; height: 40px; cursor:pointer;" alt="">
                                        </a> -->

                                            <button type="button" class="custom_btn view_qr_code col-md-8" style="margin:2px;" onclick="view_qr_code(1);" id="print_code_1"></button>

                                            <button type="button" class="custom_btn refresh_qr_code col-md-8" style="margin:2px;" onclick="refresh_qr(1);" id="refresh_qr_1"></button>
                                            {{--<button type="submit" class="custom_btn save_c col-md-8"></button>--}}
                                        </div>
                                    </div>

                                    <!-- <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Give Away Price</label><br>
                                            <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="give_away" id="give_away_1" />
                                        </div>
                                    </div> -->
                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select A Business Type</label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Relevent Category</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 category_container left_scroll" >
                                                <table class="category_table">
                                                    @foreach($categories as $key => $category)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{$category->category}}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox" value="{{ $category->id }}" id="category" name="category[]">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="col-md-8 custom_btn save_c" onclick="validate_crt()"></button>
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
                <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                @else
                <div class="tab-pane active p-20" id="tab-pane-2" role="tabpanel">
                @endif

                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/stores/update_store') }}">
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
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
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
                                            <input type="hidden" id="store_name_2" name="store_name" required>
                                            <input type="hidden" id="store_image_hidden_2" name="store_image_hidden" required>
                                            <input type="hidden" id="store_ar_hidden_2" name="store_ar_hidden" required>
                                            <input type="hidden" id="store_marker_hidden_2" name="store_marker_hidden" required>
                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Store Photo/Logo</label>
                                            <input type="file" id="store_image_2" name="store_image" class="dropify" data-height="100" />
                                        </div>
                                        <div class="form-group">
                                            <img id="store_img_prev_2" style="width: 100%; max-height: 150px;">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Store AR Image</label>
                                            <input type="file" id="store_ar_2" name="store_ar" class="dropify" data-height="100"  />
                                            <small class="form-control-feedback text-center">Please upload only pngs </small>
                                        </div>
                                        <div class="form-group">
                                            <img id="store_ar_prev_2" style="width: 100%; max-height: 150px;">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Store Description</label>
                                            <textarea id="store_description_2" name="store_description" class="form-control" required ></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label class="control-label">Coupon Code</label>
                                        <img src="" style="width:100%;" id="qr_code_prev_2">
                                        <input type="hidden" name="promo_qr_code" id="promo_qr_code_2" >
                                        <input type="hidden" name="promo_qr_image" id="promo_qr_image_2" >

                                        <div class="row justify-content-center">
                                            <button type="button" class="custom_btn crt_qr_code col-md-8" style="margin:2px;" onclick="generate_qr_code(2);" id="crt_qr_2"></button>

                                            <button type="button" class="custom_btn view_qr_code col-md-8" style="margin:2px;" onclick="view_qr_code(2);" id="print_code_2"></button>

                                            <button type="button" class="custom_btn refresh_qr_code col-md-8" style="margin:2px;" onclick="refresh_qr(2);" id="refresh_qr_2"></button>

                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Give Away Price</label><br>
                                            <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="give_away" id="give_away_2" />
                                        </div>
                                    </div> -->
                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select A Business Type</label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Relevent Category</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 category_container left_scroll" >
                                                <table class="category_table">
                                                    @foreach($categories as $category)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{$category->category}}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox" value="{{ $category->id }}" id="category_2{{ $category->id }}" name="category[]" class="cat_check">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="update_store" class="col-md-8 custom_btn up_store"></button>
                                            <button type="submit" name="close_store" class="col-md-8 custom_btn cls_store"></button>
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
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>
                                            <label class="btn-container">Business
                                                <input type="radio" name="radio">
                                                <span class="checkRadio"></span>
                                            </label>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Relevent Category</label>
                                            <div class="col-sm-12 col-md-8 col-lg-8 category_container left_scroll">
                                                <table class="category_table">
                                                    @foreach($categories as $category)

                                                        <tr>
                                                            <td style="width:5%;">&nbsp;</td>
                                                            <td style="width:93%;">{{$category->category}}</td>
                                                            <td style="width:2%;">
                                                                <label class="btn-container">
                                                                    <input type="checkbox" value="{{ $category->id }}" id="category_3{{ $category->id }}" name="category[]" class="cat_check">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="reopen_store" class="col-md-8 custom_btn reop_store"></button>
                                            <button type="submit" name="delete_store" class="col-md-8 custom_btn del_store"></button>
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
        var map;
        var marker;
        var infowindow = new google.maps.InfoWindow();
        var Markers = new Array();

        $(document).ready(function(){
            load_map(1);
            $('.dropify').dropify();

            $('#crt_qr_1').show();
            $('#print_code_1').hide();
            $('#refresh_qr_1').hide();
        });

        function create_tab() {
            load_map(1);
            $('#crt_qr_1').show();
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

//                console.log(full_address);

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

            if($('#store'+id+store_id).prop('checked', false)){
                $('.radio').prop('checked', false);
                $('#store'+id+store_id).prop('checked', true);
            }

            $.get("{{ url('user/get_store_details') }}/"+parseInt(store_id),function(data){

                if(data['status'] == 1){
                    var store = data['details'];
                    var categories = data['categories'];

                    // empty form
                    $('#formid_'+id).val('');
                    $('#store_name_'+id).val('');
                    $('#street_num_'+id).val('');
                    $('#street_name_'+id).val('');
                    $('#city_'+id).val('');
                    $('#state_'+id).val('');
                    $('#postal_code_'+id).val('');
                    $('#country_'+id).val('');
                    $('#store_lat_'+id).val('');
                    $('#store_lng_'+id).val('');
                    $('#country_short_'+id).val('');
                    $('#store_image_hidden_'+id).val('');
                    $('#store_ar_hidden_'+id).val('');
                    $('#store_description_'+id).val('');
                    if(id == 2) {
                        $('#store_marker_hidden_2').val('');
                    }

                    $('#qr_code_prev_'+id).attr('src', "{{url('resources/assets/custom/images/no-image.png')}}");
                    $('#promo_qr_code_'+id).val('');
                    $('#promo_qr_image_'+id).val('');

                    // if($('#give_away_'+id).prop('checked', true)){
                    //     $('#give_away_'+id).parent().find(".switchery").trigger("click");
                    // }

                    // unset images
                    $('#store_img_prev_'+id).attr('src',"{{url('resources/assets/custom/images/no-image.png')}}");
                    $('#store_ar_prev_'+id).attr('src',"{{url('resources/assets/custom/images/no-image.png')}}");

                    // uncheck all checkbox
                    $('.cat_check').prop('checked',false);

                    // show marker
                    for(var i = 0; i < Markers.length; i++){
                        if(Markers[i][0] == store_id){
                            var tmpMark = Markers[i][2];
                            var tmpCont = Markers[i][1];
                            infowindow.setContent(tmpCont);
                            infowindow.open(map, tmpMark);
                        }
                    }
                    //console.log(store);
                    $('#formid_'+id).val(store[0]['place_id']);
                    $('#store_name_'+id).val(store[0]['contact_name']);
                    $('#street_num_'+id).val(store[0]['street_number']);
                    $('#street_name_'+id).val(store[0]['street_address']);
                    $('#city_'+id).val(store[0]['city']);
                    $('#state_'+id).val(store[0]['state']);
                    $('#postal_code_'+id).val(store[0]['postal_code']);
                    $('#country_'+id).val(store[0]['country']);
                    $('#store_lat_'+id).val(store[0]['latitude']);
                    $('#store_lng_'+id).val(store[0]['longitude']);
                    $('#country_short_'+id).val(store[0]['country_short']);
                    $('#store_image_hidden_'+id).val(store[0]['store_photo']);
                    $('#store_ar_hidden_'+id).val(store[0]['store_ar']);
                    $('#store_description_'+id).val(store[0]['store_description']);

                    if(id == 2) {
                        $('#store_marker_hidden_'+id).val(store[0]['store_marker']);
                        $('#promo_qr_code_'+id).val(store[0]['qr_code']);
                        $('#promo_qr_image_'+id).val(store[0]['qr_image']);


                        // set images
                        if((store[0]['store_photo']).length > 0) {
                            $('#store_img_prev_'+id).attr('src',"{{url('resources/assets/stores/store_photo')}}/"+store[0]['store_photo']);
                        }

                        if((store[0]['store_ar']).length > 0) {
                            $('#store_ar_prev_'+id).attr('src',"{{url('resources/assets/stores/store_ar')}}/"+store[0]['store_ar']);
                        }

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

                    // if(give_away == '1'){
                    //     $('#give_away_'+id).parent().find(".switchery").trigger("click");
                    // }




                    for(var j = 0; j < categories.length; j++){
                        $('#category_'+id+categories[j]).prop('checked', true);
                    }

                }else {
                    alert('unable to find store please refress and try again');
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
                            infowindow.setContent(data[x]['contact_name']);
                            infowindow.open(map, marker);
                            get_store_details(data[x]['place_id'], 2);
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

                    })(marker, x));

                    map.setCenter(center);
                    map.setZoom(8);

                    //drag_marker(2);

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

                    var center = new google.maps.LatLng(lat,lng);

                    marker = new google.maps.Marker({
                        position: center,
                        map: map,
                        draggable: false,
                        anchorPoint: new google.maps.Point(0, -29)

                    });


                    var temp = new Array();
                    temp.push(store_id, store_name, marker);

                    Markers.push(temp);
                    //console.log(Markers);

                    google.maps.event.addListener(marker, 'click', (function(marker, x) {

                        return function() {
                            infowindow.setContent(data[x]['contact_name']);
                            infowindow.open(map, marker);
                            get_store_details(data[x]['place_id'], 3);
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

                                        var street_num = "";
                                        var street_name = "";
                                        var city = "";
                                        var state = "";
                                        var postal_code = "";
                                        var country = "";
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
                                            }

                                        }


                                        bind_data_address(3,street_num,street_name,city,state,postal_code,country,latitude,longitude,full_address);

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
                    map.setZoom(8);

                    //drag_marker(2);

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
            {{--$.get("{{ url('user/delete_old_qr') }}/"+old_qr,function(data){});--}}

            generate_qr_code(id);
        }

        function view_qr_code(id) {
            var src = $('#qr_code_prev_' + id).attr('src');
            window.open(src);
            // alert(src);
        }

    </script>
    <script>
        // validate
        function validate_store_name(id){
//            var val = $('#store_name_' + id).val();
//            if(val.length == 0 ) {
//                $('#store_name_error_' + id).html('This field is a required field');
//            } else {
//                $('#store_name_error_' + id).html('');
//            }
        }

        function validate_address(id) {
//            var val = $('#store_address_' + id).val();
//            if(val.length == 0 ) {
//                $('#store_address_error_' + id).html('This field is a required field');
//            } else {
//                $('#store_address_error_' + id).html('');
//            }
        }

    </script>

@endsection
