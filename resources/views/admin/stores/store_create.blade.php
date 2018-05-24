@extends('layouts.admin')

@section('content')
    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/admin/stores/save') }}">
        {{ csrf_field() }}

        <div class="col-md-12">

            <ul>
                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach
            </ul>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">

                        <div class="form-group col-sm-12 {{ $errors->has('userid') ? ' has-error' : '' }}">
                            <label for="userid">User</label>
                            <select class="form-control" required="required" id="userid" name="userid">
                                <option value="">-- Select a Admin User -- </option>
                                @foreach($users as $key => $user)
                                    <option value="{{ $user->id }}" @if(old('userid') == $user->id) selected="selected" @endif >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('userid'))
                                <span class="help-block"><strong>{{ $errors->first('userid') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group col-sm-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Store Name</label>
                            <input type="text" class="form-control" required="required" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                            @if ($errors->has('name'))
                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group col-sm-12 {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" style="width: 100%;">Start Typing Full Address</label>
                            <input type="text" class="form-control" id="address" name="address" onblur="GetValue()" value="{{ old('address') }}" placeholder="Start Typing">
                        </div>

                        <div class="form-group col-sm-12 ">
                            <label for="address" style="width: 100%;">Can't find your Address ?</label>
                            <input type="checkbox" name="manually" onchange="ChangeAutofill()" value="0" /> Input Manually
                        </div>


                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="full_address" style="display: block;">
                            <div class="form-group col-sm-12 {{ $errors->has('street_number') ? ' has-error' : '' }}">
                                <label for="street_number">Store Address</label>
                                <input type="text" class="form-control" id="street_number" name="street_number" value="{{ old('street_number') }}" placeholder="Street Number">

                            </div>
                            <div class="form-group col-sm-12 {{ $errors->has('address') ? ' has-error' : '' }}">
                                <!-- <label for="address">Street Address</label> -->
                                <input type="text" class="form-control" id="address_address" name="address_address" onblur="GetValue()" value="{{ old('address_address') }}" placeholder="Street Address">

                            </div>
                            <div class="form-group col-sm-12 {{ $errors->has('city') ? ' has-error' : '' }}">
                                <!-- <label for="city">City</label> -->
                                <input type="text" class="form-control" id="city" name="city" onblur="GetValue()" value="{{ old('city') }}" placeholder="City">
                                @if ($errors->has('city'))
                                    <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group col-sm-12 {{ $errors->has('zip_code') ? ' has-error' : '' }}">
                                <!-- <label for="zip_code">Postal / Zip Code</label> -->
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="Postal / Zip Code">
                                @if ($errors->has('zip_code'))
                                    <span class="help-block"><strong>{{ $errors->first('zip_code') }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group col-sm-12 {{ $errors->has('state') ? ' has-error' : '' }}">
                                <!-- <label for="state">State</label> -->
                                <input type="text" class="form-control" id="state" name="state" onblur="GetValue()" value="{{ old('state') }}" placeholder="State">
                                @if ($errors->has('state'))
                                    <span class="help-block"><strong>{{ $errors->first('state') }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group col-sm-12 {{ $errors->has('country') ? ' has-error' : '' }}">
                                <!-- <label for="country">Country</label> -->
                                <input type="text" class="form-control" id="country" name="country" onblur="GetValue()" value="{{ old('country') }}" placeholder="Country">
                                @if ($errors->has('country'))
                                    <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                                @endif
                            </div>


                            <input type="hidden" id="country_short" name="country_short" required>

                        </div>

                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <hr>
                        <div class="form-group col-sm-12 {{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category">Category</label>
                            <div class="clearfix"></div>
                            @foreach($categories as $key => $category)
                                <div class="col-sm-6" style="margin-bottom:10px;"><label><input type="checkbox" value="{{ $category->id }}" id="category" name="category[]"> {{ $category->category }}</label></div>
                            @endforeach
                            <div class="clearfix"></div>
                            @if ($errors->has('category'))
                                <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <hr>
                        <div class="form-group col-sm-12">
                            <label for="store_description">Store Description</label>
                            <textarea class="form-control" name="store_description" id="store_description" rows="" cols=""></textarea>
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group col-sm-12">
                            <div class="form-group col-sm-12">
                                <img src="" style="height: 250px;width:250px;" id="qr_code_prev_1">
                                <input type="hidden" name="promo_qr_code" id="promo_qr_code_1" >
                                <input type="hidden" name="promo_qr_image" id="promo_qr_image_1" >
                            </div>



                            <button type="button" class="btn btn-primary btn-lg col-sm-12 col-md-12 col-lg-12" onclick="generate_qr_code(1);" id="crt_qr_1">Create Coupon Code</button>

                            <button type="button" class="btn btn-primary btn-lgcol-sm-12 col-md-12 col-lg-12" style="margin:2px;" onclick="view_qr_code(1);" id="print_code_1">View Coupon Code</button>

                            <button type="button" class="btn btn-primary btn-lg  col-sm-12 col-md-12 col-lg-12" style="margin:2px;" onclick="refresh_qr(1);" id="refresh_qr_1">Refresh Coupon Code</button>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Store Image</label>
                                    <input type="file" id="store_image_1" name="store_image" class="dropify" data-height="100" required/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Store AR Model</label>
                                    <input type="file" id="store_ar_1" name="store_ar" class="dropify" data-height="100"  required/>
                                    <!-- <small class="form-control-feedback text-center">Please upload only pngs </small> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group col-sm-12">
                    <h3>Store Location</h3>
                    <small>Drag map pointer to accurate position (If required)</small>
                </div>

                <div class="form-group col-sm-12">
                    <div class="map" id="map" style="width: 100%; height: 300px;"></div>
                </div>
                <span style="display: none;">
          <div class="form-group col-sm-6">
              <input type="text" class="form-control" style="margin-bottom: 10px;" id="ar_model_lat" name="ar_model_lat" value="{{ old('ar_model_lat') }}" placeholder="Lat">
          </div>

          <div class="form-group col-sm-6">
              <input type="text" class="form-control" style="margin-bottom: 10px;" id="ar_model_long" name="ar_model_long" value="{{ old('ar_model_long') }}" placeholder="Long">
          </div>
      	</span>


            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
        </div>




    </form>
@endsection
@section('custom_js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQOQYd6y3PeucI2ajI2hXzcPTXVwlGfgs&sensor=false&libraries=places"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#crt_qr_1').show();
            $('#print_code_1').hide();
            $('#refresh_qr_1').hide();

        });

        function generate_qr_code(id) {

            $('#crt_qr_'+id).hide();

            $.get("{{ url('admin/generate_new_qr') }}",function(data){
                // console.log(data);
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

        function view_qr_code(id) {
            var src = $('#qr_code_prev_' + id).attr('src');
            window.open(src);
            // alert(src);
        }

        // ChangeAutofill();
        function ChangeAutofill(){
            if($('input[name="manually"]').prop("checked") == true){
                $('.full_address').css("display","block");
            }else{
                $('.full_address').css("display","none");
            }
        }

        function GetValue(){
            var address = "";
            if($('#address').val() != ""){
                address += $('#address').val()+" ,";
            }

            if($('#city').val() != ""){
                address += $('#city').val()+" ,";
            }

            if($('#state').val() != ""){
                address += $('#state').val()+" ,";
            }

            if($('#country').val() != ""){
                address += $('#country').val();
            }

            $('#searchInput').val(address);
        }



        //  AIzaSyAl3zrH7Mj0Q09VaPgKSk97YTFuzlnk82o

        function initialize() {

            var latlng = new google.maps.LatLng(37.8271784,-122.2913078);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: latlng,
                zoom: 13
            });
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29)
            });
            var input = document.getElementById('address');
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
                //document.getElementById('address').removeAttribute("style");
                //document.getElementById('city').value = JSON.stringify(place);
                bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng(),place);
                infowindow.setContent(place.formatted_address);
                infowindow.open(map, marker);

            });
            // this function will work on marker move event into map
            google.maps.event.addListener(marker, 'dragend', function() {
                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            //document.getElementById('city').value = JSON.stringify(results);
                            //document.getElementById('state').value = results[0].address_components[0].short_name;
                            console.log(results[0]);


                            bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng(),results[0]);
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });
            });
        }
        function bindDataToForm(address,lat,lng,vars){
            document.getElementById('ar_model_lat').value = lat;
            document.getElementById('ar_model_long').value = lng;
//alert((vars.address_components).length);

            var xadd = document.getElementById('address').value;

            for(var i = 0; i < (vars.address_components).length; ++i){
                if(vars.address_components[i]['types'].includes('country')) {
                    document.getElementById('country').value = vars.address_components[i]['long_name'];
                    document.getElementById('country_short').value = vars.address_components[i]['short_name'];
                    xadd = xadd.replace(", "+vars.address_components[i]['long_name'], "");
                }

                if(vars.address_components[i]['types'].includes('administrative_area_level_1')){
                    document.getElementById('state').value = vars.address_components[i]['long_name'];
                    xadd = xadd.replace(", "+vars.address_components[i]['long_name'], "");
                }

                if(vars.address_components[i]['types'].includes('administrative_area_level_2')){
                    document.getElementById('city').value = vars.address_components[i]['long_name'];
                    xadd = xadd.replace(", "+vars.address_components[i]['long_name'], "");
                }

                if(vars.address_components[i]['types'].includes('postal_code')){
                    document.getElementById('zip_code').value = vars.address_components[i]['long_name'];
                    // xadd = xadd.replace(vars.address_components[i]['long_name'], "");
                }

                if(vars.address_components[i]['types'].includes('street_number')){
                    document.getElementById('street_number').value = vars.address_components[i]['long_name'];
                    // xadd = xadd.replace(vars.address_components[i]['long_name'], "");
                }

                if(vars.address_components[i]['types'].includes('route')){
                    document.getElementById('address_address').value = vars.address_components[i]['long_name'];
                    // xadd = xadd.replace(vars.address_components[i]['long_name'], "");
                }

            }



            $('#address').val(xadd);

        }

        google.maps.event.addDomListener(window, 'load', initialize);


    </script>

@endsection
