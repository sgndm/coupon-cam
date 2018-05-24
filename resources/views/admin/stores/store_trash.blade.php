@extends('layouts.admin')
@section('content')
<a href="{{ url('admin/stores') }}" class="btn btn-default pull-right" style=" margin-bottom: 5px;"><i class="fa fa-briefcase"></i> Stores</a>
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>Name</th>
            <!-- <th>Email</th>
            <th>Contact</th> -->
            <th>Company</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stores as $store)
        <tr>
            <th>{{ $store->name }}</th>
           <!-- <th>{{ $store->email }}</th>
            <th>{{ $store->contact }}</th> -->
            <th>{{ $store->company }}</th>            
            <th>{{ date('d-m-Y',strtotime($store->created_at)) }}</th>
            <th>{{ date('d-m-Y',strtotime($store->updated_at)) }}</th>
            <th>
                <a href="{{ url('admin/stores/edit/'.$store->place_id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a>
                <!-- <a href="{{ url('admin/stores/delete/'.$store->id) }}" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a> -->
            </th>
        </tr>
        @endforeach
    </tbody>
</table>  

@endsection