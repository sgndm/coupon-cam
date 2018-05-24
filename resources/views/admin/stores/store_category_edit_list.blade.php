@extends('layouts.admin')
@section('content')
<span class="pull-right" style="display: inline; margin-bottom: 5px;">
    
    <form role="form" method="POST" action="{{ url('/admin/stores/category/filter') }}" >
    <a href="{{ url('admin/stores/category/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Create</a>
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
<div class="col-sm-6">
    <form role="form" method="POST" action="{{ url('/admin/stores/category/update') }}">
    {{ csrf_field() }}
    <input type="hidden" name="formid" value="{{ $storecategory->id }}" />
    <div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name">Category Name</label>
        <input type="text" class="form-control" required="required" id="name" name="name" value="{{ old('name',$storecategory->category) }}" placeholder="Enter Name">
        @if ($errors->has('name'))
        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
        @endif
    </div> 
    <div class="form-group col-sm-12">
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div>

</form>
</div>
<div class="col-sm-6">
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>Name</th>
            <th style="width: 80px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $storecategory)
        <tr>
            <th>{{ $storecategory->category }}</th>
            <th>
                <a href="{{ url('admin/stores/category/edit/'.$storecategory->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a>
                <a href="{{ url('admin/stores/category/delete/'.$storecategory->id) }}" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>  
</div>
@endsection