<?php $__env->startSection('content'); ?>

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
        <?php $__currentLoopData = $active_promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
          <tr id="r_<?php echo e($promo->promo_id); ?>">
            <td> <?php echo e($key + 1); ?> </td>
            <td> <?php echo e($promo->promo_name); ?> </td>
            <td> <?php echo e($promo->start_date); ?> </td>
            <td> <?php echo e($promo->start_at); ?> </td>
            <td> <?php echo e($promo->end_at); ?> </td>
            <td> <button type="button" class="btn btn-danger" onclick="pause_promo( <?php echo e($promo->promo_id); ?> );" >Pause Promo</button> </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
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
        <?php $__currentLoopData = $inactive_promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
          <tr id="r_<?php echo e($promo->promo_id); ?>">
            <td> <?php echo e($key + 1); ?> </td>
            <td> <?php echo e($promo->promo_name); ?> </td>
            <td> <?php echo e($promo->start_date); ?> </td>
            <td> <?php echo e($promo->start_at); ?> </td>
            <td> <?php echo e($promo->end_at); ?> </td>
            <td> <button type="button" class="btn btn-danger" onclick="activate_promo( <?php echo e($promo->promo_id); ?> );" >Activate Promo</button> </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
      </tbody>
  </table>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

<script type="text/javascript">

  $('#to_add_list').DataTable({});
  $('#added_list').DataTable({});

  function pause_promo(promo_id) {

    $.get("<?php echo e(url('admin/red_promos/pause_promo')); ?>/"+promo_id,function(data){

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

    $.get("<?php echo e(url('admin/red_promos/activate_promo')); ?>/"+promo_id,function(data){

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>