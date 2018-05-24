@extends('layouts.admin')
@section('content')
<a href="{{ url('admin/users') }}" class="btn btn-default pull-right" style=" margin-bottom: 5px;"><i class="fa fa-users"></i> Users</a>
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>User Type</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <th>{{ $user->name }}</th>
            <th>{{ $user->email }}</th>
            <th style="max-width:150px;"><div style="max-height: 22px; overflow: hidden;">{{ $user->contact }}</div></th>
            <th>@if($user->usertype == 1) User @else Administrator @endif</th>
            <th>{{ date('d-m-Y',strtotime($user->created_at)) }}</th>
            <th>{{ date('d-m-Y',strtotime($user->updated_at)) }}</th>
            <th>
                <a href="{{ url('admin/users/restore/'.$user->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></a>
                <a href="{{ url('admin/users/clear/'.$user->id) }}" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>  

@endsection