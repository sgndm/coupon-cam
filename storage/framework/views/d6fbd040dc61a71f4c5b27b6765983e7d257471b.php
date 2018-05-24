<?php $__env->startSection('content'); ?>
<div class="col-md-12">

    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

            <li><?php echo e($error); ?></li>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </ul>
</div>
<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/admin/red_promos/save')); ?>">
    <?php echo e(csrf_field()); ?>

    <div class="col-sm-12 col-md-12 col-lg-6">
      <div class="form-group col-sm-12">
          <label for="name">Promo Name</label>
          <input type="text" class="form-control" id="promo_name" name="promo_name" value="" placeholder="Enter Name" required>
      </div>
      <div class="form-group col-sm-12">
          <label for="name">Promo Date</label>
          <input type="date" class="form-control" id="start_date" name="start_date" value=""  required>
      </div>

      <div class="form-group col-sm-12">
          <label for="promo_start">Start Time <small class="info-box-title">( in hours & mins )</small></label>
          <input type="text" class="form-control time-picker" id="promo_start" name="promo_start" value="" required>
      </div>
      <div class="form-group col-sm-12">
          <label for="promo_lenght">Promo Lenght <small class="info-box-title">( in hours )</small></label>
           <select class="form-control" id="promo_lenght" name="promo_lenght" required>
              <?php for($n = 1; $n <= 24; $n++): ?>
              <option value="<?php echo e($n); ?>"> <?php echo e($n); ?></option>
              <?php endfor; ?>
          </select>
      </div>

      <div class="form-group col-sm-12">
        <label for="red_photo">Promo Photo</label>
        <input type="file" name="red_photo" id="red_photo"  required>
      </div>

      <div class="form-group col-sm-12">
        <label for="red_photo">Promo AR Model</label>
        <input type="file" name="red_promo_model" id="red_promo_model"  required>
      </div>


      <div class="form-group col-sm-6 ">
    		<label for="" style="width: 100%;">Special Promo</label>
    		<input type="checkbox" name="give_away" value="0" /> is give away promo?
        <!-- <label for="" style="width: 100%;"> <small>If u Check this users wont see this promo in near by promo list ()</small> </label> -->
    	</div>

    </div>

    <div class="col-sm-12 col-md-12 col-lg-6">
      <div class="form-group col-sm-12">
        <label class="control-label">Store Address</label>
        <input type="text" id="store_address_1" name="store_address" class="form-control" placeholder="Start Typing Full Address..."  required>
        <input type="hidden" name="promo_lat" id="promo_lat"  required>
        <input type="hidden" name="promo_lng" id="promo_lng"  required>
        <input type="hidden" name="promo_country" id="promo_country"  required>
      </div>

      <div class="form-group col-sm-12">
        <div id="map" style="height: 250px;" ></div>
      </div>

      <div class="form-group col-sm-12">
          <input type="hidden" name="totalchecked" value="0">
          <button type="submit" class="btn btn-primary pull-right">Submit</button>
      </div>
    </div>


</form>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQOQYd6y3PeucI2ajI2hXzcPTXVwlGfgs&sensor=false&libraries=places"></script>
<script type="text/javascript">

  $(document).ready(function() {
    initialize();
  });

    function initialize() {
        lat = 37.8271784;
        lng = -122.2913078;

        var latlng = new google.maps.LatLng(lat, lng);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 15
        });
        var infowindow;
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });
        var input = document.getElementById('store_address_1');
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var geocoder = new google.maps.Geocoder();
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.addListener('place_changed', function () {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            // console.log(place);
            var loc_add = place.formatted_address;
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            var addComp = place.address_components;
            // console.log(addComp);
            var country_short;

            for (var i = 0; i < addComp.length; i++) {
              if(addComp[i]['types'].includes('country')){
                country_short = addComp[i]['short_name'];
                //alert(country_short);
              }
            }

            // $('#promo_country').val(country_short);
            document.getElementById('promo_country').value = country_short;

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            document.getElementById('promo_lat').value = place.geometry.location.lat();
            document.getElementById('promo_lng').value = place.geometry.location.lng();
            //bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng(), place);
            var promo_name = document.getElementById('promo_name').value;
            infowindow.setContent(loc_add);
            infowindow.open(map, marker);
            document.getElementById('store_address_1').value = loc_add;

        });
        // this function will work on marker move event into map
        google.maps.event.addListener(marker, 'dragend', function () {
            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {

                    if (results[0]) {
                        console.log(results[0]);
                        var addComp = results[0].address_components;

                        var country_short;

                        for (var i = 0; i < addComp.length; i++) {
                          if(addComp[i]['types'].includes('country')){
                            country_short = addComp[i]['short_name'];
                            // alert(country_short);
                          }
                        }

                        // $('#promo_country').val(country_short);
                        document.getElementById('promo_country').value = country_short;

                        document.getElementById('promo_lat').value = marker.getPosition().lat();
                        document.getElementById('promo_lng').value = marker.getPosition().lng();
                        var promo_name = document.getElementById('promo_name').value;

                        var loc_addr = results[0].formatted_address;
                        infowindow.setContent(loc_addr);
                        infowindow.open(map, marker);
                        document.getElementById('store_address_1').value = loc_addr;
                    }
                }
            });
        });
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>