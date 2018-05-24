@extends('layouts.admin')
@section('content')

<div class="form-group col-sm-12 col-md-12 col-lg-12" >
  <hr>
  <h4 class="text-center">Active Red Friday Fromos </h4>
  <table id="to_add_list" class="display table table-striped table-responsive" style="width: 100%; cellspacing: 0;">
      <thead>
          <tr>
              <th>#</th>
              <th>Promo Name </th>
              <th>Promo Date</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody id="tbl_avtive_list">
        @foreach($active_promos as $key => $promo)
          <tr id="r_{{ $promo->promo_id }}">
            <td> {{ $key + 1 }} </td>
            <td> {{ $promo->promo_name }} </td>
            <td> {{ $promo->start_date }} </td>
            <td> {{ $promo->start_at }} </td>
            <td> {{ $promo->end_at }} </td>
            <td> <button type="button" class="btn btn-danger" onclick="pause_promo( {{ $promo->promo_id }} );" >Pause Promo</button> </td>
          </tr>
        @endforeach
      </tbody>
  </table>
</div>

<div class="form-group col-sm-12 col-md-12 col-lg-12" >
  <hr>
  <h4 class="text-center">Paused Red Friday Promos </h4>
  <table id="added_list" class="display table table-striped table-responsive" style="width: 100%; cellspacing: 0;">
      <thead>
          <tr>
              <th>#</th>
              <th>Promo Name </th>
              <th>Promo Date</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody id="tbl_inactive_list">
        @foreach($inactive_promos as $key => $promo)
          <tr id="r_{{ $promo->promo_id }}">
            <td> {{ $key + 1 }} </td>
            <td> {{ $promo->promo_name }} </td>
            <td> {{ $promo->start_date }} </td>
            <td> {{ $promo->start_at }} </td>
            <td> {{ $promo->end_at }} </td>
            <td> <button type="button" class="btn btn-danger" onclick="activate_promo( {{ $promo->promo_id }} );" >Activate Promo</button> </td>
          </tr>
        @endforeach
      </tbody>
  </table>
</div>
@endsection

@section('custom_js')

<script type="text/javascript">

  $('#to_add_list').DataTable({});
  $('#added_list').DataTable({});

  function pause_promo(promo_id) {

    $.get("{{ url('admin/red_promos/pause_promo') }}/"+promo_id,function(data){

      if(data['status'] == 1) {
        $('#r_'+promo_id).hide();

        var promo = data['promo'];
        var rowCount = $('#tbl_inactive_list tr').length;

        var row = "<tr id='r_'"+promo_id+"><td> "+ (rowCount + 1) +" </td> <td>" + promo[0]['promo_name'] + "</td> <td>" + promo[0]['start_date'] + "</td> <td>" + promo[0]['start_at'] + "</td> <td>" + promo[0]['end_at'] + "</td> <td> <button type='button' class='btn btn-danger' onclick='activate_promo("+promo_id+");' >Activate Promo</button> </td>  </tr>";

        $('#tbl_inactive_list').append(row);
      }
      else {
        alert('error');
      }

    });

  }

  function activate_promo(promo_id) {

    $.get("{{ url('admin/red_promos/activate_promo') }}/"+promo_id,function(data){

      if(data['status'] == 1) {
        $('#r_'+promo_id).hide();

        var promo = data['promo'];
        var rowCount = $('#tbl_avtive_list tr').length;

        var row = "<tr id='r_'"+promo_id+"><td> "+ (rowCount + 1) +" </td> <td>" + promo[0]['promo_name'] + "</td> <td>" + promo[0]['start_date'] + "</td> <td>" + promo[0]['start_at'] + "</td> <td>" + promo[0]['end_at'] + "</td> <td> <button type='button' class='btn btn-danger' onclick='pause_promo("+promo_id+");' >Pause Promo</button> </td>  </tr>";

        $('#tbl_avtive_list').append(row);
      }
      else {
        alert('error');
      }

    });

  }

</script>
@endsection
