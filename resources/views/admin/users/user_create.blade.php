@extends('layouts.admin')
@section('content')
<form role="form" method="POST" action="{{ url('/admin/users/save') }}">
    {{ csrf_field() }}
    <div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name">Company Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name">
        @if ($errors->has('name'))
        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
        @if ($errors->has('email'))
        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('contact_details') ? ' has-error' : '' }}">
        <label for="contact_details">Phone Number</label>
        <input type="text" class="form-control" id="contact_details" name="contact_details" value="{{ old('contact_details') }}" placeholder="Phone Number">
        @if ($errors->has('contact_details'))
        <span class="help-block"><strong>{{ $errors->first('contact_details') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('usertype') ? ' has-error' : '' }}">
        <label for="usertype">User Type</label>
        <select class="form-control" id="usertype" name="usertype">
            <option value="1" @if(old('usertype') == 1) selected="selected" @endif>User</option>
            <option value="0" @if(old('usertype') == 0) selected="selected" @endif>Administrator</option>            
        </select>
        @if ($errors->has('usertype'))
        <span class="help-block"><strong>{{ $errors->first('usertype') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label for="address">Street Address</label>
        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Street Address">
        @if ($errors->has('address'))
        <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
        @endif
    </div>
	<div class="form-group col-sm-6 ">
		<label for="address" style="width: 100%;">Can't find your Address ?</label>
		<input type="checkbox" name="manually" onchange="ChangeAutofill()" value="0" /> Input Manually
	</div>
    <div class="clearfix"></div>
	<div class="full_address"> 
	<div class="form-group col-sm-6 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label for="address">Street Address</label>
        <input type="text" class="form-control" id="address_address" name="address_address" value="{{ old('address_address') }}" placeholder="Street Address">
        @if ($errors->has('address'))
        <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('city') ? ' has-error' : '' }}">
	
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="City">
        @if ($errors->has('city'))
        <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('zip_code') ? ' has-error' : '' }}">
        <label for="zip_code">Postal / Zip Code</label>
        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="Postal / Zip Code">
        @if ($errors->has('zip_code'))
        <span class="help-block"><strong>{{ $errors->first('zip_code') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('state') ? ' has-error' : '' }}">
        <label for="state">State</label>
        <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" placeholder="State">
        @if ($errors->has('state'))
        <span class="help-block"><strong>{{ $errors->first('state') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('country') ? ' has-error' : '' }}">
        <label for="country">Country</label>
        <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" placeholder="Country">
        @if ($errors->has('country'))
        <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
        @endif
    </div>
    </div>
    
    <div class="form-group col-sm-6 {{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        @if ($errors->has('password'))
        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password">
        @if ($errors->has('password_confirmation'))
        <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
        @endif
		<div class="map" id="map" style="width: 100%; height: 300px; display: none;"></div>
    </div>
    <div class="form-group col-sm-12">
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div>

</form>
@endsection

@section('custom_js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQOQYd6y3PeucI2ajI2hXzcPTXVwlGfgs&sensor=false&libraries=places"></script>
<script type="text/javascript">
ChangeAutofill();
	function ChangeAutofill(){
		if($('input[name="manually"]').prop("checked") == true){
			$('.full_address').css("display","block");
		}else{
			$('.full_address').css("display","none");
		}
	}
    
	
	   //  AIzaSyAl3zrH7Mj0Q09VaPgKSk97YTFuzlnk82o  
    
    function initialize() {
        
   var latlng = new google.maps.LatLng(37.8271784,-122.2913078);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 18
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

        bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng(),place);
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
       
    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          if (results[0]) {        
              bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng(),results[0].address_components[0].short_name,results[0]);
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

    var xadd = document.getElementById('address').value;
    
   for(var i = 0; i < (vars.address_components).length; ++i){
       if(vars.address_components[i]['types'][0] === 'country'){
          document.getElementById('country').value = vars.address_components[i]['long_name'];
          xadd = xadd.replace(", "+vars.address_components[i]['long_name'], "");
      }
        
       if(vars.address_components[i]['types'][0] === 'administrative_area_level_1'){
          document.getElementById('state').value = vars.address_components[i]['long_name']; 
          xadd = xadd.replace(", "+vars.address_components[i]['long_name'], "");
      }
        
       if(vars.address_components[i]['types'][0] === 'administrative_area_level_2'){
          document.getElementById('city').value = vars.address_components[i]['long_name']; 
          xadd = xadd.replace(", "+vars.address_components[i]['long_name'], "");
      }
        
       if(vars.address_components[i]['types'][0] === 'postal_code'){
          document.getElementById('zip_code').value = vars.address_components[i]['long_name']; 
         // xadd = xadd.replace(vars.address_components[i]['long_name'], "");
      }
    }
    
    
        
    $('#address').val(xadd);
    
}   

google.maps.event.addDomListener(window, 'load', initialize);

</script>
@endsection