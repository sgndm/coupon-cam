<?php $__env->startSection('content'); ?>
<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/admin/stores/save')); ?>">
    <?php echo e(csrf_field()); ?>


    <div class="col-md-12">

        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                <li><?php echo e($error); ?></li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </ul>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-6">

        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6">

            <div class="form-group col-sm-12 <?php echo e($errors->has('userid') ? ' has-error' : ''); ?>">
                <label for="userid">User</label>
                <select class="form-control" required="required" id="userid" name="userid">
                    <option value="">-- Select a Admin User -- </option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php if(old('userid') == $user->id): ?> selected="selected" <?php endif; ?> ><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
                <?php if($errors->has('userid')): ?>
                <span class="help-block"><strong><?php echo e($errors->first('userid')); ?></strong></span>
                <?php endif; ?>
            </div>

            <div class="form-group col-sm-12 <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                <label for="name">Store Name</label>
                <input type="text" class="form-control" required="required" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Name">
                <?php if($errors->has('name')): ?>
                <span class="help-block"><strong><?php echo e($errors->first('name')); ?></strong></span>
                <?php endif; ?>
            </div>

            <div class="form-group col-sm-12 <?php echo e($errors->has('address') ? ' has-error' : ''); ?>">
              <label for="address" style="width: 100%;">Start Typing Full Address</label>
              <input type="text" class="form-control" id="address" name="address" onblur="GetValue()" value="<?php echo e(old('address')); ?>" placeholder="Start Typing">
            </div>

            <div class="form-group col-sm-12 ">
          		<label for="address" style="width: 100%;">Can't find your Address ?</label>
          		<input type="checkbox" name="manually" onchange="ChangeAutofill()" value="0" /> Input Manually
          	</div>


          </div>
          <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="full_address" style="display: block;">
              <div class="form-group col-sm-12 <?php echo e($errors->has('street_number') ? ' has-error' : ''); ?>">
                  <label for="street_number">Store Address</label>
                  <input type="text" class="form-control" id="street_number" name="street_number" value="<?php echo e(old('street_number')); ?>" placeholder="Street Number">

              </div>
              <div class="form-group col-sm-12 <?php echo e($errors->has('address') ? ' has-error' : ''); ?>">
                  <!-- <label for="address">Street Address</label> -->
                  <input type="text" class="form-control" id="address_address" name="address_address" onblur="GetValue()" value="<?php echo e(old('address_address')); ?>" placeholder="Street Address">

              </div>
              <div class="form-group col-sm-12 <?php echo e($errors->has('city') ? ' has-error' : ''); ?>">
                  <!-- <label for="city">City</label> -->
                  <input type="text" class="form-control" id="city" name="city" onblur="GetValue()" value="<?php echo e(old('city')); ?>" placeholder="City">
                  <?php if($errors->has('city')): ?>
                  <span class="help-block"><strong><?php echo e($errors->first('city')); ?></strong></span>
                  <?php endif; ?>
              </div>
              <div class="form-group col-sm-12 <?php echo e($errors->has('zip_code') ? ' has-error' : ''); ?>">
                  <!-- <label for="zip_code">Postal / Zip Code</label> -->
                  <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo e(old('zip_code')); ?>" placeholder="Postal / Zip Code">
                  <?php if($errors->has('zip_code')): ?>
                  <span class="help-block"><strong><?php echo e($errors->first('zip_code')); ?></strong></span>
                  <?php endif; ?>
              </div>
              <div class="form-group col-sm-12 <?php echo e($errors->has('state') ? ' has-error' : ''); ?>">
                  <!-- <label for="state">State</label> -->
                  <input type="text" class="form-control" id="state" name="state" onblur="GetValue()" value="<?php echo e(old('state')); ?>" placeholder="State">
                  <?php if($errors->has('state')): ?>
                  <span class="help-block"><strong><?php echo e($errors->first('state')); ?></strong></span>
                  <?php endif; ?>
              </div>
              <div class="form-group col-sm-12 <?php echo e($errors->has('country') ? ' has-error' : ''); ?>">
                  <!-- <label for="country">Country</label> -->
                  <input type="text" class="form-control" id="country" name="country" onblur="GetValue()" value="<?php echo e(old('country')); ?>" placeholder="Country">
                  <?php if($errors->has('country')): ?>
                  <span class="help-block"><strong><?php echo e($errors->first('country')); ?></strong></span>
                  <?php endif; ?>
              </div>


              <input type="hidden" id="country_short" name="country_short" required>

          	</div>

          </div>
          <div class="col-sm-12 col-md-12 col-lg-12">
            <hr>
            <div class="form-group col-sm-12 <?php echo e($errors->has('category') ? ' has-error' : ''); ?>">
                  <label for="category">Category</label>
          		<div class="clearfix"></div>
                      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                          <div class="col-sm-6" style="margin-bottom:10px;"><label><input type="checkbox" value="<?php echo e($category->id); ?>" id="category" name="category[]"> <?php echo e($category->category); ?></label></div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
          		<div class="clearfix"></div>
                  <?php if($errors->has('category')): ?>
                  <span class="help-block"><strong><?php echo e($errors->first('category')); ?></strong></span>
                  <?php endif; ?>
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
              <input type="text" class="form-control" style="margin-bottom: 10px;" id="ar_model_lat" name="ar_model_lat" value="<?php echo e(old('ar_model_lat')); ?>" placeholder="Lat">
          </div>

          <div class="form-group col-sm-6">
              <input type="text" class="form-control" style="margin-bottom: 10px;" id="ar_model_long" name="ar_model_long" value="<?php echo e(old('ar_model_long')); ?>" placeholder="Long">
          </div>
      	</span>


      </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
      <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div>




</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_js'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQOQYd6y3PeucI2ajI2hXzcPTXVwlGfgs&sensor=false&libraries=places"></script>
<script type="text/javascript">

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>