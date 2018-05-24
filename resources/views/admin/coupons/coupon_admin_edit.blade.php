@extends('layouts.admin')
@section('content')
<form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/admin/coupons/single/update') }}">
        {{ csrf_field() }}
        <input type="hidden" name="coupon_id_1" value="{{ $coupons->id }}" />
           
        <div class="clearfix"></div>
        <div class="col-md-6">
                    <div class="panel-body">
                        <div class="form-group col-sm-12 {{ $errors->has('coupon_name_1') ? ' has-error' : '' }}">
                            <label for="coupon_name_1">Coupon Name <small>( max 30 chars )</small></label>
                            <input type="text" onkeyup="setheading('1');" required="required" maxlength="30" class="form-control" id="coupon_name_1" name="coupon_name_1" value="{{ old('coupon_name_1',$coupons->name) }}">
                            @if ($errors->has('coupon_name_1'))
                            <span class="help-block"><strong>{{ $errors->first('coupon_name_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('availablity_1') ? ' has-error' : '' }}">
                            <label for="availablity_1">Availablity</label>
                            <input type="text" required="required" maxlength="30" class="form-control" id="availablity_1" name="availablity_1" value="{{ old('availablity_1',$coupons->availability) }}">
                            @if ($errors->has('availablity_1'))
                            <span class="help-block"><strong>{{ $errors->first('availablity_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('term_condition_1') ? ' has-error' : '' }}">
                            <label for="term_condition_1">Terms & Conditions </label>
                            <textarea class="form-control" id="term_condition_1" required="required" name="term_condition_1">{{ old('term_condition_1',$coupons->term_condition) }}</textarea>

                            @if ($errors->has('term_condition_1'))
                            <span class="help-block"><strong>{{ $errors->first('term_condition_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-4 {{ $errors->has('expiery_date_1') ? ' has-error' : '' }}">
                            <label for="expiery_date_1">Expiry Date</label>
                            @if($coupons->end_at != '' && $coupons->end_at != '1970-01-01 00:00:00')
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="{{ old('expiery_date_1',date('m/d/Y',strtotime($coupons->end_at))) }}">
                            @else
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="">                            
                            @endif
                            @if ($errors->has('expiery_date_1'))
                            <span class="help-block"><strong>{{ $errors->first('expiery_date_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 image-editor_1 {{ $errors->has('photo_1') ? ' has-error' : '' }}">
                            <label for="photo_1">Image</label>
                            <input type="file" id="photo_1" class="cropit-image-input" name="photo_1" />
                            @if ($errors->has('photo_1'))
                            <span class="help-block"><strong>{{ $errors->first('photo_1') }}</strong></span>
                            @endif
                            
                            <div class="cropit-preview"></div>
                            <div class="image-size-label">
                                Resize image
                            </div>
                            <div class="col-sm-8">
                                <input type="range" class="cropit-image-zoom-input">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" id="crp_1">Set</button>
                            </div>
                            <input type="hidden" name="image_data_1" class="hidden-image-data_1" />
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

         <div class="form-group col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
@endsection
@section('custom_css')
<style type="text/css">
    .imagecontainer{  height: 391px; width:220px; background-position: center; padding: 65px 25px 50px 25px; margin: 0 auto; background-image: url({{ url('resources/assets/user/images/Coupons-on-phone-for-CMS.png') }}); background-repeat: no-repeat; background-size: contain;}
    .imagecontainer .heading{ height: 25px;
                                width: 100%;
                                text-align: center;
                                overflow: hidden;
                                padding-top: 0px;
                                font-size: 15px;  }
    .imagecontainer .content{ height: 68px; width: 100%; text-align: center; overflow: hidden; }
    .imagecontainer .content img{ height: inherit; width: auto; text-align: center; overflow: hidden; }
    .imagecontainer .content .goimage{ 
        background-image: url({{ url('resources/assets/user/images/goimage.png') }});
        background-repeat: no-repeat;
        background-position: center;
        height: 52px;
        width: 170px;
        position: absolute;
    }
    </style>
    <style type="text/css">
      .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 380px;
        height: 120px;
      }

      .cropit-preview-image-container {
        cursor: move;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input {
        display: block;
      }

      button[type="submit"] {
        margin-top: 10px;
      }

      #result {
        margin-top: 10px;
        width: 900px;
      }

      #result-data {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        word-wrap: break-word;
      }
    </style>
    @endsection
@section('custom_js')
<script src="{{ url('resources/assets/js/cropit-master') }}/dist/jquery.cropit.js"></script>
  <!-- <script src="{{ url('resources/assets/js/Jcrop-master') }}/js/jquery.Jcrop.js"></script> -->
  <script type="text/javascript">
      $(function() {
        $('.image-editor_1').cropit();
        $('#crp_1').click(function() {
          // Move cropped image data to hidden input
          var imageData = $('.image-editor_1').cropit('export');
          $('.hidden-image-data_1').val(imageData);
          $('#image_1').attr('src',imageData);
          $('#photo_1').val('').removeAttr("required");
        });
      });
    </script>
<script type="text/javascript">
        function readURL(input,id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_'+id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function setheading(id){
            var value = $('input[name="coupon_name_'+id+'"]').val();
            $('#heading_'+String(id)).text(value);
        }
        
        function promos(){
            var company_name = $('#company_name').val();
            $.get("{{ url('admin/coupons/promos/') }}/"+company_name,{company_name:company_name},function(data){
                $('#promo_name').html(data);
            });
        }
        
    $(document).ready(function(){
        promos();
        /*if(window.innerWidth < 1024){
            $('.imagecontainer').css("position","relative").css("top",0).css("right",0);
        }else{
            $('.imagecontainer').css("position","fixed");
        }
        $(this).scroll(function(){
            var scrollAmt = $(this).scrollTop();
            var topposition = 280;
            if(window.innerWidth > 1024){
                $('.imagecontainer').css("position","fixed");
                if(parseInt(scrollAmt) === 0){
                    $('.imagecontainer').css("top",topposition+'px').css("right",'160px');
                }else{
                    $('.imagecontainer').css("top",'90px').css("right",'160px');
                }
            }else{
                $('.imagecontainer').css("position","relative").css("top",0).css("right",0);
            }
        })*/
    });
</script>
@endsection