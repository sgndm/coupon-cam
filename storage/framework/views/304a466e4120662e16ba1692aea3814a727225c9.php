<?php $__env->startSection('content'); ?>
    <form role="form" method="POST" action="<?php echo e(url('/admin/promos/save')); ?>">
        <?php echo e(csrf_field()); ?>


        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group col-sm-12 <?php echo e($errors->has('company_name') ? ' has-error' : ''); ?>">
                    <label for="repeate_promo">New Promo or Replicate Promo</label>
                    <select class="form-control" id="repeate_promo" onchange="repeatproms()" name="repeate_promo">
                        <option value="0">New Promo</option>
                        <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($promo->promo_id); ?>" <?php if(old('repeate_promo') == $promo->promo_id): ?> selected="selected" <?php endif; ?> ><?php echo e($promo->promo_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </select>
                    <?php if($errors->has('repeate_promo')): ?>
                        <span class="help-block"><strong><?php echo e($errors->first('repeate_promo')); ?></strong></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col-sm-12 <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                    <label for="name">Promo Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Name">
                    <?php if($errors->has('name')): ?>
                        <span class="help-block"><strong><?php echo e($errors->first('name')); ?></strong></span>
                    <?php endif; ?>
                </div>

                <div class="form-group col-sm-12 <?php echo e($errors->has('promo_desc') ? ' has-error' : ''); ?>">
                    <label for="name">Promo Description
                        <sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Examples Of Promo Descriptions" data-content="Burger Shop: Come check out Bens Burger Shop every day between 3 and 5 pm for the best burger deals in town!" style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
                    </label>
                    <input type="text" class="form-control" id="promo_desc" name="promo_desc" value="<?php echo e(old('promo_desc')); ?>" placeholder="Describe Promo">
                    <?php if($errors->has('promo_desc')): ?>
                        <span class="help-block"><strong><?php echo e($errors->first('promo_desc')); ?></strong></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col-sm-12 <?php echo e($errors->has('promo_start') ? ' has-error' : ''); ?>">
                    <label for="promo_start">Start Time <small class="info-box-title">( in hours & mins )</small></label>
                    <input type="text" class="form-control time-picker" id="promo_start" name="promo_start" value="<?php echo e(old('promo_start')); ?>">
                    <?php if($errors->has('promo_start')): ?>
                        <span class="help-block"><strong><?php echo e($errors->first('promo_start')); ?></strong></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col-sm-12 <?php echo e($errors->has('promo_lenght') ? ' has-error' : ''); ?>">
                    <label for="promo_lenght">Promo Lenght <small class="info-box-title">( in hours )</small></label>
                    <select class="form-control" id="promo_lenght" onchange="AdvanceWarning()" name="promo_lenght">
                        <?php for($n = 1; $n <= 24; $n++): ?>
                            <option value="<?php echo e($n); ?>" <?php if(old('promo_lenght') == $n): ?> selected="selected" <?php endif; ?>> <?php echo e($n); ?></option>
                        <?php endfor; ?>
                    </select>
                    <?php if($errors->has('promo_lenght')): ?>
                        <span class="help-block"><strong><?php echo e($errors->first('promo_lenght')); ?></strong></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col-sm-12 <?php echo e($errors->has('advance_warning') ? ' has-error' : ''); ?>">
                    <label for="address" style="width: 100%;">Advanced Warning</label>
                    <input type="checkbox" name="advance_warning" onchange="ChangeAutofill()" value="0" />
                </div>


                <div class="form-group col-sm-6 <?php echo e($errors->has('repeat_promo') ? ' has-error' : ''); ?>">
                    <label for="repeat_promo">Promo Frequency</label>
                    <select class="form-control" id="repeat_promo" onchange="selectrepeat()" name="repeat_promo">
                        <option value="Daily">Daily</option>
                        <option value="Week">Monday - Friday</option>
                        <option value="Weekend">Saturday - Sunday</option>
                        <option value="Date">One Time</option>
                        <option value="Days">Custom</option>
                    </select>
                    <?php if($errors->has('repeat_promo')): ?>
                        <span class="help-block"><strong><?php echo e($errors->first('repeat_promo')); ?></strong></span>
                    <?php endif; ?>

                    <div class="form-group repeat-me">
                        <div class="fordate" style="display: none;">
                            <label for="repeat_promo">Select Date</label><div class="clearfix"></div>
                            <input type="text" name="promo_date" class="form-control date-picker"/>
                        </div>
                        <div class="fordays" style="display: none;">
                            <label for="repeat_promo">Select Days</label>
                            <div class="clearfix"></div>

                            <div class="col-sm-12"><label><input type="checkbox" value="1" name="days[]" /> Monday</label></div>
                            <div class="col-sm-12"><label><input type="checkbox" value="2" name="days[]" /> Tuesday</label></div>
                            <div class="col-sm-12"><label><input type="checkbox" value="3" name="days[]" /> Wednesday</label></div>
                            <div class="col-sm-12"><label><input type="checkbox" value="4" name="days[]" /> Thursday</label></div>
                            <div class="col-sm-12"><label><input type="checkbox" value="5" name="days[]" /> Friday</label></div>
                            <div class="col-sm-12"><label><input type="checkbox" value="6" name="days[]" /> Saturday</label></div>
                            <div class="col-sm-12"><label><input type="checkbox" value="7" name="days[]" /> Sunday</label></div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group col-sm-12 <?php echo e($errors->has('company_name') ? ' has-error' : ''); ?>">
                    <label for="company_name">Company</label>
                    <select class="form-control" id="company_name" onchange="selectstore()" name="company_name">
                        <option value="">-- select User --</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php if(old('company_name') == $user->id): ?> selected="selected" <?php endif; ?> ><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </select>
                    <?php if($errors->has('company_name')): ?>
                        <span class="help-block"><strong><?php echo e($errors->first('company_name')); ?></strong></span>
                    <?php endif; ?>
                </div>
                <div class="form-group col-sm-12 <?php echo e($errors->has('store_name') ? ' has-error' : ''); ?>">
                    <div class="col-sm-8"><label for="store_name">Select Store</label></div><div class="col-sm-4"><label for="store_name">Outsides store or somewhere</label></div>
                    <div id="store_name_box">

                    </div>
                </div>



            </div>
        </div>










        <div class="form-group col-sm-12">
            <input type="hidden" name="totalchecked" value="0">
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
        </div>

    </form>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQOQYd6y3PeucI2ajI2hXzcPTXVwlGfgs&sensor=false&libraries=places"></script>
    <script type="text/javascript">

        <!--  New Map -->
        function ShowMap(mapId){

            if($('#store_outside_'+mapId).prop("checked") == true){
                $('#promo_map_'+mapId).show();
                $('#store_address_'+mapId).show();
            }else{
                $('#promo_map_'+mapId).hide();
                $('#store_address_'+mapId).hide();
            }

            var lat = document.getElementById('store_lat_'+mapId).value;
            var lng = document.getElementById('store_lng_'+mapId).value;
            initialize(lat,lng,mapId);
        }

        function initialize(lat=0,lng=0,mapid) {
            if(lat === 0){ lat = 37.8271784; }
            if(lng === 0){ lng = -122.2913078; }

            var latlng = new google.maps.LatLng(lat, lng);
            var map = new google.maps.Map(document.getElementById('promo_map_'+mapid), {
                center: latlng,
                zoom: 15
            });
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29)
            });
            var input = document.getElementById('store_address_'+mapid);
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

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                document.getElementById('store_lat_'+mapid).value = place.geometry.location.lat();
                document.getElementById('store_lng_'+mapid).value = place.geometry.location.lng();
                //bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng(), place);
                var storeaddress = document.getElementById('store_name_'+mapid).value;
                infowindow.setContent(storeaddress);
                infowindow.open(map, marker);

            });
            // this function will work on marker move event into map
            google.maps.event.addListener(marker, 'dragend', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            document.getElementById('store_lat_'+mapid).value = marker.getPosition().lat();
                            document.getElementById('store_lng_'+mapid).value = marker.getPosition().lng();
                            var storeaddress = document.getElementById('store_name_'+mapid).value;
                            infowindow.setContent(storeaddress);
                            infowindow.open(map, marker);
                        }
                    }
                });
            });
        }


        <!-- END OF GOOGLE MAP API -->

        function ForDate(){
            $('.fordate').css("display","block");
            $('input[name="promo_date"]').attr("required","required");
            $('.fordays').css("display","none");
        }

        function ForDays(){
            $('.fordays').css("display","block");
            $('.fordate').css("display","none");
            $('input[name="promo_date"]').removeAttr("required");
        }

        function selectrepeat(){
            var html = $('select[name="repeat_promo"]').val();

            if(String(html) === 'Days'){
                ForDays();
            }else if(String(html) === 'Date'){
                ForDate();
            }else{
                $('.fordays').css("display","none");
                $('.fordate').css("display","none").removeAttr("required");
            }
        }

        function repeatproms(){
            var promopage = $('#repeate_promo').val();
            window.location = "<?php echo e(url('admin/promos/create')); ?>/"+parseInt(promopage);
        }

        function selectstore(){
            var user = $('select[name="company_name"]').val();
            $.get("<?php echo e(url('admin/promos')); ?>/"+parseInt(user),function(data){
                $('#store_name_box').html(data+'<div class="clearfix"></div>');
            });
        }

        function AdvanceWarning(){
            var p_lenght = $('#promo_lenght').val();
            var html = '<option value="0">0 hrs</option>';
            for(var n = 1; n <= parseInt(24 - parseInt(p_lenght)); n++){
                if(n === 1){
                    html += '<option value="'+n+'">'+n+' hour</option>';
                }else{
                    html += '<option value="'+n+'">'+n+' hours</option>';
                }
            }
            $('#advance_warning').html(html);
        }

        $(document).ready(function(){
            selectrepeat();
            selectstore();
            AdvanceWarning();


            $('form').submit(function(){
                var html = $('select[name="repeat_promo"]').val();
                if(String(html) === 'Days'){
                    var n = 0;
                    $.each($("input[type='checkbox']:checked"), function(){
                        n++;
                    });
                    if(parseInt(n) === 0){
                        $('.fordays .clearfix').before(' <span class="text-danger"><strong>Please select anyday <strong></span>');
                        return false;
                    }
                }
            });
        });

        function generate_qr_code(id) {

            $('#crt_qr_'+id).hide();

            $.get("<?php echo e(url('admin/generate_new_qr')); ?>",function(data){
                // console.log(data);
                $('#qr_code_prev_'+id).attr('src', "<?php echo e(url('resources/assets/qr_codes')); ?>/"+data['qr_image']);
                // $('#print_code_'+id).attr('href', "<?php echo e(url('resources/assets/qr_codes')); ?>/"+data['qr_image']);
                $('#promo_qr_image_'+id).val(data['qr_image']);
                $('#promo_qr_code_'+id).val(data['qr_content']);

            });

            $('#print_code_'+id).show();
            $('#refresh_qr_'+id).show();
        }

        function refresh_qr(id) {
            // get image qr code name
            var old_qr = $('#promo_qr_image_'+id).val();
            $('#qr_code_prev_'+id).attr('src', "<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>");
            $.get("<?php echo e(url('user/delete_old_qr')); ?>/"+old_qr,function(data){});

            generate_qr_code(id);
        }

        function view_qr_code(id) {
            var src = $('#qr_code_prev_' + id).attr('src');
            window.open(src);
            // alert(src);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>