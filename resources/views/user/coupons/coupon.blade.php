@extends('layouts.user')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card">
                <ul class="nav nav-tabs customtab" role="tablist">
                    @if($has_coupons == 0)
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab" >
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">CREATE COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" >
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">ACTIVE COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">PAUSED COUPONS</span>
                        </a>
                    </li>
                    @else 
                    
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-pane-2" role="tab" >
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">ACTIVE COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">PAUSED COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#tab-pane-1" role="tab" >
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">CREATE COUPONS</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item" >
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-4" aria-controls="tab-pane-4" role="tab" style="display: none;">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">PAUSED COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-5" role="tab">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">
                        <table>
                            <tr>
                                <td>SEARCH</td>
                                <td><input type="text" class="custom-input" id="search_coupon" ></td>
                                <td><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                            </tr>
                        </table>
                    </span>
                        </a>
                    </li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                @if($has_coupons == 0)
                    <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">
                    @else 
                    <div class="tab-pane p-20" id="tab-pane-1" role="tabpanel">
                    @endif

                        <div class="row">
                            <div class="col-md-9">

                                
                                <ul class="nav nav-tabs customtab_2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" aria-controls="cpn_l_1" href="#cpn_l_1" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 1 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#cpn_l_2" aria-controls="cpn_l_2" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 2 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_l_3" href="#cpn_l_3" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 3 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_l_4" href="#cpn_l_4" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 4 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" style="display: none;">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_l_5" href="#cpn_l_5" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down"></span>
                                        </a>
                                    </li>

                                </ul>

                                <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/coupons/create') }}" id="coupon_form_1">
                                    {{ csrf_field() }}
                                    <div class="tab-content">
                                        <div class="tab-pane active p-20" id="cpn_l_1" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_1" id="promo_id_c_1" onchange="get_curr_lable('c',1);error_hide('promo_id_error_c_1')">
                                                            <option value="0">Select Promo</option>
                                                            @if(sizeof($inactivePromos) > 0)
                                                                @foreach($inactivePromos as $promo)
                                                                    @if($new_promo_id > 0)
                                                                        @if($new_promo_id == $promo->promo_id)
                                                                        <option value="{{$promo->promo_id}}" selected>{{$promo->promo_name}}</option>
                                                                        @else
                                                                        <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>
                                                                        @endif

                                                                    @else 
                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            @endif
                                                        </select>
                                                        <h6 class="form-control-feedback text-danger" id="promo_id_error_c_1"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-4" id="c_p_f_c_1">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group row-justify-content-center" >
                                                            <label class="control-label col-xs-12 col-sm-12">Coupon Photo</label>


                                                            <div id="img_cropper_c_1">
                                                                <div class="uploader" id="uploader_c_1">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_1" id="coupon_photo_c_1" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_c_1');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_c_1"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_c_1"/>
                                                                

                                                                <button id="crop_btn_c_1" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_c_1" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_1" id="cp_img_name_c_1">
                                                            </div>

                                                            
                                                          
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_photo_error_c_1"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_1" oninput="search_ar_models(1,'c',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_1"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_1" >
                                                            <input type="hidden" name="ar_coupon_name_1" id="ar_coupon_name_c_1">
                                                            <input type="hidden" name="ar_marker_name_1" id="ar_marker_name_c_1">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_c_1"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_1" name="coupon_name_1" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_c_1');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_c_1"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_1" name="coupon_info_1" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_c_1');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_c_1"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <select id="coupon_availability_c_1" name="coupon_availability_1" class="form-control custom-select" required>
                                                            @for($x = 1; $x <= 100; $x++)
                                                                <option value="{{ $x }}"> {{ $x }} </option>
                                                            @endfor
                                                        </select>
                                                        {{--<input type="text" id="coupon_availability_c_1" name="coupon_availability_1" class="form-control" placeholder="" required>--}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_1" name="coupon_condition_1" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_c_1');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_c_1"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">

                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_c_1">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_c_1" name="coupon_value_1" class="form-control" placeholder="" required oninput="error_hide('coupon_value_error_c_1');" value="1" min="0" >
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_value_error_c_1"> </h6>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_1" id="loyalty_coupon_c_1" onchange="showHideLoyaltyCount(1, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_1" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_c_1" name="coupon_count_1" class="form-control" placeholder="" >

                                                        <br>
                                                        <br>
                                                        <label class="control-label">Minimunm Spend</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="min_lbl_c_1">$</span>
                                                            </div>
                                                            <input type="number" min="1" value="1" step="0.1" id="min_spent_c_1" name="min_spent_1" class="form-control" placeholder="" >
                                                            </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="validate_coupon_1('c',1,'cpn_l_2');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_2" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <!-- <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_2" id="promo_id_c_2">
                                                            <option>Select Promo</option>
                                                            @if(sizeof($inactivePromos) > 0)
                                                                @foreach($inactivePromos as $promo)

                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>

                                                                @endforeach
                                                            @else
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            @endif
                                                        </select>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>

                                                            <div id="img_cropper_c_2">
                                                                <div class="uploader" id="uploader_c_2">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_2" id="coupon_photo_c_2" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_c_2');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_c_2"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_c_2"/>
                                                                

                                                                <button id="crop_btn_c_2" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_c_2" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_2" id="cp_img_name_c_2">


                                                                <label class="btn-container"> Use Same Photo as Previous Coupon
                                                                    <input type="checkbox" value="" id="use_prev_c_2" name="use_prev_c_2" onclick="use_prev_photo('c',2);">
                                                                    <span class="checkmark"></span>
                                                                </label>  

                                                            </div>
                                                            <h6 class="form-control-feedback text-danger" id="coupon_photo_error_c_2"> </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_2" oninput="search_ar_models(2,'c',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                        <label class="btn-container"> Use Same AR Coupon as Previous Coupon
                                                                    <input type="checkbox" value="" id="use_prev_ar_c_2" name="use_prev_ar_c_2" onclick="use_prev_ar_model('c',2);">
                                                                    <span class="checkmark"></span>
                                                                </label> 
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_2"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_2" onchange="error_hide('coupon_ar_error_c_2');">
                                                            <input type="hidden" name="ar_coupon_name_2" id="ar_coupon_name_c_2">
                                                            <input type="hidden" name="ar_marker_name_2" id="ar_marker_name_c_2">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_c_2"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_2" name="coupon_name_2" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_c_2');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_c_2"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_2" name="coupon_info_2" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_c_2');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_c_2"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <select id="coupon_availability_c_2" name="coupon_availability_2" class="form-control custom-select" required>
                                                            @for($x = 1; $x <= 100; $x++)
                                                                <option value="{{ $x }}"> {{ $x }} </option>
                                                            @endfor
                                                        </select>
                                                        {{--<input type="text" id="coupon_availability_c_2" name="coupon_availability_2" class="form-control" placeholder="" required>--}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_2" name="coupon_condition_2" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_c_2');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_c_2"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_c_2">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_c_2" name="coupon_value_2" class="form-control" placeholder="" required min="0" value="1">
                                                        </div>

                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_2" id="loyalty_coupon_c_2" onchange="showHideLoyaltyCount(2, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_2" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_c_2" name="coupon_count_2" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="validate_coupon_1('c',2,'cpn_l_3');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <!-- <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_3" id="promo_id_c_2">
                                                            <option>Select Promo</option>
                                                            @if(sizeof($inactivePromos) > 0)
                                                                @foreach($inactivePromos as $promo)

                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>

                                                                @endforeach
                                                            @else
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            @endif
                                                        </select>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>

                                                            <div id="img_cropper_c_3">
                                                                <div class="uploader" id="uploader_c_3">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_3" id="coupon_photo_c_3" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_c_3');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_c_3"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_c_3"/>
                                                                

                                                                <button id="crop_btn_c_3" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_c_3" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_3" id="cp_img_name_c_3">


                                                                <label class="btn-container"> Use Same Photo as Previous Coupon
                                                                    <input type="checkbox" value="" id="use_prev_c_3" name="use_prev_c_3" onclick="use_prev_photo('c',3);">
                                                                    <span class="checkmark"></span>
                                                                </label>  


                                                            </div>
                                                            <h6 class="form-control-feedback text-danger" id="coupon_photo_error_c_3"> </h6>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_3" oninput="search_ar_models(3,'c',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                        <label class="btn-container"> Use Same AR Coupon as Previous Coupon
                                                                    <input type="checkbox" value="" id="use_prev_ar_c_3" name="use_prev_ar_c_3" onclick="use_prev_ar_model('c',3);">
                                                                    <span class="checkmark"></span>
                                                                </label> 
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_3"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_3" >
                                                            <input type="hidden" name="ar_coupon_name_3" id="ar_coupon_name_c_3">
                                                            <input type="hidden" name="ar_marker_name_3" id="ar_marker_name_c_3">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_c_3"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_3" name="coupon_name_3" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_c_3');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_c_3"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_3" name="coupon_info_3" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_c_3');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_c_3"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <select id="coupon_availability_c_3" name="coupon_availability_3" class="form-control custom-select" required>
                                                            @for($x = 1; $x <= 100; $x++)
                                                                <option value="{{ $x }}"> {{ $x }} </option>
                                                            @endfor
                                                        </select>
                                                        {{--<input type="text" id="coupon_availability_c_3" name="coupon_availability_3" class="form-control" placeholder="" required>--}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_3" name="coupon_condition_3" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_c_3');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_c_3"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_c_3">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_c_3" name="coupon_value_3" class="form-control" placeholder="" required min="0" value="1">
                                                        </div>

                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_3" id="loyalty_coupon_c_3" onchange="showHideLoyaltyCount(3, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_3" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_c_3" name="coupon_count_3" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="validate_coupon_1('c',3,'cpn_l_4');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <!-- <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_4" id="promo_id_c_2">
                                                            <option>Select Promo</option>
                                                            @if(sizeof($inactivePromos) > 0)
                                                                @foreach($inactivePromos as $promo)

                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>

                                                                @endforeach
                                                            @else
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            @endif
                                                        </select>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>

                                                            <div id="img_cropper_c_4">
                                                                <div class="uploader" id="uploader_c_4">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_4" id="coupon_photo_c_4" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_c_4');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_c_4"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_c_4"/>
                                                                

                                                                <button id="crop_btn_c_4" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_c_4" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_4" id="cp_img_name_c_4">
                                                                
                                                                <label class="btn-container"> Use Same Photo as Previous Coupon
                                                                    <input type="checkbox" value="" id="use_prev_c_4" name="use_prev_c_4" onclick="use_prev_photo('c',4);">
                                                                    <span class="checkmark"></span>
                                                                </label>  

                                                            </div>
                                                            <h6 class="form-control-feedback text-danger" id="coupon_photo_error_c_4"> </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_4" oninput="search_ar_models(4,'c',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>

                                                        <label class="btn-container"> Use Same AR Coupon as Previous Coupon
                                                                    <input type="checkbox" value="" id="use_prev_ar_c_4" name="use_prev_ar_c_4" onclick="use_prev_ar_model('c',4);">
                                                                    <span class="checkmark"></span>
                                                                </label>  
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_4"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_4" >
                                                            <input type="hidden" name="ar_coupon_name_4" id="ar_coupon_name_c_4">
                                                            <input type="hidden" name="ar_marker_name_4" id="ar_marker_name_c_4">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_c_4"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_4" name="coupon_name_4" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_c_4');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_c_4"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_4" name="coupon_info_4" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_c_4');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_c_4"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_c_4" name="coupon_availability_4" class="form-control" placeholder="" required value="Unlimited" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_4" name="coupon_condition_4" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_c_4');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_c_4"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_c_4">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_c_4" name="coupon_value_4" class="form-control" placeholder="" required min="0" value="1">
                                                        </div>

                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_4" id="loyalty_coupon_c_4" onchange="showHideLoyaltyCount(4, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_4" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_c_4" name="coupon_count_4" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="validate_coupon_1('c',4,'cpn_l_5');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_5" role="tabpanel">

                                            <div class="row justify-content-center">
                                                <p class="col-sm-12 col-md-12 col-lg-12 text-danger text-center"><br><br><b>OK you are all set!</b> <br><br></p>
                                                <input type="hidden" name="submit_type" id="submit_type_c" value="" />
                                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                    {{--<button type="submit" class="col-md-6 custom_btn save_c_c" ></button>--}}
                                                    <button type="button" name="save_active" class="custom_btn col-md-4 save_c_c" onclick="validate_coupon_form('c',1, 1);"></button>

                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                    {{--<button type="submit" class="col-md-6 custom_btn save_c_c" ></button>--}}
                                                    <button type="button" name="save_later" class="custom_btn col-md-4 " onclick="validate_coupon_form('c',1,0);" >active_later</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-3">
                                <div class="imagecontainer">
                                    <div class="headingc" id="heading_c_1"></div>
                                    <div class="contentc" id="content_c1">
                                        <div class="goimagec"></div>
                                        <img id="image_c_1" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_c_2"></div>
                                    <div class="contentc" id="content_c2">
                                        <div class="goimagec"></div>
                                        <img id="image_c_2" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_c_3"></div>
                                    <div class="contentc" id="content_c3">
                                        <div class="goimagec"></div>
                                        <img id="image_c_3" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_c_4"></div>
                                    <div class="contentc" id="content_c4">
                                        <div class="goimagec"></div>
                                        <img id="image_c_4" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if($has_coupons == 0)
                    <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                    @else
                    <div class="tab-pane active p-20" id="tab-pane-2" role="tabpanel">
                    @endif
                        <?php
                        $promoCount = sizeof($activePromos);
                        $itemCount = 0;

                        if(($promoCount % 5) == 0){
                            $itemCount = intval($promoCount / 5);
                        } else {
                            $itemCount = intval(($promoCount / 5)) + 1;
                        }
                        ?>

                        @if($promoCount > 0)

                            <div class="card">
                                <div class="card-body">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">
                                                <div class="row justify-content-md-center">
                                                    @if($itemCount == 1)
                                                        @for($y = 0; $y < $promoCount; $y++)
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($activePromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $activePromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$activePromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        @endfor


                                                    @else
                                                        @for($y = 0; $y < 5; $y++)
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($activePromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $activePromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$activePromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    @endif

                                                </div>
                                            </div>

                                            @for($y = 5; $y < $promoCount; $y++)

                                                @if((intval($y % 5) == 0) && ($y == ($promoCount - 1)) )
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($activePromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $activePromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$activePromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif(intval($y % 5) == 0)
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($activePromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $activePromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$activePromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            @elseif((intval($y % 5) == 4) || ($y == ($promoCount - 1)))
                                                                <div class="col-sm-6 col-md-4 col-lg-2">
                                                                    <h3 class="text-center text-danger">{{strtoupper($activePromos[$y]->promo_name)}}</h3>
                                                                    <div class="imagecontainer2">

                                                                        @foreach($coupons as $coupon)

                                                                            @if($coupon->promo_id == $activePromos[$y]->promo_id)
                                                                                @if($coupon->coupon_level == 1)
                                                                                    <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a1">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @elseif($coupon->coupon_level == 2)
                                                                                    <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a2">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @elseif($coupon->coupon_level == 3)
                                                                                    <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a3">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @elseif($coupon->coupon_level == 4)
                                                                                    <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a4">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @endif
                                                                            @endif

                                                                        @endforeach

                                                                    </div>
                                                                    <div class="col-md-12 text-center">
                                                                        <a  class="" onclick="edit_active_coupons({{$activePromos[$y]->promo_id}});"  >
                                                                            <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>

                                                @else
                                                    <div class="col-sm-6 col-md-4 col-lg-2">
                                                        <h3 class="text-center text-danger">{{strtoupper($activePromos[$y]->promo_name)}}</h3>
                                                        <div class="imagecontainer2">

                                                            @foreach($coupons as $coupon)

                                                                @if($coupon->promo_id == $activePromos[$y]->promo_id)
                                                                    @if($coupon->coupon_level == 1)
                                                                        <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a1">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @elseif($coupon->coupon_level == 2)
                                                                        <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a2">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @elseif($coupon->coupon_level == 3)
                                                                        <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a3">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @elseif($coupon->coupon_level == 4)
                                                                        <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a4">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @endif
                                                                @endif

                                                            @endforeach

                                                        </div>
                                                        <div class="col-md-12 text-center">
                                                            <a  class="" onclick="edit_active_coupons({{$activePromos[$y]->promo_id}});"  >
                                                                <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif

                                            @endfor
                                        </div>




                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow.png')}}" style="width: 70%;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        @else
                            {{ "No active Coupons available" }}
                        @endif
                    </div>
                    <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                        <?php
                        $promoCount = sizeof($puasedPromos);
                        $itemCount = 0;

                        if(($promoCount % 5) == 0){
                            $itemCount = intval($promoCount / 5);
                        } else {
                            $itemCount = intval(($promoCount / 5)) + 1;
                        }
                        ?>

                        @if($promoCount > 0)

                            <div class="card">
                                <div class="card-body">
                                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">
                                                <div class="row justify-content-md-center">
                                                    @if($itemCount == 1)
                                                        @for($y = 0; $y < $promoCount; $y++)
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($puasedPromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $puasedPromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$puasedPromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        @endfor


                                                    @else
                                                        @for($y = 0; $y < 5; $y++)
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($puasedPromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $puasedPromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$puasedPromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    @endif

                                                </div>
                                            </div>

                                            @for($y = 5; $y < $promoCount; $y++)

                                                @if((intval($y % 5) == 0) && ($y == ($promoCount - 1)) )
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($puasedPromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $puasedPromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$puasedPromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif(intval($y % 5) == 0)
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger">{{strtoupper($puasedPromos[$y]->promo_name)}}</h3>
                                                                <div class="imagecontainer2">

                                                                    @foreach($coupons as $coupon)

                                                                        @if($coupon->promo_id == $puasedPromos[$y]->promo_id)
                                                                            @if($coupon->coupon_level == 1)
                                                                                <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 2)
                                                                                <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 3)
                                                                                <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @elseif($coupon->coupon_level == 4)
                                                                                <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons({{$puasedPromos[$y]->promo_id}});"  >
                                                                        <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            @elseif((intval($y % 5) == 4) || ($y == ($promoCount - 1)))
                                                                <div class="col-sm-6 col-md-4 col-lg-2">
                                                                    <h3 class="text-center text-danger">{{strtoupper($puasedPromos[$y]->promo_name)}}</h3>
                                                                    <div class="imagecontainer2">

                                                                        @foreach($coupons as $coupon)

                                                                            @if($coupon->promo_id == $puasedPromos[$y]->promo_id)
                                                                                @if($coupon->coupon_level == 1)
                                                                                    <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a1">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @elseif($coupon->coupon_level == 2)
                                                                                    <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a2">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @elseif($coupon->coupon_level == 3)
                                                                                    <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a3">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @elseif($coupon->coupon_level == 4)
                                                                                    <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                                    <div class="contenta" id="content_a4">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                                    </div>
                                                                                @endif
                                                                            @endif

                                                                        @endforeach

                                                                    </div>
                                                                    <div class="col-md-12 text-center">
                                                                        <a  class="" onclick="edit_active_coupons({{$puasedPromos[$y]->promo_id}});"  >
                                                                            <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>

                                                @else
                                                    <div class="col-sm-6 col-md-4 col-lg-2">
                                                        <h3 class="text-center text-danger">{{strtoupper($puasedPromos[$y]->promo_name)}}</h3>
                                                        <div class="imagecontainer2">

                                                            @foreach($coupons as $coupon)

                                                                @if($coupon->promo_id == $puasedPromos[$y]->promo_id)
                                                                    @if($coupon->coupon_level == 1)
                                                                        <div class="headinga" id="heading_a_1"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a1">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @elseif($coupon->coupon_level == 2)
                                                                        <div class="headinga" id="heading_a_2"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a2">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @elseif($coupon->coupon_level == 3)
                                                                        <div class="headinga" id="heading_a_3"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a3">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @elseif($coupon->coupon_level == 4)
                                                                        <div class="headinga" id="heading_a_4"> {{ $coupon->coupon_title }} </div>
                                                                        <div class="contenta" id="content_a4">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="{{ asset('resources/assets/coupons/full/' . $coupon->coupon_photo ) }}" style="width: 100%;">
                                                                        </div>
                                                                    @endif
                                                                @endif

                                                            @endforeach

                                                        </div>
                                                        <div class="col-md-12 text-center">
                                                            <a  class="" onclick="edit_active_coupons({{$puasedPromos[$y]->promo_id}});"  >
                                                                <img src="{{url('resources/assets/CCUI/edit_coup.png')}}" style="width:140px; height: 40px; cursor:pointer;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif

                                            @endfor
                                        </div>




                                        <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                                            <span> <img src="{{asset('resources/assets/custom/images/arrow.png')}}" style="width: 70%;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        @else
                            {{ "No Paused Coupons available" }}
                        @endif
                    </div>
                    <div class="tab-pane p-20" id="tab-pane-4" role="tabpanel">
                        <div class="row">
                            <div class="col-md-9">

                                <ul class="nav nav-tabs customtab_2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" aria-controls="cpn_e_1" href="#cpn_e_1" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 1 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#cpn_e_2" aria-controls="cpn_e_2" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 2 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_e_3" href="#cpn_e_3" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 3 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_e_4" href="#cpn_e_4" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 4 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" style="display: none;">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_e_5" href="#cpn_e_5" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down"></span>
                                        </a>
                                    </li>

                                </ul>

                                <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/coupons/update') }}" id="coupon_form_2">
                                    {{ csrf_field() }}
                                    <div class="tab-content">

                                        <input type="hidden" name="coupon_id_1" id="coupon_id_e_1" >
                                        <input type="hidden" name="coupon_id_2" id="coupon_id_e_2" >
                                        <input type="hidden" name="coupon_id_3" id="coupon_id_e_3" >
                                        <input type="hidden" name="coupon_id_4" id="coupon_id_e_4" >
                                        <input type="hidden" name="coup_img_1" id="coup_img_e_1" >
                                        <input type="hidden" name="coup_img_2" id="coup_img_e_2" >
                                        <input type="hidden" name="coup_img_3" id="coup_img_e_3" >
                                        <input type="hidden" name="coup_img_4" id="coup_img_e_4" >

                                        <div class="tab-pane active p-20" id="cpn_e_1" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_1" id="promo_id_e_1" onchange="get_curr_lable('e',1);">
                                                            <option>Select Promo</option>
                                                            @if(sizeof($allPromos) > 0)
                                                                @foreach($allPromos as $promo)

                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>

                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>

                                                            <div id="img_cropper_e_1">
                                                                <div class="uploader" id="uploader_e_1">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_1" id="coupon_photo_e_1" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_e_1');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_e_1"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_e_1"/>
                                                                

                                                                <button id="crop_btn_e_1" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_e_1" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_1" id="cp_img_name_e_1">
                                                            </div>
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_photo_error_e_1"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_1" oninput="search_ar_models(1,'e',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_1"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_1" >
                                                            <input type="hidden" name="ar_coupon_name_1" id="ar_coupon_name_e_1">
                                                            <input type="hidden" name="ar_marker_name_1" id="ar_marker_name_e_1">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_e_1"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_1" name="coupon_name_1" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_e_1');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_e_1"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_1" name="coupon_info_1" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_e_1');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_e_1"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <select id="coupon_availability_e_1" name="coupon_availability_1" class="form-control custom-select" required>
                                                            @for($x = 1; $x <= 100; $x++)
                                                                <option value="{{ $x }}"> {{ $x }} </option>
                                                            @endfor
                                                        </select>
                                                        {{--<input type="text" id="coupon_availability_e_1" name="coupon_availability_1" class="form-control" placeholder="" required>--}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_1" name="coupon_condition_1" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_e_1');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_e_1"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_e_1">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_e_1" name="coupon_value_1" class="form-control" placeholder="" required min="0" value="1">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_1" id="loyalty_coupon_e_1" onchange="showHideLoyaltyCount(1, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_1" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_e_1" name="coupon_count_1" class="form-control" placeholder="" >
                                                        <br>
                                                        <br>
                                                        <label class="control-label">Minimunm Spend</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="min_lbl_e_1">$</span>
                                                            </div>
                                                            <input type="number" min="1" value="1" step="0.1" id="min_spent_e_1" name="min_spent_1" class="form-control" placeholder="" >
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="validate_coupon_1('e',1,'cpn_e_2');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_2" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <!-- <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_2" id="promo_id_e_2" disabled>
                                                            <option>Select Promo</option>
                                                            @if(sizeof($allPromos) > 0)
                                                                @foreach($allPromos as $promo)

                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>

                                                                @endforeach
                                                            @else
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            @endif
                                                        </select>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>

                                                            <div id="img_cropper_e_2">
                                                                <div class="uploader" id="uploader_e_2">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_2" id="coupon_photo_e_2" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_e_2');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_e_2"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_e_2"/>
                                                                

                                                                <button id="crop_btn_e_2" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_e_2" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_2" id="cp_img_name_e_2">
                                                            </div>

                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_photo_error_e_2"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_2" oninput="search_ar_models(2,'e',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_2"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_2" >
                                                            <input type="hidden" name="ar_coupon_name_2" id="ar_coupon_name_e_2">
                                                            <input type="hidden" name="ar_marker_name_2" id="ar_marker_name_e_2">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_e_2"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_2" name="coupon_name_2" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_e_2');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_e_2"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_2" name="coupon_info_2" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_e_2');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_e_2"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <select id="coupon_availability_e_2" name="coupon_availability_2" class="form-control custom-select" required>
                                                            @for($x = 1; $x <= 100; $x++)
                                                                <option value="{{ $x }}"> {{ $x }} </option>
                                                            @endfor
                                                        </select>
                                                        {{--<input type="text" id="coupon_availability_e_2" name="coupon_availability_2" class="form-control" placeholder="" required>--}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_2" name="coupon_condition_2" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_e_2');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_e_2"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_e_2">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_e_2" name="coupon_value_2" class="form-control" placeholder="" required min="0" value="1">
                                                        </div>

                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_2" id="loyalty_coupon_e_2" onchange="showHideLoyaltyCount(2, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_2" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_e_2" name="coupon_count_2" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="validate_coupon_1('e',2,'cpn_e_3');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <!-- <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_3" id="promo_id_e_2" disabled>
                                                            <option>Select Promo</option>
                                                            @if(sizeof($allPromos) > 0)
                                                                @foreach($allPromos as $promo)

                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>

                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>

                                                            <div id="img_cropper_e_3">
                                                                <div class="uploader" id="uploader_e_3">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_3" id="coupon_photo_e_3" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_e_3');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_e_3"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_e_3"/>
                                                                

                                                                <button id="crop_btn_e_3" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_e_3" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_3" id="cp_img_name_e_3">
                                                            </div>
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_photo_error_e_3"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_3" oninput="search_ar_models(3,'e',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_3"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_3" >
                                                            <input type="hidden" name="ar_coupon_name_3" id="ar_coupon_name_e_3">
                                                            <input type="hidden" name="ar_marker_name_3" id="ar_marker_name_e_3">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_e_3"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_3" name="coupon_name_3" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_e_3');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_e_3"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_3" name="coupon_info_3" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_e_3');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_e_3"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <select id="coupon_availability_e_3" name="coupon_availability_3" class="form-control custom-select" required>
                                                            @for($x = 1; $x <= 100; $x++)
                                                                <option value="{{ $x }}"> {{ $x }} </option>
                                                            @endfor
                                                        </select>
                                                        {{--<input type="text" id="coupon_availability_e_3" name="coupon_availability_3" class="form-control" placeholder="" required>--}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_3" name="coupon_condition_3" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_e_3');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_e_3"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_e_3">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_e_3" name="coupon_value_3" class="form-control" placeholder="" required min="0" value="1">
                                                        </div>

                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_3" id="loyalty_coupon_e_3" onchange="showHideLoyaltyCount(3, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_3" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_e_3" name="coupon_count_3" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="validate_coupon_1('e',3,'cpn_e_4');"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <!-- <div class="form-group">
                                                        <label class="control-label">Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_4" id="promo_id_e_2" disabled>
                                                            <option>Select Promo</option>
                                                            @if(sizeof($allPromos) > 0)
                                                                @foreach($allPromos as $promo)

                                                                    <option value="{{$promo->promo_id}}">{{$promo->promo_name}}</option>

                                                                @endforeach
                                                            @else
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            @endif
                                                        </select>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">View Suggestions</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>

                                                            <div id="img_cropper_e_4">
                                                                <div class="uploader" id="uploader_e_4">

                                                                    <img src="{{url('resources/assets/custom/images/up-cloud.png')}}" alt="" class="up-icon"><br>
                                                                    <b>Drag and drop a file here or click</b>

                                                                    <input type="file" name="coupon_photo_4" id="coupon_photo_e_4" class="filePhoto cropit-image-input" onchange="error_hide('coupon_photo_error_e_4');" >
                                                                </div>
                                                                    
                                                                <div class="cropit-preview" id="cropper_prev_e_4"></div>
                                                                <input type="range" class="cropit-image-zoom-input" id="ranger_e_4"/>
                                                                

                                                                <button id="crop_btn_e_4" class="btn btn-danger col-sm-12 crop_btn" type="button">Crop & Save</button> &nbsp;
                                                                <button id="rem_e_4" class="btn btn-danger col-sm-12 res_btn" type="button">Remove</button>

                                                                <input type="hidden" name="cp_img_name_4" id="cp_img_name_e_4">
                                                            </div>
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_photo_error_e_4"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_4" oninput="search_ar_models(4,'e',this.value);" ></td>
                                                                <td><br><br><img src="{{url('resources/assets/custom/images/search.png')}}" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_4"></div>
                                                            </div>
                                                            <img src="{{url('resources/assets/custom/images/no-image.png')}}" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_4" >
                                                            <input type="hidden" name="ar_coupon_name_4" id="ar_coupon_name_e_4">
                                                            <input type="hidden" name="ar_marker_name_4" id="ar_marker_name_e_4">
                                                        </div>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_ar_error_e_4"> </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_4" name="coupon_name_4" class="form-control" placeholder="Enter Name" required oninput="error_hide('coupon_name_error_e_4');" maxlength="20" >
                                                        <h6 class="form-control-feedback text-danger" id="coupon_name_error_e_4"> </h6>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_4" name="coupon_info_4" class="form-control" placeholder="" required oninput="error_hide('coupon_info_error_e_4');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_info_error_e_4"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_e_4" name="coupon_availability_4" class="form-control" placeholder="" required value="Unlimited" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_4" name="coupon_condition_4" class="form-control" placeholder="" oninput="error_hide('coupon_desc_error_e_4');"></textarea>
                                                        <h6 class="form-control-feedback text-danger" id="coupon_desc_error_e_4"> </h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value <span ></span></label>

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="curr_lbl_e_4">$</span>
                                                            </div>
                                                            <input type="number" id="coupon_value_e_4" name="coupon_value_4" class="form-control" placeholder="" required min="0" value="1">
                                                        </div>

                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_4" id="loyalty_coupon_e_4" onchange="showHideLoyaltyCount(4, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_4" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="1" max="10" value="1" id="coupon_count_e_4" name="coupon_count_4" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="validate_coupon_1('e',4,'cpn_e_5');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_5" role="tabpanel">

                                            <div class="form-group  row justify-content-md-center">
                                                <p class="col-sm-12 col-md-12 col-lg-12 text-danger text-center"><br><br>Save and Continue to Update Coupons<br><br></p>
                                                <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                                                    <button type="button" class="col-md-6 custom_btn save_c_c" onclick="validate_coupon_form('e',2,0);" ></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-3">
                                <div class="imagecontainer">
                                    <div class="headingc" id="heading_e_1"></div>
                                    <div class="contentc" id="content_e1">
                                        <div class="goimagec"></div>
                                        <img id="image_e_1" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_e_2"></div>
                                    <div class="contentc" id="content_e2">
                                        <div class="goimagec"></div>
                                        <img id="image_e_2" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_e_3"></div>
                                    <div class="contentc" id="content_e3">
                                        <div class="goimagec"></div>
                                        <img id="image_e_3" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_e_4"></div>
                                    <div class="contentc" id="content_e4">
                                        <div class="goimagec"></div>
                                        <img id="image_e_4" src="{{ asset('resources/assets/user/images/imageplaceholder.png') }}" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20" id="tab-pane-5" role="tabpanel">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Coupon Name</th>
                                <th>Store(s)</th>
                                <th>Promo Name</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody id="search_result"></tbody>
                        </table>
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

    <script>

        $(document).ready(function(){
            // $('.dropify').dropify();

            $('.cropit-preview').hide();
            $('.crop_btn').hide();
            $('.res_btn').hide();
            $('.cropit-image-zoom-input').hide();

        });

        function crop_image(page, id) {

            var imageData = $('#img_cropper_' + page + '_' + id).cropit('export');
            $('#cp_img_name_' + page + '_' + id).val(imageData);
            $('#image_' + page + '_' + id).attr('src', imageData);

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
            $('#image_' + page + '_' + id).attr('src',"{{ asset('resources/assets/user/images/imageplaceholder.png') }}" );
        }

        $('#img_cropper_c_1').cropit({exportZoom: 3});
        $('#img_cropper_c_2').cropit({exportZoom: 3});
        $('#img_cropper_c_3').cropit({exportZoom: 3});
        $('#img_cropper_c_4').cropit({exportZoom: 3});
        $('#img_cropper_e_1').cropit({exportZoom: 3});
        $('#img_cropper_e_2').cropit({exportZoom: 3});
        $('#img_cropper_e_3').cropit({exportZoom: 3});
        $('#img_cropper_e_4').cropit({exportZoom: 3});

        $('#coupon_photo_c_1').on('change', function() {
            activate_cropper('c', 1);
        });

        $('#crop_btn_c_1').on('click',function () {
            crop_image('c', 1);
        });

        $('#rem_c_1').on('click', function() {
            clear_cropper('c', 1);
        });

        $('#coupon_photo_c_2').on('change', function() {
            activate_cropper('c', 2);
        });

        $('#crop_btn_c_2').on('click',function () {
            crop_image('c', 2);
        });

        $('#rem_c_2').on('click', function() {
            clear_cropper('c', 2);
        });


        $('#coupon_photo_c_3').on('change', function() {
            activate_cropper('c', 3);
        });

        $('#crop_btn_c_3').on('click',function () {
            crop_image('c', 3);
        });

        $('#rem_c_3').on('click', function() {
            clear_cropper('c', 3);
        });

        $('#coupon_photo_c_4').on('change', function() {
            activate_cropper('c', 4);
        });

        $('#crop_btn_c_4').on('click',function () {
            crop_image('c', 4);
        });

        $('#rem_c_4').on('click', function() {
            clear_cropper('c', 4);
        });


        $('#coupon_photo_e_1').on('change', function() {
            activate_cropper('e', 1);
        });

        $('#crop_btn_e_1').on('click',function () {
            crop_image('e', 1);
        });

        $('#rem_e_1').on('click', function() {
            clear_cropper('e', 1);
        });


        $('#coupon_photo_e_2').on('change', function() {
            activate_cropper('e', 2);
        });

        $('#crop_btn_e_2').on('click',function () {
            crop_image('e', 2);
        });

        $('#rem_e_2').on('click', function() {
            clear_cropper('e', 2);
        });
        
        $('#coupon_photo_e_3').on('change', function() {
            activate_cropper('e', 3);
        });

        $('#crop_btn_e_3').on('click',function () {
            crop_image('e', 3);
        });

        $('#rem_e_3').on('click', function() {
            clear_cropper('e', 3);
        });

        $('#coupon_photo_e_4').on('change', function() {
            activate_cropper('e', 4);
        });

        $('#crop_btn_e_4').on('click',function () {
            crop_image('e', 4);
        });

        $('#rem_e_4').on('click', function() {
            clear_cropper('e', 4);
        });
        

        function showHideLoyaltyCount(id, page){
            var checked = $('#loyalty_coupon_'+page+'_'+id).is(':checked');

            if(checked){
                $('#lc_cont_'+page+'_'+id).show();
            } else {
                $('#lc_cont_'+page+'_'+id).hide();
            }

        }

        function search_ar_models(id, page, input) {
            $.get("{{ url('user/search_ar_models') }}/"+input,function(data){
                console.log(data);
                var list = '<ul>';
                for(var x =0; x < data.length; x++){
                    var ar_image = data[x]['image_thumbnail'];
                    var ar_name = data[x]['image_tags'];
                    var ar_marker = data[x]['marker'];
                    list += "<li><p class='ar_list' onclick='showInPrev("+id+",\""+page+"\",\""+ar_image+"\",\""+ar_marker+"\");'>"+ar_name+"</p></li>";

                }
                list+="</ul>";

                $('#ar_search_result_'+page+'_'+id).html(list);
            });
        }

        function showInPrev(id, page, ar_image, ar_marker){

            error_hide('coupon_ar_error_'+ page+'_'+id);

            $('#ar_prev_'+page+'_'+id).attr('src', "{{url('resources/assets/media')}}/"+ar_image);
            $('#ar_coupon_name_'+page+'_'+id).val(ar_image);
            $('#ar_marker_name_'+page+'_'+id).val(ar_marker);

            $('#ar_search_result_'+page+'_'+id).hide();
        }

        function readURL(input,id,page) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_'+page+'_'+id).attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);

            }
        }

        function nextTab(next_tab){
            $('a[aria-controls="'+next_tab+'"]').trigger("click");
        }


        function use_prev_photo(page, id) {

            if($('#use_prev_'+page+'_'+id).is(':checked')) {
                // get prev image 
                var prev = $('#cp_img_name_' + page + '_' + (id - 1)).val();

                $('#cp_img_name_' + page + '_' + id).val(prev);
                $('#image_' + page + '_' + id).attr('src', prev);
            }
            else {
                $('#cp_img_name_' + page + '_' + id).val('');
                $('#image_' + page + '_' + id).attr('src',"{{ asset('resources/assets/user/images/imageplaceholder.png') }}" );
            }
        }

        function use_prev_ar_model(page, id) {
            if($('#use_prev_ar_'+page+'_'+id).is(':checked')) {
                // get prev image 
                var prev_ar = $('#ar_coupon_name_' + page + '_' + (id - 1)).val();
                var prev_marker = $('#ar_marker_name_' + page + '_' + (id - 1)).val();

                $('#ar_coupon_name_' + page + '_' + id).val(prev_ar);
                $('#ar_marker_name_' + page + '_' + id).val(prev_marker);
                $('#ar_prev_' + page + '_' + id).attr('src', "{{url('resources/assets/media')}}/"+prev_ar);
                $('#coupon_ar_error_' + page + '_' + id).html('');
            } 
            else {
                $('#ar_coupon_name_' + page + '_' + id).val('');
                $('#ar_marker_name_' + page + '_' + id).val('');
                $('#ar_prev_' + page + '_' + id).attr('src', "{{url('resources/assets/custom/images/no-image.png')}}");
                $('#coupon_ar_error_' + page + '_' + id).html('This Field is required');
            }
        }
         


        // $('#coupon_photo_c_1').on('change', function(){
        //     readURL(this,1,'c');
        // });
    //    $('#coupon_photo_c_2').on('change', function(){
    //        readURL(this,2,'c');
    //    });
    //    $('#coupon_photo_c_3').on('change', function(){
    //        readURL(this,3,'c');
    //    });
    //    $('#coupon_photo_c_4').on('change', function(){
    //        readURL(this,4,'c');
    //    });

        $('#coupon_name_c_1').on('input', function(){
            var coupon_name = $('#coupon_name_c_1').val();
            $('#heading_c_1').html(coupon_name);
        });
        $('#coupon_name_c_2').on('input', function(){
            var coupon_name = $('#coupon_name_c_2').val();
            $('#heading_c_2').html(coupon_name);
        });
        $('#coupon_name_c_3').on('input', function(){
            var coupon_name = $('#coupon_name_c_3').val();
            $('#heading_c_3').html(coupon_name);
        });
        $('#coupon_name_c_4').on('input', function(){
            var coupon_name = $('#coupon_name_c_4').val();
            $('#heading_c_4').html(coupon_name);
        });

    //    $('#coupon_photo_e_1').on('change', function(){
    //        readURL(this,1,'e');
    //    });
    //    $('#coupon_photo_e_2').on('change', function(){
    //        readURL(this,2,'e');
    //    });
    //    $('#coupon_photo_e_3').on('change', function(){
    //        readURL(this,3,'e');
    //    });
    //    $('#coupon_photo_e_4').on('change', function(){
    //        readURL(this,4,'e');
    //    });

        $('#coupon_name_e_1').on('input', function(){
            var coupon_name = $('#coupon_name_c_4').val();
            $('#heading_e_1').html(coupon_name);
        });
        $('#coupon_name_e_2').on('input', function(){
            var coupon_name = $('#coupon_name_c_4').val();
            $('#heading_e_2').html(coupon_name);
        });
        $('#coupon_name_e_3').on('input', function(){
            var coupon_name = $('#coupon_name_c_4').val();
            $('#heading_e_3').html(coupon_name);
        });
        $('#coupon_name_e_4').on('input', function(){
            var coupon_name = $('#coupon_name_c_4').val();
            $('#heading_e_4').html(coupon_name);
        });

        $('#search_coupon').on('input', function(){
            var input = $('#search_coupon').val();

            if(input.length > 0) {
                $.get("{{ url('user/search_coupons') }}/"+input,function(data){
                    $('#search_result').html('');

                    for(var y = 0; y < data.length; y++){
                        var stores = data[y]['store_name'];
                        var store_list = '<ul>';
                        for(var x = 0; x < stores.length; x++){
                            store_list += '<li>'+stores[x]+"</li>";
                        }

                        store_list += '</ul>';

                        var row = '<tr><td>'+data[y]['coupon_title']+'</td><td>'+store_list+'</td><td>'+data[y]['promo_name']+'</td><td>'+data[y]['created_at']+'</td></tr>';

                        $('#search_result').append(row);
                    }

                });
            }


        });

        function edit_active_coupons(promo_id){
            $('a[aria-controls="tab-pane-4"]').trigger("click");

            $.get("{{ url('user/get_coupon_details') }}/"+parseInt(promo_id),function(data){

                for(var x = 0; x < data.length; x++) {

                    var y = data[x]['coupon_level'];

                    $('#promo_id_e_'+y).val(promo_id);
                    $('#promo_id_e_'+y).attr('readonly', true);
                    $('#coupon_id_e_'+y).val(data[x]['coupon_id']);
                    $('#coupon_name_e_'+y).val(data[x]['coupon_title']);
                    $('#coupon_info_e_'+y).val(data[x]['coupon_information']);
                    $('#coupon_availability_e_'+y).val(data[x]['coupon_availabilty']);
                    $('#coupon_condition_e_'+y).val(data[x]['terms_conditions']);
                    $('#coupon_value_e_'+y).val(data[x]['estimated_value']);
                    $('#ar_coupon_name_e_'+y).val(data[x]['coupon_model']);

                    $('#ar_prev_e_'+y).attr('src', "{{url('resources/assets/media')}}/"+data[x]['coupon_model']);
                    $('#image_e_'+y).attr('src', "{{url('resources/assets/coupons/full')}}/"+data[x]['coupon_photo']);
                    $('#coup_img_e_'+y).val(data[x]['coupon_photo']);
                    $('#ar_marker_name_e_'+y).val(data[x]['coupon_marker']);
                    $('#heading_e_'+y).html(data[x]['coupon_title']);

                    var is_loyalty = data[x]['is_loyalty'];
                    var loyalty_count = data[x]['loyalty_count'];
                    var min_spend = data[x]['min_spend'];

                    if(is_loyalty == 1){

                        if($('#loyalty_coupon_e_'+y).is(":checked")){
                            // $('#loyalty_coupon_e_1').parent().find(".switchery").trigger("click");
                        } else {
                            $('#loyalty_coupon_e_'+y).parent().find(".switchery").trigger("click");
                        }

                        $('#coupon_count_e_'+y).val(loyalty_count);
                        $('#lc_cont_e_'+y).show();

                        $('#min_spent_e_'+y).val(min_spend);
                    } else {
                        if($('#loyalty_coupon_e_'+y).is(":checked")){
                            $('#loyalty_coupon_e_1').parent().find(".switchery").trigger("click");
                        }
                    }

                    $('#min_lbl_e_1').html(data[x]['cur_lable']);
                    $('#curr_lbl_e_1').html(data[x]['cur_lable']);
                    $('#curr_lbl_e_2').html(data[x]['cur_lable']);
                    $('#curr_lbl_e_3').html(data[x]['cur_lable']);
                    $('#curr_lbl_e_4').html(data[x]['cur_lable']);


                }

            });

        }

        function get_curr_lable(page, id) {

            // get promo id
            var promo_id = $('#promo_id_'+page+'_'+id).val();

            $.get("{{ url('user/get_curr_lable') }}/"+parseInt(promo_id),function(data){

                if(data.length > 0) {
                    $('#curr_lbl_'+page+'_1').html(data);
                    $('#curr_lbl_'+page+'_2').html(data);
                    $('#curr_lbl_'+page+'_3').html(data);
                    $('#curr_lbl_'+page+'_4').html(data);

                    $('#min_lbl_'+page+'_1').html(data);
                }
//                alert(data);
            });

        }

    </script>
    <script>

        function validate_input(page, id){

            var err_1 = "This Field is required";

            var promo_selected = 0;
            if(id == 1) {
                var promo = $('#promo_id_' + page + '_' + id).val();

                if(promo > 0 ) {
                    promo_selected = 1;
                    $('#promo_id_error_' + page + '_' + id).html('');
                } else {
                    $('#promo_id_error_' + page + '_' + id).html(err_1);
                }
            } else {
                promo_selected = 1;
            }

            var coup_img_selected = 0;
            if(page == 'c') {

                var new_img = $('#cp_img_name_'+ page + '_' + id).val();

                if(new_img.length > 0) {
                    coup_img_selected = 1;
                } else {
                    crop_image(page, id);
                    coup_img_selected = 1;
                    // $('#coupon_photo_error_' + page + '_' + id).html(err_1);
                }

                // var coupon_img = $('#coupon_photo_' + page + '_' + id).val();
                // if ( $('input[name="use_prev_c_2"]').is(':checked') ) {
                //     alert("checked");
                // } else {
                //     alert('not checked');
                // }

                if($('#use_prev_'+page+'_'+id).is(':checked')) {
                    $('#coupon_photo_error_' + page + '_' + id).html('');
                } 
                else {
                    if (coupon_img) {
                        $('#store_image_error_' + id).html('');
                        switch (coupon_img.substring(coupon_img.lastIndexOf('.') + 1).toLowerCase()) {
                            case 'jpg':
                            case 'png':
                                $('#coupon_photo_error_' + page + '_' + id).html('');
    //                            coup_img_selected = 1;
                                break;
                            default:
                                $('#coupon_photo_error_' + page + '_' + id).html("Please select a png or jpg");
                                break;

                        }
                    } else {
                        $('#coupon_photo_error_' + page + '_' + id).html(err_1);
                    }
                }

                
                
            } else if(page == 'e') {

                var new_img = $('#cp_img_name_'+ page + '_' + id).val();

                if(new_img.length > 0) {
                    coup_img_selected = 1;
                } else {

                    crop_image(page, id);
                    coup_img_selected = 1;

                    var coupon_img = $('#coup_img_'+ page + '_' + id).val();

                    if(coupon_img.length > 0) {
                        coup_img_selected = 1;

                    }
                }


            }


            var coupon_name = $('#coupon_name_' + page + '_' + id).val();

            if(coupon_name.length > 0 ) {
                $('#coupon_name_error_' + page + '_' + id).html('');
            } else {
                $('#coupon_name_error_' + page + '_' + id).html(err_1);
            }

            var coupon_info = $('#coupon_info_' + page + '_' + id).val();

            if(coupon_info.length > 0 ) {
                $('#coupon_info_error_' + page + '_' + id).html('');
            } else {
                $('#coupon_info_error_' + page + '_' + id).html(err_1);
            }

            // var coupon_desc = $('#coupon_condition_' + page + '_' + id).val();

            // if(coupon_desc.length > 0 ) {
            //     $('#coupon_desc_error_' + page + '_' + id).html('');
            // } else {
            //     $('#coupon_desc_error_' + page + '_' + id).html(err_1);
            // }

            var coupon_ar = $('#ar_coupon_name_' + page + '_' + id).val();

            if(coupon_ar.length > 0 ) {
                $('#coupon_ar_error_' + page + '_' + id).html('');
            } else {
                $('#coupon_ar_error_' + page + '_' + id).html(err_1);
            }

            var coupon_marker = $('#ar_marker_name_' + page + '_' + id).val();
            if(coupon_marker.length > 0 ) {
                $('#coupon_ar_error_' + page + '_' + id).html('');
            } else {
                $('#coupon_ar_error_' + page + '_' + id).html("please select ar coupon again");
            }


            if( (promo_selected == 1) && (coup_img_selected == 1) && (coupon_name.length > 0 ) && (coupon_info.length > 0 ) && (coupon_ar.length > 0 ) && (coupon_marker.length > 0 )) {
                return 1;
            } else {
                return 0;
            }


        }

        function validate_coupon_1(page, id, next_tab) {
            var valid = validate_input(page, id);

            if(valid == 1) {

                if(page == 'e'){
                    validate_coupon_form('e',2,0);
                }
                else if(next_tab == 'cpn_l_5' ) {
                    validate_coupon_form('c',1,1);
                } 
                else if(next_tab == 'cpn_e_5') {
                    validate_coupon_form('e',2,0);
                }
                else {
                    nextTab(next_tab);
                }
                
            } else {
                alert("Please Fill the missing data..");
            }
        }

        function validate_coupon_form(page, id, btn) {
            if(page == 'c') {
                if(btn == 1){
                    $('#submit_type_' + page).val(1);
                }else {
                    $('#submit_type_' + page).val(0);
                }

            }

            var c_1 = validate_input(page, 1);
            var c_2 = validate_input(page, 2);
            var c_3 = validate_input(page, 3);
            var c_4 = validate_input(page, 4);

            if( (c_1 == 1) && (c_2 == 1) && (c_3 == 1) && (c_4 == 1) ) {
                $('#coupon_form_' + id).submit();
            } else {
                alert("Please Fill the missing data..");
            }
        }

        function error_hide(field_id) {
            $('#'+ field_id).html('');
        }
    </script>

@endsection
