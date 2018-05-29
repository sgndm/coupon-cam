@extends('layouts.admin')
@section('content')
{{--<span class="pull-right" style="display: inline; margin-bottom: 5px;">--}}
    {{----}}
    {{--<form role="form" method="POST" action="{{ url('/admin/stores/category/filter') }}" >--}}
    {{--<!-- <a href="{{ url('admin/stores/category/create') }}" class="btn btn-default"><i class="fa fa-plus"></i> New Category</a> -->--}}
    {{--<!-- {{ csrf_field() }}--}}
        {{--<input type="text" class="form-control" style="display: inline; width: inherit; height: inherit; padding: 5px 10px 7px 10px !important" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name or Email">--}}
        {{--<select class="form-control" style="display: inline; width: inherit; height: inherit; padding: 5px 10px 7px 10px !important" id="usertype" name="usertype">--}}
            {{--<option value="3" @if(old('usertype') == '3') selected="" @endif>All</option>--}}
            {{--<option value="1" @if(old('usertype') == '1') selected="" @endif>User</option>--}}
            {{--<option value="0" @if(old('usertype') == '0') selected="" @endif>Administrator</option>--}}
        {{--</select>--}}
        {{--<button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-filter"></i></button> -->--}}
    {{--</form>--}}
{{--</span>--}}

<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <h4 class="text-center">Business Types</h4><hr>
        <form role="form" method="POST" action="{{ url('/admin/stores/category/business/save') }}">
        {{ csrf_field() }}

            <div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">New Business Type</label>
                <input type="text" class="form-control" required="required" id="business" name="business" value="{{ old('business') }}" placeholder="Enter Business Type">
                @if ($errors->has('business'))
                    <span class="help-block"><strong>{{ $errors->first('business') }}</strong></span>
                @endif
            </div>

            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>

        </form>

        <div class="col-sm-12 col-md-12 col-lg-12">
            <br>
            <table class="table" id="busines_type_tbl">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(sizeof($business_types) > 0)
                        @foreach($business_types as $type)
                            <tr>
                            <td> {{ $type->business }} </td>
                            <td>
                                <a href="{{ url('admin/stores/category/delete_type/'.$type->id) }}" class="btn btn-xs btn-danger pull-right">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <h4 class="text-center">Categories</h4><hr>
        <form role="form" method="POST" action="{{ url('/admin/stores/category/save') }}">
        {{ csrf_field() }}

            <div class="form-group col-sm-6 {{ $errors->has('type') ? ' has-error' : '' }}">
                <label for="type">Business Type</label>
                <select class="form-control" id="type" name="type" value="{{ old('type') }}" required>
                    <option>Select Business Type</option>
                    @if(sizeof($business_types) > 0)
                        @foreach($business_types as $type)
                           <option value="{{ $type->id }}">{{ $type->business }}</option>
                        @endforeach
                    @endif
                </select>
                @if ($errors->has('type'))
                    <span class="help-block"><strong>{{ $errors->first('type') }}</strong></span>
                @endif
            </div>
            <div class="form-group col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">New Category</label>
                <input type="text" class="form-control" required="required" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>


        </form>

        <div class="col-sm-12 col-md-12 col-lg-12">
            <br>
            <table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Business Type</th>
                    <th style="width: 80px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $storecategory)
                    <tr>
                        <th>{{ $storecategory->category }}</th>
                        <th>{{ $storecategory->business }}</th>
                        <th>
                            <a href="{{ url('admin/stores/category/edit/'.$storecategory->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a>
                            <a href="{{ url('admin/stores/category/delete/'.$storecategory->id) }}" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection