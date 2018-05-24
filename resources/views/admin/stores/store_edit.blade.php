@extends('layouts.admin')
@section('content')
<form role="form" method="POST" action="{{ url('/admin/stores/update') }}">
    {{ csrf_field() }}
    <input type="hidden" name="formid" value="{{ $store->place_id }}" />
    <div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name">Store Name</label>
        <input type="text" class="form-control" required="required" id="name" name="name" value="{{ old('name',$store->contact_name) }}" placeholder="Enter Name">
        @if ($errors->has('name'))
        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('userid') ? ' has-error' : '' }}">
        <label for="userid">User</label>
        <select class="form-control" required="required" id="userid" name="userid">
            @foreach($users as $key => $user)
                <option value="{{ $user->id }}" @if(old('userid',$store->user_id) == $user->id) selected="selected" @endif>{{ $user->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('userid'))
        <span class="help-block"><strong>{{ $errors->first('userid') }}</strong></span>
        @endif
    </div>
    
    
    
    <div class="form-group col-sm-6 {{ $errors->has('email') ? ' has-error' : '' }}" style="display:none;">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" value="{{ old('email',$store->email) }}">
        @if ($errors->has('email'))
        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>
    
    
    <div class="form-group col-sm-6 {{ $errors->has('contact') ? ' has-error' : '' }}" style="display:none;">
        <label for="contact">Contact</label>
        <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact',$store->contact) }}">
        @if ($errors->has('contact'))
        <span class="help-block"><strong>{{ $errors->first('contact') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label for="address" style="width: 100%;">Start Typing Full Address</label>
        <input type="text" class="form-control" id="address" name="address" onblur="GetValue()" value="{{ old('address') }}" placeholder="Start Typing">

    </div>
	<div class="form-group col-sm-6 ">
		<label for="address" style="width: 100%;">Can't find your Address ?</label>
		<input type="checkbox" name="manually" onchange="ChangeAutofill()" value="0" /> Input Manually
	</div>
	<div class="clearfix"></div>
	<div class="full_address">
    <div class="form-group col-sm-6 {{ $errors->has('street_number') ? ' has-error' : '' }}">
        <label for="street_number">Street Address</label>
        <input type="text" class="form-control" id="street_number" name="street_number" value="{{ old('street_number',$store->street_number) }}" placeholder="Street Address">
        @if ($errors->has('address'))
        <span class="help-block"><strong>{{ $errors->first('street_number') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('address_address') ? ' has-error' : '' }}">
        <label for="address_address">Street Address</label>
        <input type="text" class="form-control" id="address_address" name="address_address" value="{{ old('address_address',$store->street_address) }}" placeholder="Street Address">
        @if ($errors->has('address_address'))
        <span class="help-block"><strong>{{ $errors->first('address_address') }}</strong></span>
        @endif
    </div>
    
     <div class="form-group col-sm-6 {{ $errors->has('city') ? ' has-error' : '' }}">
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" name="city" value="{{ old('city',$store->city) }}" placeholder="City">
        @if ($errors->has('city'))
        <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('zip_code') ? ' has-error' : '' }}">
        <label for="zip_code">Postal / Zip Code</label>
        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code',$store->postal_code) }}" placeholder="Postal / Zip Code">
        @if ($errors->has('zip_code'))
        <span class="help-block"><strong>{{ $errors->first('zip_code') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('state') ? ' has-error' : '' }}">
        <label for="state">State</label>
        <input type="text" class="form-control" id="state" name="state" value="{{ old('state',$store->state) }}" placeholder="State">
        @if ($errors->has('state'))
        <span class="help-block"><strong>{{ $errors->first('state') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('country') ? ' has-error' : '' }}">
        <label for="country">Country</label>
        <input type="text" class="form-control" id="country" name="country" value="{{ old('country',$store->country) }}" placeholder="Country">
        @if ($errors->has('country'))
        <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
        @endif
    </div>
    </div>
	<div class="form-group col-sm-12 {{ $errors->has('category') ? ' has-error' : '' }}">
        <label for="category">Category</label>
		<div class="clearfix"></div>
		<?PHP 
			if($store->place_id != ""){
				$cat = json_decode($store->under_category); 
			}else{
				$cat = [];
			}
			
		?>
		
            @foreach($categories as $key => $category)
				<?PHP if(in_array($category->id, $cat) == true){ ?>
                <div class="col-sm-2" style="margin-bottom:10px;"><label><input type="checkbox" value="{{ $category->id }}" checked="checked" id="category" name="category[]"> {{ $category->category }}</label></div>
				<?PHP }else{ ?>
				<div class="col-sm-2" style="margin-bottom:10px;"><label><input type="checkbox" value="{{ $category->id }}" id="category" name="category[]"> {{ $category->category }}</label></div>
				<?PHP } ?>
			@endforeach
		<div class="clearfix"></div>
        @if ($errors->has('category'))
        <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
        @endif
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-sm-12">
        <label for="ar_model">Location of Store</label>
    </div>
    <div class="form-group col-sm-12">
        <div class="map" id="map" style="width: 100%; height: 300px;"></div>
    </div>
    <div class="form-group col-sm-6" style="display: none;">
        <input type="text" class="form-control" style="margin-bottom: 10px;" id="ar_model_lat" name="ar_model_lat" value="{{ old('ar_model_lat',$store->latitude) }}" placeholder="AR Location Lat">
    </div>
    <div class="form-group col-sm-6" style="display: none;">
        <input type="text" class="form-control" style="margin-bottom: 10px;" id="ar_model_long" name="ar_model_long" value="{{ old('ar_model_long',$store->longitude) }}" placeholder="AR Location Long">
    </div>

    <div class="form-group col-sm-6">
        <label for="active">Store Status</label>
        <select class="form-control" id="active" name="active">
            <option value="1" @if(old('active',$store->status) == '1') selected="selected" @endif>Active</option>
            <option value="0" @if(old('active',$store->status) == '0') selected="selected" @endif>Close</option>
        </select>
    </div>
    
    <div class="form-group col-sm-12">
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div>

</form>
@endsection

@section('custom_js')

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQOQYd6y3PeucI2ajI2hXzcPTXVwlGfgs&sensor=false&libraries=places"></script>
<script type="text/javascript">

    
    //  AIzaSyAl3zrH7Mj0Q09VaPgKSk97YTFuzlnk82o  
    
    function initialize() {
        @if($store->latitude == "" && $store->longitude == "")
            var latlng = new google.maps.LatLng(37.8271784,-122.2913078);
        @else
            var latlng = new google.maps.LatLng({{ $store->latitude }},{{ $store->longitude }});
        @endif

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