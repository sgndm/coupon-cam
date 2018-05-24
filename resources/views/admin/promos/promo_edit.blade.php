@extends('layouts.admin')
@section('content')
<form role="form" method="POST" action="{{ url('/admin/promos/update') }}">
    {{ csrf_field() }}
    <input type="hidden" name="formid" value="{{ $promo->promo_id }}" />
    <div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name">Promo Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$promo->promo_name) }}" placeholder="Enter Name">
        @if ($errors->has('name'))
        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('promo_desc') ? ' has-error' : '' }}">
        <label for="name">Promo Description <sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Examples Of Promo Descriptions" data-content="Burger Shop: Come check out Bens Burger Shop every day between 3 and 5 pm for the best burger deals in town!" style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup></label>
        <input type="text" class="form-control" id="promo_desc" name="promo_desc" value="{{ old('promo_desc',$promo->main_clue) }}" placeholder="Describe Promo">
        @if ($errors->has('promo_desc'))
        <span class="help-block"><strong>{{ $errors->first('promo_desc') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('company_name') ? ' has-error' : '' }}">
        <label for="company_name">Company</label>
        <select class="form-control" id="company_name" onchange="selectstore()" name="company_name">
            @foreach($users as $key => $user)
                <option value="{{ $user->id }}" @if(old('company_name',$promo->user_id) == $user->id) selected="selected" @endif >{{ $user->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('company_name'))
        <span class="help-block"><strong>{{ $errors->first('company_name') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-12 {{ $errors->has('store_name') ? ' has-error' : '' }}">
        <div class="col-sm-8"><label for="store_name">Select Store</label></div><div class="col-sm-4"><label for="store_name">Outsides store or somewhere</label></div>
        <div id="store_name_box"></div>
    </div>
    
    <div class="form-group col-sm-6 {{ $errors->has('promo_start') ? ' has-error' : '' }}">
        <label for="promo_start">Start Time <small class="info-box-title">( in hours & mins ) </small></label>
        <input type="text" class="form-control time-picker" id="promo_start" name="promo_start" value="{{ old('promo_start',date('H:i A',strtotime($promo->start_at))) }}">
        @if ($errors->has('promo_start'))
        <span class="help-block"><strong>{{ $errors->first('promo_start') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('promo_lenght') ? ' has-error' : '' }}">
        <label for="promo_lenght">Promo Lenght <small class="info-box-title">( in hours )</small></label>
        <select class="form-control" id="promo_lenght" onchange="AdvanceWarning()" name="promo_lenght">
            @for($n = 1; $n <= 24; $n++)
            <option value="{{ $n }}" @if(old('promo_lenght',$promo->promo_lenght) == $n) selected="selected" @endif> {{ $n }}</option>
            @endfor
        </select>

        @if ($errors->has('promo_lenght'))
        <span class="help-block"><strong>{{ $errors->first('promo_lenght') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('advance_warning') ? ' has-error' : '' }}">
        <label for="advance_warning">Advance Warning (Get your coupons on the app in advance so users can plan to come in advance)</label>
        <select class="form-control" id="advance_warning" name="advance_warning">
            @for($n = 1; $n <= 24; $n++)
            <option value="{{ $n }}" @if(old('advance_warning',$promo->advance_warning) == $n) selected="selected" @endif> {{ $n }} @if($n == 1) hour @else hours @endif</option>
            @endfor
        </select>
        @if ($errors->has('advance_warning'))
        <span class="help-block"><strong>{{ $errors->first('advance_warning') }}</strong></span>
        @endif
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('repeat_promo') ? ' has-error' : '' }}">
        <label for="repeat_promo">Promo Frequency</label>
        <select class="form-control" id="repeat_promo" onchange="selectrepeat()" name="repeat_promo">
            <option value="Daily" @if(old('repeat_promo',$promo->promo_repeat) == 'Daily') selected="selected" @endif>Daily</option>
            <option value="Days" @if(old('repeat_promo',$promo->promo_repeat) == 'Days') selected="selected" @endif>Select Days</option>
            <option value="Date" @if(old('repeat_promo',$promo->promo_repeat) == 'Date') selected="selected" @endif>Select Date</option>
        </select>
        @if ($errors->has('repeat_promo'))
        <span class="help-block"><strong>{{ $errors->first('repeat_promo') }}</strong></span>
        @endif
		
		<div class="form-group repeat-me">
        <div class="fordate" @if($promo->promo_repeat != 'Date') style="display: none;" @endif>
             @if($promo->promo_repeat == 'Date')
            <label for="repeat_promo">Select Date</label><div class="clearfix"></div>
                @if($promo->promo_repeat_values != 'null')
                <input type="text" name="promo_date" required="" class="form-control date-picker" value="{{ date('m/d/Y',strtotime($promo->promo_repeat_values)) }}"/>
                @else
                    <input type="text" name="promo_date" required="" class="form-control date-picker" value=""/>
                @endif
            @else
            <label for="repeat_promo">Select Date</label><div class="clearfix"></div>
            <input type="text" name="promo_date" class="form-control date-picker" value=""/>
            @endif
        </div>
        <div class="fordays" @if($promo->promo_repeat != 'Days') style="display: none;" @endif>
        <label for="repeat_promo">Select Days</label>
        <div class="clearfix"></div>
        @if($promo->promo_repeat == 'Days')
            <?PHP
                if($promo->promo_repeat_values != 'null'){
                    $x = json_decode($promo->promo_repeat_values);
                }else{
                    $x = array();
                }
                $days = array("","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
                $html = '';
                
                for($n=1; $n<=7; $n++){
                    if(in_array($n, $x)){
                        $html .= '<div class="col-sm-4"><label><input type="checkbox" checked="checked" value="'.$n.'" name="days[]" /> '.$days[$n].'</label></div>';
                    }else{
                        $html .= '<div class="col-sm-4"><label><input type="checkbox" value="'.$n.'" name="days[]" /> '.$days[$n].'</label></div>';                    
                    }
                }
                
                echo $html;
            ?>

        @else
            
            <div class="col-sm-4"><label><input type="checkbox" value="1" name="days[]" /> Monday</label></div>
            <div class="col-sm-4"><label><input type="checkbox" value="2" name="days[]" /> Tuesday</label></div>
            <div class="col-sm-4"><label><input type="checkbox" value="3" name="days[]" /> Wednesday</label></div>
            <div class="col-sm-4"><label><input type="checkbox" value="4" name="days[]" /> Thursday</label></div>
            <div class="col-sm-4"><label><input type="checkbox" value="5" name="days[]" /> Friday</label></div>
            <div class="col-sm-4"><label><input type="checkbox" value="6" name="days[]" /> Saturday</label></div>
            <div class="col-sm-4"><label><input type="checkbox" value="7" name="days[]" /> Sunday</label></div>
        @endif
        </div>
    </div>
		
		
		
    </div>
    
    <div class="form-group col-sm-6">
        <label for="repeat_promo">Promo Status</label>
        <select class="form-control" id="active" name="active">
            <option value="1" @if(old('active',$promo->active) == '1') selected="selected" @endif>Active</option>
            <option value="0" @if(old('active',$promo->active) == '0') selected="selected" @endif>Close</option>
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
        $('.fordate').css("display","block").attr("required","required");
        $('.fordays').css("display","none");
    }
    
    function ForDays(){
        $('.fordays').css("display","block");
        $('.fordate').css("display","none").removeAttr("required");
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
    
	function selectstore(){
         var user = $('select[name="company_name"]').val();
	 $.get("{{ url('admin/promos') }}/"+parseInt(user)+"/"+parseInt({{ $promo->promo_id }}),function(data){
             $('#store_name_box').html(data+'<div class="clearfix"></div>');
         });
    }
	
    function AdvanceWarning(){
        var p_lenght = $('#promo_lenght').val();
        var current_promo = {{ $promo->advance_warning }};
        var html = '<option value="0">0 hrs</option>';
        for(var n = 1; n <= parseInt(24 - parseInt(p_lenght)); n++){
            if(n === 1){
                if(n === parseInt(current_promo)){
                    html += '<option value="'+n+'" selected="selected">'+n+' hour</option>';
                }else{
                    html += '<option value="'+n+'">'+n+' hour</option>';
                }
            }else{
                if(n === parseInt(current_promo)){
                    html += '<option value="'+n+'" selected="selected">'+n+' hours</option>';
                }else{
                    html += '<option value="'+n+'">'+n+' hours</option>';
                }
            }
        }
        $('#advance_warning').html(html);
    }
$(document).ready(function(){
$('select[name="company_name"]').val(parseInt({{ $promo->user_id }}));
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
</script>
@endsection