@extends('layouts.admin')
@section('content')

<form role="form" method="POST" enctype="multipart/form-data" action="{{ url('admin/coupons/single/create') }}">
  {{ csrf_field() }}
  <div class="col-sm-12 col-md-12 col-lg-6">

    <div class="form-group col-sm-12 {{ $errors->has('company_name') ? ' has-error' : '' }}">
        <label for="company_name">Company</label>
        <select class="form-control" id="company_name" onchange="get_promos();" name="company_name">
          <option value="">-- select User --</option>
            @foreach($users as $key => $user)
                <option value="{{ $user->id }}" >{{ $user->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('company_name'))
        <span class="help-block"><strong>{{ $errors->first('company_name') }}</strong></span>
        @endif
    </div>

    <div class="form-group col-sm-12">
      <label for="name">Select Promo </label>
      <select class="form-control" name="promo_name" id="promo_name">
        <option value="0">-- Select a Promo</option>
        @if(sizeof($promos) > 0)
          @foreach($promos as $promo)
            <option value="{{ $promo->promo_id }}"> {{ $promo->promo_name }} </option>
          @endforeach
        @endif
      </select>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_name">Coupon Name</label>
      <input type="text" class="form-control" id="coupon_name" name="coupon_name" value=""   required>
    </div>

    <div class="form-group col-sm-12">
      <label for="availability">Availability</label>
      <input type="text" class="form-control" id="availability" name="availability" value=""   required>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_value">Estimated Value</label>
      <input type="text" class="form-control" id="coupon_value" name="coupon_value" value=""   required>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_photo">Coupon Photo</label>
      <input type="file" name="coupon_photo" id="coupon_photo"  required>
    </div>


  </div>
  <div class="col-sm-12 col-md-12 col-lg-6">

    <div class="form-group col-sm-12">
      <label for="coupon_info">Coupon Info & Basic Conditions</label>
      <textarea type="text" class="form-control" id="coupon_info" name="coupon_info" value="" placeholder="" required></textarea>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_details">Detailed Terms & Conditions</label>
      <textarea type="text" class="form-control" id="coupon_details" name="coupon_details" value="" placeholder="" required></textarea>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_ar">Coupon AR Model</label>
      <input type="file" name="coupon_ar" id="coupon_ar"  required>
    </div>

    <div class="form-group col-sm-12">
      <input type="submit" name="submit" value="Submit" class="btn btn-primary pull-right">
    </div>

  </div>

</form>

@endsection

@section('custom_js')

<script type="text/javascript">
  function get_promos() {
    var company = $('#company_name').val();
    //alert(company);
    $.get("{{ url('admin/coupons/get_promos') }}/"+parseInt(company),function(data){
        console.log(data);

        var html_t = [];
        html_t.push("<option value=''>-- select Promo --</option>");
        for(var i = 0; i < data.length; i++) {
          html_t.push("<option value='" + data[i]['promo_id'] + "'> " + data[i]['promo_name'] + " </option>");
        }

        $('#promo_name').html(html_t);

    });
  }
</script>

@endsection
