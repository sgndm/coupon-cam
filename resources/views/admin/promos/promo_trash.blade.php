@extends('layouts.admin')
@section('content')
<a href="{{ url('admin/promos') }}" class="btn btn-default pull-right" style=" margin-bottom: 5px;"><i class="fa fa-briefcase"></i> Promos</a>
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Start Time</th>
            <th>Lenght</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($promos as $promo)
        <tr>
            <th>{{ $promo->promo_name }}</th>
            <th>{{ date('H:i A',strtotime($promo->start_at)) }}</th>
            <th>{{ $promo->promo_lenght }} @if($promo->promo_lenght == 1) hour @else hours @endif</th>
            <th>{{ date('d-m-Y',strtotime($promo->created_at)) }}</th>
            <th>{{ date('d-m-Y',strtotime($promo->updated_at)) }}</th>
            <th>
                <a href="{{ url('admin/promos/restore/'.$promo->promo_id) }}" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></a>
                <a href="{{ url('admin/promos/clear/'.$promo->promo_id) }}" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>  

@endsection