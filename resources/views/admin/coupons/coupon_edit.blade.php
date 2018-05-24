@extends('layouts.admin')
@section('content')
<form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/admin/coupons/update') }}">
        {{ csrf_field() }}
        
        <input type="hidden" name="coupon_id_1" value="{{ $coupons[0]->coupon_id }}" />
        <input type="hidden" name="coupon_id_2" value="{{ $coupons[1]->coupon_id }}" />
        <input type="hidden" name="coupon_id_3" value="{{ $coupons[2]->coupon_id }}" />
        <input type="hidden" name="coupon_id_4" value="{{ $coupons[3]->coupon_id }}" />
            
<div class="col-md-6">
    <div class="form-group col-sm-12 {{ $errors->has('company_name') ? ' has-error' : '' }}">
            <label for="company_name">Company</label>
            <select class="form-control" id="company_name" required="required" onchange="promos()" name="company_name">
                @foreach($users as $key => $user)
                @if($coupons[0]->user_id)
                <option value="{{ $user->id }}" @if($user->id == $coupons[0]->user_id) selected="selected" @endif>{{ $user->name }}</option>
                @else
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endif
                @endforeach
            </select>
            @if ($errors->has('company_name'))
            <span class="help-block"><strong>{{ $errors->first('company_name') }}</strong></span>
            @endif
        </div>
        <div class="form-group col-sm-12 {{ $errors->has('promo_name') ? ' has-error' : '' }}">
            <label for="promo_name">Promo Name</label>
            <select class="form-control" id="promo_name" required="required" name="promo_name">
                <option value="">Select Promo</option>
            </select>
            @if($errors->has('promo_name'))
            <span class="help-block"><strong>{{ $errors->first('promo_name') }}</strong></span>
            @endif
        </div>

        
    </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
       <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active" style="width: 25%; text-align: center;"><a href="#step_1" aria-controls="step_1" role="tab" data-toggle="tab">Coupon #1</a></li>
            <li role="presentation" style="width: 25%; text-align: center;"><a href="#step_2" aria-controls="step_2" role="tab" data-toggle="tab">Coupon #2</a></li>
            <li role="presentation" style="width: 25%; text-align: center;"><a href="#step_3" aria-controls="step_3" role="tab" data-toggle="tab">Coupon #3</a></li>
            <li role="presentation" style="width: 25%; text-align: center;"><a href="#step_4" aria-controls="step_4" role="tab" data-toggle="tab">Coupon #4</a></li>
            <li role="presentation" style="width: 25%; text-align: center; display: none;"><a href="#step_5" aria-controls="step_5" role="tab" data-toggle="tab">&nbsp;</a></li>
        </ul>
         <div class="tab-content" style="min-height:756px;">
             <div role="tabpanel" class="tab-pane active" id="step_1">
                        <div class="form-group col-sm-12 {{ $errors->has('coupon_name_1') ? ' has-error' : '' }}">
                            <label for="coupon_name_1">Coupon Name <small>( max 30 chars )</small></label>
                            <input type="text" onkeyup="setheading('1');" required="required" maxlength="30" class="form-control" id="coupon_name_1" name="coupon_name_1" value="{{ old('coupon_name_1',$coupons[0]->coupon_title) }}">
                            @if ($errors->has('coupon_name_1'))
                            <span class="help-block"><strong>{{ $errors->first('coupon_name_1') }}</strong></span>
                            @endif
                        </div>
                        
                        <div class="form-group col-sm-12 {{ $errors->has('availablity_1') ? ' has-error' : '' }}">
                            <label for="availablity_1">Availablity
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="The amount available each time this promo runs" style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" required="required" maxlength="30" class="form-control" id="availablity_1" name="availablity_1" value="{{ old('availablity_1',$coupons[0]->coupon_availabilty) }}">
                            @if ($errors->has('availablity_1'))
                            <span class="help-block"><strong>{{ $errors->first('availablity_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('term_condition_1') ? ' has-error' : '' }}">
                            <label for="term_condition_1">Info & Conditions 
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="A quick description of the coupon and basic conditons" data-content="Example: Home made burger with your choice of salad and sauce. No Purchase Necessary, Double Stack Burgers not included. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							</label>
                            <textarea class="form-control" id="term_condition_1" name="term_condition_1">{{ old('term_condition_1',$coupons[0]->terms_conditions) }}</textarea>

                            @if ($errors->has('term_condition_1'))
                            <span class="help-block"><strong>{{ $errors->first('term_condition_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('dterm_condition_1') ? ' has-error' : '' }}">
                            <label for="dterm_condition_1">Detailed Terms & Conditions </label>
                            <textarea class="form-control" id="dterm_condition_1" name="dterm_condition_1">{{ $coupons[0]->coupon_information }}</textarea>
                        </div>
                        
                        <div class="form-group col-sm-4 {{ $errors->has('expiery_date_1') ? ' has-error' : '' }}" style="display: none;">
                            <label for="expiery_date_1">Expiry Date</label>
                            @if($coupons[0]->expire_date != '' && $coupons[0]->expire_date != '1970-01-01 00:00:00')
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="{{ old('expiery_date_1',date('m/d/Y',strtotime($coupons[0]->expire_date))) }}">
                            @else
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="">                            
                            @endif
                            @if ($errors->has('expiery_date_1'))
                            <span class="help-block"><strong>{{ $errors->first('expiery_date_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('estimated_value_1') ? ' has-error' : '' }}">
                            <label for="estimated_value_1">Estimated Value
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="Estimate the saving a customer will get by using this coupon. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" class="form-control" id="estimated_value_1" name="estimated_value_1" value="{{ old('estimated_value_1',$coupons[0]->estimated_value) }}">
                            @if ($errors->has('estimated_value_1'))
                            <span class="help-block"><strong>{{ $errors->first('estimated_value_1') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 image-editor_1 {{ $errors->has('photo_1') ? ' has-error' : '' }}">
                            <label for="photo_1">Image</label> 
                            
                            @if (file_exists('resources/assets/coupons/full/'.$coupons[0]->coupon_photo)) 
                            	<a href="{{ asset('resources/assets/coupons/full/'.$coupons[0]->coupon_photo) }}" target="_blank">Download</a>
                            @else
                            	<a href="{{ asset('resources/assets/coupons/'.$coupons[0]->photo) }}" target="_blank">Download</a>
                            @endif
                            
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
                                <button type="button" id="crp_1">Add photo</button>
                            </div>
                            <input type="hidden" name="image_data_1" class="hidden-image-data_1" />
                            
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('3d_photo_1') ? ' has-error' : '' }}">
                            <label for="3d_photo_1">3D Coupon</label>
                            <div class="clearfix"></div>
                            <div class="thumbnail" style="width:200px;">
									 
                                @if($coupons[0]->coupon_model != '')
                                        <?PHP
                                        $image = \App\Media::where("image_fbx",$coupons[0]->coupon_model)->first();
                                        if($image){ $image = $image->image_thumbnail; }else{ $image = ""; }
                                        ?>
                                        <img src="{{ url('resources/assets/media') }}/{{ $image }}" id="usemeforimage_1" />
                                @else
                                        <img src="" id="usemeforimage_1" />
                                @endif
									
                                
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6"><input type="hidden" value="{{ $coupons[0]->coupon_model }}" id="3d_photo_1" class="cropit-image-input" name="3d_photo_1" />
                                @if($coupons[0]->coupon_model != "") <a style="float:left;" href="#" data-id="{{ $coupons[0]->coupon_model }}" class="model-popupbutton btn btn-info btn-xs" >3D Object</a>@endif
                                <a style="float:left; margin-left:10px;" class="btn btn-primary btn-xs openmodel" data-bind="1" data-id="3d_photo_1" data-toggle="modal" data-target="#myModal">Add 3D Coupon</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <button type="button" style="float:right" onclick="nexttab('step_2')" class="btn btn-primary">Save</button>
                         </div>
             </div>
             <div role="tabpanel" class="tab-pane" id="step_2">
                        <div class="form-group col-sm-12 {{ $errors->has('coupon_name_2') ? ' has-error' : '' }}">
                            <label for="coupon_name_2">Coupon Name <small>( max 30 chars )</small></label>
                            <input type="text" onkeyup="setheading('2');" required="required" maxlength="30" class="form-control" id="coupon_name_2" name="coupon_name_2" value="{{ old('coupon_name_2',$coupons[1]->coupon_title) }}">
                            @if ($errors->has('coupon_name_2'))
                            <span class="help-block"><strong>{{ $errors->first('coupon_name_2') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('availablity_2') ? ' has-error' : '' }}">
                            <label for="availablity_2">Availablity
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="The amount available each time this promo runs" style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" required="required" maxlength="30" class="form-control" id="availablity_2" name="availablity_2" value="{{ old('availablity_2',$coupons[1]->coupon_availabilty) }}">
                            @if ($errors->has('availablity_2'))
                            <span class="help-block"><strong>{{ $errors->first('availablity_2') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('term_condition_2') ? ' has-error' : '' }}">
                            <label for="term_condition_2">Info & Conditions 
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="A quick description of the coupon and basic conditons" data-content="Example: Home made burger with your choice of salad and sauce. No Purchase Necessary, Double Stack Burgers not included. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							</label>
                            <textarea class="form-control" id="term_condition_2" name="term_condition_2">{{ old('term_condition_2',$coupons[1]->terms_conditions) }}</textarea>

                            @if ($errors->has('term_condition_2'))
                            <span class="help-block"><strong>{{ $errors->first('term_condition_2') }}</strong></span>
                            @endif
                        </div>
						
						<div class="form-group col-sm-12 {{ $errors->has('dterm_condition_2') ? ' has-error' : '' }}">
                            <label for="dterm_condition_2">Detailed Terms & Conditions </label>
                            <textarea class="form-control" id="dterm_condition_2" name="dterm_condition_2">{{ $coupons[1]->coupon_information }}</textarea>
                        </div>
                        <div class="form-group col-sm-4 {{ $errors->has('expiery_date_2') ? ' has-error' : '' }}" style="display: none;">
                            <label for="expiery_date_2">Expiry Date</label>
                            @if($coupons[1]->expire_date != '' && $coupons[1]->expire_date != '1970-01-01 00:00:00')
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="{{ old('expiery_date_1',date('m/d/Y',strtotime($coupons[1]->expire_date))) }}">
                            @else
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="">                            
                            @endif
                            @if ($errors->has('expiery_date_2'))
                            <span class="help-block"><strong>{{ $errors->first('expiery_date_2') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('estimated_value_2') ? ' has-error' : '' }}">
                            <label for="estimated_value_2">Estimated Value
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="Estimate the saving a customer will get by using this coupon. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" class="form-control" id="estimated_value_1" name="estimated_value_2" value="{{ old('estimated_value_2',$coupons[1]->estimated_value) }}">
                            @if ($errors->has('estimated_value_2'))
                            <span class="help-block"><strong>{{ $errors->first('estimated_value_2') }}</strong></span>
                            @endif
                        </div>
                        
                        <div class="form-group col-sm-12 image-editor_2 {{ $errors->has('photo_2') ? ' has-error' : '' }}">
                            <label for="photo_2">Image</label> 
                            
                            @if (file_exists('resources/assets/coupons/full/'.$coupons[1]->coupon_photo)) 
                            	<a href="{{ asset('resources/assets/coupons/full/'.$coupons[1]->coupon_photo) }}" target="_blank">Download</a>
                            @else
                            	<a href="{{ asset('resources/assets/coupons/'.$coupons[1]->photo) }}" target="_blank">Download</a>
                            @endif
                            
                            <input type="file" id="photo_2" class="cropit-image-input" name="photo_2" />
                            @if ($errors->has('photo_2'))
                            <span class="help-block"><strong>{{ $errors->first('photo_2') }}</strong></span>
                            @endif
                            
                            <div class="cropit-preview"></div>
                            <div class="image-size-label">
                                Resize image
                            </div>
                            <div class="col-sm-8">
                                <input type="range" class="cropit-image-zoom-input">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" id="crp_2">Add photo</button>
                            </div>
                            <input type="hidden" name="image_data_2" class="hidden-image-data_2" />
                           
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('3d_photo_2') ? ' has-error' : '' }}">
                            <label for="3d_photo_2">3D Coupon</label>
                            <div class="clearfix"></div>
                            <div class="thumbnail" style="width:200px;">
                                @if($coupons[1]->coupon_model != '')
                                        <?PHP
                                        $image = \App\Media::where("image_fbx",$coupons[1]->coupon_model)->first();
                                        if($image){ $image = $image->image_thumbnail; }else{ $image = ""; }
                                        ?>
                                        <img src="{{ url('resources/assets/media') }}/{{ $image }}" id="usemeforimage_2" />
                                @else
                                        <img src="" id="usemeforimage_2" />
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6"><input type="hidden" id="3d_photo_2" value="{{ $coupons[1]->coupon_model }}" class="cropit-image-input" name="3d_photo_2" />
                                @if($coupons[1]->coupon_model != "") <a style="float: left;" href="#" data-id="{{ $coupons[1]->coupon_model }}" class="model-popupbutton btn btn-info btn-xs" >3D Object</a>@endif
                                <a style="float:left; margin-left:10px;" class="btn btn-primary btn-xs openmodel" data-bind="2" data-id="3d_photo_2" data-toggle="modal" data-target="#myModal">Add 3D Coupon</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <!-- <button type="button" style="float:left" onclick="nexttab('step_1')" class="btn btn-primary">Back</button> -->
                            <button type="button" style="float:right" onclick="nexttab('step_3')" class="btn btn-primary">Save</button>
                         </div>
             </div>
             <div role="tabpanel" class="tab-pane" id="step_3">
                        <div class="form-group col-sm-12 {{ $errors->has('coupon_name_3') ? ' has-error' : '' }}">
                            <label for="coupon_name_3">Coupon Name <small>( max 30 chars )</small></label>
                            <input type="text" onkeyup="setheading('3');" required="required" maxlength="30" class="form-control" id="coupon_name_3" name="coupon_name_3" value="{{ old('coupon_name_3',$coupons[2]->coupon_title) }}">
                            @if ($errors->has('coupon_name_3'))
                            <span class="help-block"><strong>{{ $errors->first('coupon_name_3') }}</strong></span>
                            @endif
                        </div>
                        
                        
                        <div class="form-group col-sm-12 {{ $errors->has('availablity_3') ? ' has-error' : '' }}">
                            <label for="availablity_3">Availablity
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="The amount available each time this promo runs" style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" required="required" maxlength="30" class="form-control" id="availablity_3" name="availablity_3" value="{{ old('availablity_3',$coupons[2]->coupon_availabilty) }}">
                            @if ($errors->has('availablity_3'))
                            <span class="help-block"><strong>{{ $errors->first('availablity_3') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('term_condition_3') ? ' has-error' : '' }}">
                            <label for="term_condition_3">Info & Conditions 
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="A quick description of the coupon and basic conditons" data-content="Example: Home made burger with your choice of salad and sauce. No Purchase Necessary, Double Stack Burgers not included. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							</label>
                            <textarea class="form-control" id="term_condition_3" name="term_condition_3">{{ old('term_condition_3',$coupons[2]->terms_conditions) }}</textarea>

                            @if ($errors->has('term_condition_3'))
                            <span class="help-block"><strong>{{ $errors->first('term_condition_3') }}</strong></span>
                            @endif
                        </div>
						<div class="form-group col-sm-12 {{ $errors->has('dterm_condition_3') ? ' has-error' : '' }}">
                            <label for="dterm_condition_3">Detailed Terms & Conditions </label>
                            <textarea class="form-control" id="dterm_condition_3" name="dterm_condition_3">{{ $coupons[2]->coupon_information }}</textarea>
                        </div>
                        <div class="form-group col-sm-4 {{ $errors->has('expiery_date_3') ? ' has-error' : '' }}" style="display: none;">
                            <label for="expiery_date_3">Expiry Date</label>
                            @if($coupons[2]->expire_date != '' && $coupons[2]->expire_date != '1970-01-01 00:00:00')
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="{{ old('expiery_date_1',date('m/d/Y',strtotime($coupons[2]->expire_date))) }}">
                            @else
                            <input type="text" class="form-control date-picker" id="expiery_date_1" name="expiery_date_1" value="">                            
                            @endif
                            @if ($errors->has('expiery_date_3'))
                            <span class="help-block"><strong>{{ $errors->first('expiery_date_3') }}</strong></span>
                            @endif
                        </div>
         
                        <div class="form-group col-sm-12 {{ $errors->has('estimated_value_3') ? ' has-error' : '' }}">
                            <label for="estimated_value_3">Estimated Value
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="Estimate the saving a customer will get by using this coupon. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" class="form-control" id="estimated_value_3" name="estimated_value_3" value="{{ old('estimated_value_3',$coupons[0]->estimated_value) }}">
                            @if ($errors->has('estimated_value_3'))
                            <span class="help-block"><strong>{{ $errors->first('estimated_value_3') }}</strong></span>
                            @endif
                        </div>
         
                        
                        <div class="form-group col-sm-12 image-editor_3 {{ $errors->has('photo_3') ? ' has-error' : '' }}">
                            <label for="photo_2">Image</label> 
                            
                            @if (file_exists('resources/assets/coupons/full/'.$coupons[2]->coupon_photo)) 
                            	<a href="{{ asset('resources/assets/coupons/full/'.$coupons[2]->coupon_photo) }}" target="_blank">Download</a>
                            @else
                            	<a href="{{ asset('resources/assets/coupons/'.$coupons[2]->photo) }}" target="_blank">Download</a>
                            @endif
                            
                            <input type="file" id="photo_3" class="cropit-image-input" name="photo_3" />
                            @if ($errors->has('photo_3'))
                            <span class="help-block"><strong>{{ $errors->first('photo_3') }}</strong></span>
                            @endif
                            
                            <div class="cropit-preview"></div>
                            <div class="image-size-label">
                                Resize image
                            </div>
                            <div class="col-sm-8">
                                <input type="range" class="cropit-image-zoom-input">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" id="crp_3">Add photo</button>
                            </div>
                            <input type="hidden" name="image_data_3" class="hidden-image-data_3" />
                            
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('3d_photo_3') ? ' has-error' : '' }}">
                            <label for="3d_photo_3">3D Coupon</label>
                            <div class="clearfix"></div>
                            <div class="thumbnail" style="width:200px;">
                                @if($coupons[2]->coupon_model != '')
                                        <?PHP
                                        $image = \App\Media::where("image_fbx",$coupons[2]->coupon_model)->first();
                                        if($image){ $image = $image->image_thumbnail; }else{ $image = ""; }
                                        ?>
                                        <img src="{{ url('resources/assets/media') }}/{{ $image }}" id="usemeforimage_3" />
                                @else
                                        <img src="" id="usemeforimage_3" />
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6"><input type="hidden" id="3d_photo_3" value="{{ $coupons[2]->coupon_model }}" class="cropit-image-input" name="3d_photo_3" />
                                @if($coupons[2]->coupon_model != "") <a style="float: left;" href="#" data-id="{{ $coupons[2]->coupon_model }}" class="model-popupbutton btn btn-info btn-xs" >3D Object</a>@endif
                                <a style="float:left; margin-left:10px;" class="btn btn-primary btn-xs openmodel" data-bind="3" data-id="3d_photo_3" data-toggle="modal" data-target="#myModal">Add 3D Coupon</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <!-- <button type="button" style="float:left" onclick="nexttab('step_2')" class="btn btn-primary">Back</button> -->
                            <button type="button" style="float:right" onclick="nexttab('step_4')" class="btn btn-primary">Save</button>
                         </div>
             </div>
             <div role="tabpanel" class="tab-pane" id="step_4">
                        <div class="form-group col-sm-12 {{ $errors->has('coupon_name_4') ? ' has-error' : '' }}">
                            <label for="coupon_name_4">Coupon Name <small>( max 30 chars )</small></label>
                            <input type="text" onkeyup="setheading('4');" required="required" maxlength="30" class="form-control" id="coupon_name_4" name="coupon_name_4" value="{{ old('coupon_name_4',$coupons[3]->coupon_title) }}">
                            @if ($errors->has('coupon_name_4'))
                            <span class="help-block"><strong>{{ $errors->first('coupon_name_4') }}</strong></span>
                            @endif
                        </div>
                        
                        
                        <div class="form-group col-sm-12 {{ $errors->has('availablity_4') ? ' has-error' : '' }}">
                            <label for="availablity_4">Availability
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="The amount available each time this promo runs" style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" required="required" maxlength="30" class="form-control" id="availablity_4" name="availablity_4" value="{{ old('availablity_4',$coupons[3]->coupon_availabilty) }}">
                            @if ($errors->has('availablity_4'))
                            <span class="help-block"><strong>{{ $errors->first('availablity_4') }}</strong></span>
                            @endif
                        </div>
                        
                        <div class="form-group col-sm-12 {{ $errors->has('term_condition_4') ? ' has-error' : '' }}">
                            <label for="term_condition_4">Info & Conditions 
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="A quick description of the coupon and basic conditons" data-content="Example: Home made burger with your choice of salad and sauce. No Purchase Necessary, Double Stack Burgers not included. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							</label>
                            <textarea class="form-control" id="term_condition_4" name="term_condition_4">{{ old('term_condition_4',$coupons[3]->terms_conditions) }}</textarea>

                            @if ($errors->has('term_condition_4'))
                            <span class="help-block"><strong>{{ $errors->first('term_condition_4') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('dterm_condition_4') ? ' has-error' : '' }}">
                            <label for="dterm_condition_4">Detailed Terms & Conditions </label>
                            <textarea class="form-control" id="dterm_condition_4" name="dterm_condition_4">{{ $coupons[3]->coupon_information }}</textarea>
                        </div>
                        <div class="form-group col-sm-4 {{ $errors->has('expiery_date_4') ? ' has-error' : '' }}" style="display: none;">
                            <label for="expiery_date_4">Expiry Date</label>
                            <input type="text" class="form-control" id="expiery_date_4" name="expiery_date_4" readonly="readonly" value="Unlimited">
                            @if ($errors->has('expiery_date_4'))
                            <span class="help-block"><strong>{{ $errors->first('expiery_date_4') }}</strong></span>
                            @endif
                        </div>
                        
                        <div class="form-group col-sm-12 {{ $errors->has('estimated_value_4') ? ' has-error' : '' }}">
                            <label for="estimated_value_4">Estimated Value
							<sup class="btn btn-lg btn-xs btn-danger" data-placement="right" data-toggle="popover" title="Information" data-content="Estimate the saving a customer will get by using this coupon. " style="margin-top: -10px; border-radius: 50%;width: 15px;height: 15px;text-align: center;padding: 0px;font-size: 10px;">?</sup>
							
							</label>
                            <input type="text" class="form-control" id="estimated_value_4" name="estimated_value_4" value="{{ old('estimated_value_4',$coupons[3]->estimated_value) }}">
                            @if ($errors->has('estimated_value_4'))
                            <span class="help-block"><strong>{{ $errors->first('estimated_value_4') }}</strong></span>
                            @endif
                        </div>
                        
                        <div class="form-group col-sm-12 image-editor_4 {{ $errors->has('photo_4') ? ' has-error' : '' }}">
                            <label for="photo_4">Image</label> 
                            
                            @if (file_exists('resources/assets/coupons/full/'.$coupons[3]->coupon_photo)) 
                            	<a href="{{ asset('resources/assets/coupons/full/'.$coupons[3]->coupon_photo) }}" target="_blank">Download</a>
                            @else
                            	<a href="{{ asset('resources/assets/coupons/'.$coupons[3]->photo) }}" target="_blank">Download</a>
                            @endif
                            
                            <input type="file" id="photo_4" class="cropit-image-input" name="photo_4" />
                            @if ($errors->has('photo_4'))
                            <span class="help-block"><strong>{{ $errors->first('photo_4') }}</strong></span>
                            @endif
                            
                            <div class="cropit-preview"></div>
                            <div class="image-size-label">
                                Resize image
                            </div>
                            <div class="col-sm-8">
                                <input type="range" class="cropit-image-zoom-input">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" id="crp_4">add it</button>
                            </div>
                            <input type="hidden" name="image_data_4" class="hidden-image-data_4" />
                            
                        </div>
                        <div class="form-group col-sm-12 {{ $errors->has('3d_photo_4') ? ' has-error' : '' }}">
                            <label for="3d_photo_4">3D Coupon</label>
                            <div class="clearfix"></div>
                            <div class="thumbnail" style="width:200px;">
                                @if($coupons[3]->coupon_model != '')
                                        <?PHP
                                        $image = \App\Media::where("image_fbx",$coupons[3]->coupon_model)->first();
                                        
                                        if($image){ $image = $image->image_thumbnail; }else{ $image = ""; }
                                        ?>
                                        <img src="{{ url('resources/assets/media') }}/{{ $image }}" id="usemeforimage_4" />
                                @else
                                        <img src="" id="usemeforimage_4" />
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12"><input type="hidden" id="3d_photo_4" value="{{ $coupons[3]->coupon_model }}" class="cropit-image-input" name="3d_photo_4" />
                                @if($coupons[3]->coupon_model != "") <a style="float: left;" href="#" data-id="{{ $coupons[3]->coupon_model }}" class="model-popupbutton btn btn-info btn-xs" >3D Object</a>@endif
                                <a style="float:left; margin-left:10px;" class="btn btn-primary btn-xs openmodel" data-bind="4" data-id="3d_photo_4" data-toggle="modal" data-target="#myModal">Add 3D Coupon</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <!-- <button type="button" style="float:left" onclick="nexttab('step_3')" class="btn btn-primary">Back</button>  -->
                            <button type="button" style="float:right" onclick="nexttab('step_5')" class="btn btn-primary">Save</button>
                         </div>
             </div>
             <div role="tabpanel" class="tab-pane" id="step_5">
                 <div class="col-sm-6 text-center" style="margin: 0 auto; float: none;">
                     <h1 class="text-center" style="margin-bottom:40px;">Save & Finish All</h1>
                     <div class="clearfix"></div>
                        <!-- <button type="button" style="float:left" onclick="nexttab('step_4')" class="btn btn-primary">Back</button> -->
                        <button type="submit" style="margin-top: 0;" class="btn btn-primary">Finish</button>
                        <div class="clearfix" style="margin-bottom:40px;"></div>
                 </div>
             </div>
		</div>
</div>
<div class="col-sm-6">
    <div class="imagecontainer">
        <div class="heading" id="heading_1">{{ $coupons[0]->coupon_title }}</div>
        <div class="content" id="content_1">
            <div class="goimage"></div>
            <img id="image_1" src="{{ asset('resources/assets/coupons/'.$coupons[0]->photo) }}">
        </div>
        
        <div class="heading" id="heading_2">{{ $coupons[1]->coupon_title }}</div>
        <div class="content" id="content_2">
            <div class="goimage"></div>
            <img id="image_2" src="{{ asset('resources/assets/coupons/'.$coupons[1]->photo) }}">
        </div>
        
        <div class="heading" id="heading_3">{{ $coupons[2]->coupon_title }}</div>
        <div class="content" id="content_3">
            <div class="goimage"></div>
            <img id="image_3" src="{{ asset('resources/assets/coupons/'.$coupons[2]->photo) }}">
        </div>
        
        <div class="heading" id="heading_4">{{ $coupons[3]->coupon_title }}</div>
        <div class="content" id="content_4">
            <div class="goimage"></div>
            <img id="image_4" src="{{ asset('resources/assets/coupons/'.$coupons[3]->photo) }}">
        </div>
    </div>
</div>

        </form>





@endsection
@section('custom_css')
<style type="text/css">
@font-face {
    font-family: american-typewriter-light;
    src: url({{ url('resources/assets/font') }}/ufonts.com_american-typewriter.ttf);
}

    .imagecontainer{ font-family: american-typewriter-light; position: fixed; top: 160px; right: 160px; height: 516px; width:250px; background-position: center; padding: 65px 9px 78px 10px; margin: 0 auto; background-image: url({{ url('resources/assets/user/images/Coupons-on-phone-for-CMS.png') }}); background-repeat: no-repeat; background-size: contain;}
    .imagecontainer .heading{ height: 25px;
                                width: 100%;
                                text-align: center;
                                overflow: hidden;
                                padding-top: 0px;
                                font-size: 15px;  }
    .imagecontainer .content{ height: 68px; width: 100%; text-align: center; overflow: hidden; }
    .imagecontainer .content img{ height: inherit; width: auto; text-align: center; overflow: hidden; }
    .imagecontainer .content .goimage{ 
       /* background-image: url({{ url('resources/assets/user/images/goimage.png') }});*/
        background-repeat: no-repeat;
        background-position: center;
        height: 64px;
        width: 230px;
        position: absolute;
    }
#content_3{ height: 68px; }
#content_4{ height: 68px; margin-top: 2px; }
</style>


<style type="text/css">
      .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 424px;
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
      
      function nexttab(tab){
          $('a[aria-controls="'+tab+'"]').trigger("click");
      }
  $(document).on("click", ".openmodel", function () {
     var myBookId = $(this).data('id');
     $(".modal-body #mediavalue").val(myBookId);
  });
      
      $('.model-popupbutton').on("click",function () {
            var filename = $(this).data('id');
            window.open("{{ url('/') }}/3dobject.php?file="+filename, "3D Model", "height=600,width=600");
       });
      
      $(function() {
           $('a[data-toggle="modal"]').on("click",function(){
            $('#usememodel').attr("data-bind",$(this).attr("data-bind"));
          }); 
          
          $('#usememodel').click(function() {
            var dataid = $(this).attr("data-bind");
            var framecode = $('iframe[id="3dframe"]').contents();
            var value = framecode.find('input[name="choose_image"]:checked').val();
            
            var image = framecode.find('img[id="use_this_image_'+value+'"]').attr("src");
            
            var objval = framecode.find('input[name="use_this_model_'+value+'"]').val();
            $('#usemeforimage_'+dataid).attr("src",image).parent().show();
            $('input[name="3d_photo_'+dataid+'"]').val(objval);
        });
        
        $('.image-editor_1').cropit();
        $('#crp_1').click(function() {
          // Move cropped image data to hidden input
          var imageData = $('.image-editor_1').cropit('export');
          $('.hidden-image-data_1').val(imageData);
          $('#image_1').attr('src',imageData);
         // $('#photo_1').val('').removeAttr("required");
        });
        
        
        $('.image-editor_2').cropit();
        $('#crp_2').click(function() {
          // Move cropped image data to hidden input
          var imageData = $('.image-editor_2').cropit('export');
          $('.hidden-image-data_2').val(imageData);
          $('#image_2').attr('src',imageData);
          // $('#photo_2').val('').removeAttr("required");
        });
        
        $('.image-editor_3').cropit();
        $('#crp_3').click(function() {
          // Move cropped image data to hidden input
          var imageData = $('.image-editor_3').cropit('export');
          $('.hidden-image-data_3').val(imageData);
          $('#image_3').attr('src',imageData);
          // $('#photo_3').val('').removeAttr("required");
        });
        
        $('.image-editor_4').cropit();
        $('#crp_4').click(function() {
          // Move cropped image data to hidden input
          var imageData = $('.image-editor_4').cropit('export');
          $('.hidden-image-data_4').val(imageData);
          $('#image_4').attr('src',imageData);
          // $('#photo_4').val('').removeAttr("required");
        });
        
      });
    </script>
<script type="text/javascript">
      /*  function readURL(input,id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_'+id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
*/
        function setheading(id){
            var value = $('input[name="coupon_name_'+id+'"]').val();
            $('#heading_'+String(id)).text(value);
        }
        
        function promos(){
            var company_name = $('#company_name').val();
            $.get("{{ url('admin/coupons/promos/') }}/"+company_name,{company_name:company_name},function(data){
                $('#promo_name').html(data);
                $("#promo_name option").each(function() {
                    if($(this).attr('value') === '{{ $coupons[0]->promo_id }}') {
                      $(this).attr('selected', 'selected');            
                    }                        
                });
            });
        }
        
    $(document).ready(function(){
        promos();
        //$('select[name="promo_name"]').val('{{ $coupons[0]->promo_id }}');
        
       /* if(window.innerWidth < 1024){
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