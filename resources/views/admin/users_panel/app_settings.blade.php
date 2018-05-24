@extends('layouts.admin')
@section('content')

<div class="row justify-content-center">

  <div class="col-sm-12 col-md-4 col-lg-4">

    <div class="col-sm-12 col-md-12 col-lg-12">
      <h3 class="text-center">App Settings</h3><hr>
      <form role="form" method="POST" action="{{ url('/change_settings') }}">
          {{ csrf_field() }}

          @if($pre_launch == 0)
          <h4 class="text-center">Main Launch Is Active</h4>
          <div class="col-md-12 text-center">
            <button type="submit" name="act_pre" class="btn btn-danger" >Activate Pre Launch</button>
          </div>
          @else
          <h4 class="text-center">Pre Launch Is Active</h4>
          <div class="col-md-12 text-center">
            <button type="submit" name="act_main" class="btn btn-danger " >Activate Main Launch</button>
          </div>
          @endif

      </form>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12">
      <br><br>
      <form role="form" method="POST" action="{{ url('/change_app_version') }}">
          {{ csrf_field() }}
        <h3 class="text-center">App Version</h3><hr>
        <div class="form-group col-sm-12">
          <!-- <label for="" class="text-center">App Version</label> -->
          <input type="number" class="form-control" name="app_version" id="app_version" value="{{ $app_version }}" min="0" step="1">
        </div>
        <div class="form-group col-sm-12 text-center">
          <input type="submit" name="submit" value="Update App Version" class="btn btn-danger">
        </div>
      </form>
    </div>


  </div>

  <div class="col-sm-12 col-md-4 col-lg-4">
    <h3 class="text-center">Coupon Extend Values</h3><hr>
    <form role="form" method="POST" action="{{ url('/update_extend_values') }}">
        {{ csrf_field() }}

        <table class="table">
          <tr class="text-center">
            <td>Country</td>
            <td>Value</td>
          </tr>
          <tr>
            <td>
              <label>United Kingdom</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_uk" name="val_uk" value="{{ $e_gb }}" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>United States</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_us" name="val_us" value="{{ $e_us }}" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>Australia</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_au" name="val_au" value="{{ $e_au }}" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>Caneda</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_ca" name="val_ca" value="{{ $e_ca }}" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>New Zealand</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_nz" name="val_nz" value="{{ $e_nz }}" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>

            </td>
            <td>
              <input type="submit" name="" value="Update Values" class="btn btn-primary pull-right">
            </td>
          </tr>
        </table>

    </form>
  </div>

  <div class="col-sm-12 col-md-4 col-lg-4">
    <h3 class="text-center">Savings Limit</h3><hr>
    <form role="form" method="POST" action="{{ url('/update_save_limit') }}">
        {{ csrf_field() }}

      <div class="form-group">
        <!-- <label for="saving_limit"> Savings Limit</label> -->
        <input type="number" name="saving_limit" value="{{ $saving_limit }}" class="form-control" min="0" step="0.01" required>
      </div>

    <div class="form-group">
      <input type="submit" name="submit" value="Update Save Limit" class="btn btn-primary pull-right">
    </div>

    </form>
  </div>


</div>


@endsection

@section('custom_js')

@endsection
