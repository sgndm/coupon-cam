@extends('layouts.admin')
@section('content')
<span class="pull-right" style="display: inline; margin-bottom: 5px;">
    
    <form role="form" method="POST" action="{{ url('/admin/coupons/filter') }}" >
    <!-- <a href="{{ url('admin/coupons/trash') }}" class="btn btn-default"><i class="fa fa-trash"></i> Trash</a> -->
    <a href="{{ url('admin/coupons/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> New Coupon</a>
    <!-- {{ csrf_field() }}
        <input type="text" class="form-control" style="display: inline; width: inherit; height: inherit; padding: 5px 10px 7px 10px !important" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name or Email">
        <select class="form-control" style="display: inline; width: inherit; height: inherit; padding: 5px 10px 7px 10px !important" id="usertype" name="usertype">
            <option value="3" @if(old('usertype') == '3') selected="" @endif>All</option>
            <option value="1" @if(old('usertype') == '1') selected="" @endif>User</option>
            <option value="0" @if(old('usertype') == '0') selected="" @endif>Administrator</option>
        </select>
        <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-filter"></i></button> -->
    </form>
</span>
<?PHP print_r($coupons); ?>
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Promo</th>
            <!--<th>Ends At</th>-->
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coupons as $coupon)
        <tr>
            <th>{{ $coupon->coupon_title }}</th>
            <th><a href="{{ url('admin/coupons/promo/'.$coupon->promo_id) }}">{{ $coupon->promo }}</a></th>
            
            <!--<th>@if($coupon->end_at == '') Unlimited @else {{ date('d-m-Y',strtotime($coupon->end_at)) }}@endif</th>-->
            <th>{{ date('d-m-Y',strtotime($coupon->created_at)) }}</th>
            <th>{{ date('d-m-Y',strtotime($coupon->updated_at)) }}</th>
            <th>
                <!-- <a href="{{ url('admin/coupons/'.$coupon->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a> -->
                <a href="{{ url('admin/coupons/edit/'.$coupon->promo_id) }}" class="btn btn-xs btn-primary"><i class="fa fa-archive"></i></a>
              <!--   <a href="{{ url('admin/coupons/delete/'.$coupon->id) }}" onclick="return confirm<!--('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a> -->
            </th> 
        </tr>
        @endforeach
    </tbody>
</table>  

@endsection