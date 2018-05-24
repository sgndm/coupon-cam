@extends('layouts.admin')
@section('content')
<a href="{{ url('admin/coupons') }}" class="btn btn-default pull-right" style=" margin-bottom: 5px;"><i class="fa fa-gift"></i> Coupons</a>
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Store</th>
            <th>Start Time</th>
            <th>Lenght</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coupons as $coupon)
        <tr>
            <th>{{ $coupon->coupon_title }}</th>
            <th>{{ $coupon->company }}</th>
            <th>@if($coupon->end_at == '') Unlimited @else {{ date('d-m-Y',strtotime($coupon->end_at)) }}@endif</th>
            <th>{{ $coupon->promo_lenght }} @if($coupon->promo_lenght == 1) hour @else hours @endif</th>
            <th>{{ date('d-m-Y',strtotime($coupon->created_at)) }}</th>
            <th>{{ date('d-m-Y',strtotime($coupon->updated_at)) }}</th>
            <th>
                <a href="{{ url('admin/coupons/restore/'.$coupon->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></a>
                <a href="{{ url('admin/coupons/clear/'.$coupon->id) }}" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>  

@endsection