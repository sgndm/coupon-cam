<?php $__env->startSection('content'); ?>

<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/admin/red_promos/save')); ?>">
  <?php echo e(csrf_field()); ?>


  <div class="form-group col-sm-12 col-md-12 col-lg-6">
    <label for="promo_id">Select a Promo </label>
     <select class="form-control" id="promo_list" name="promo_list" required onchange="get_stores();">
       <option value="0" > -- Select a Promo -- </option>
       <?php $__currentLoopData = $red_promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <option value="<?php echo e($promo->promo_id); ?>"> <?php echo e($promo->promo_name); ?></option>
       <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </select>
  </div>

  <div class="form-group col-sm-12 col-md-12 col-lg-6">
    <label for="promo_id">Select a Store </label>
     <select class="form-control" id="store_list" name="store_list" required onchange="get_coupons();">
       <option value="0" > -- Select a Store -- </option>
    </select>
  </div>
  <!-- <div class="col-sm-12 col-md-12 col-lg-12"></div> -->
  <div class="form-group col-sm-12 col-md-12 col-lg-12" >
    <hr>
    <h4 class="text-center">Coupons Available in the Store </h4>
    <table id="to_add_list" class="display table table-striped table-responsive" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>
                <th>#</th>
                <th>Coupon Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="cp_list">

        </tbody>
    </table>
  </div>

  <div class="form-group col-sm-12 col-md-12 col-lg-12" style="display: block;">
    <hr>
    <h4 class="text-center">All Coupons for This Promo </h4>
    <table id="added_list" class="display table table-striped table-responsive" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>
              <th>#</th>
              <th>Coupon Name</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody id="cp_list_added">

        </tbody>
    </table>
  </div>



</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_js'); ?>
<script type="text/javascript">
  // $('#to_add_list').DataTable({});
  // $('#added_list').DataTable({});
</script>

<script type="text/javascript">

  function get_stores() {
    var promo_id = $('#promo_list').val();
    // get store list
    if(promo_id > 0) {

      $.get("<?php echo e(url('admin/red_promos/get_stores')); ?>/"+promo_id,function(data){

        var html_t = [];
        var stores = data['stores'];
        var coupons = data['coupons'];

        html_t.push("<option value='0' > -- Select a nearby store -- </option>");
        // add to store list
        for(var x =0; x < stores.length; x++) {
          html_t.push("<option value='" + stores[x]['store_id'] + "' > " + stores[x]['store_name'] + " </option> ");
        }

        $("#store_list").html(html_t);

        // create tabel
        $("#cp_list_added").html('');
        var table;
        for(var y = 0; y < coupons.length; y++) {
          table += "<tr id='r_" + coupons[y]['coupon_id']  + "'><td>" + (y+1) + "</td><td>" + coupons[y]['coupon_title'] + "</td><td>" + coupons[y]['coupon_information'] + "</td><td> <button type='button' class='btn btn-danger' onclick='remove_from_promo(" + coupons[y]['coupon_id'] + ");' >Remove Coupon</button> </td></tr> ";
        }

        $('#cp_list_added').html(table);

      });

    }
     else {
        $("#store_list").html("<option value='0' > -- Select a Store -- </option>");
        $("#cp_list_added").html('');
     }
  }


  function get_coupons() {
    //alert('dsdd');
    var store_id = $('#store_list').val();
    var promo_id = $('#promo_list').val();

    // get store list
    if((store_id > 0) && (promo_id > 0)) {

      $.get("<?php echo e(url('admin/red_promos/get_coupons')); ?>/"+promo_id+"/"+store_id,function(data){
        //console.log(data[0]['coupon_title'] );
        // create tabel
        $('#cp_list').html('');
        var table;
        for(var y = 0; y < data.length; y++) {
          table += "<tr id='r_" + data[y]['coupon_id'] + "'><td>" + (y+1) + "</td><td>" + data[y]['coupon_title'] + "</td><td>" + data[y]['coupon_information'] + "</td><td> <button type='button' class='btn btn-danger' onclick='add_to_promo(" + data[y]['coupon_id'] + ");' >Add Coupon</button> </td></tr>";
        }

        $('#cp_list').html(table);
      });

    }
    else {
      $('#cp_list').html('');
      console.log("store id is < 0");
     }

  }


  // add to promo
  function add_to_promo(coupon_id) {
    var promo_id = $('#promo_list').val();
    var store_id = $('#store_list').val();

    if( (promo_id > 0) && (store_id > 0) && (coupon_id > 0) ){
      // add to data base
      $.get("<?php echo e(url('admin/red_promos/save_coupon')); ?>/"+promo_id+"/"+store_id+"/"+coupon_id,function(data){

        if(data['status'] == 1) {
          // hide row
          $('#r_'+coupon_id).hide();

          // add row to other table
          var coupons = data['coupon'];

          var rowCount = $('#cp_list_added tr').length;

          var row = "<tr id='r_" + coupons[0]['coupon_id']  + "'><td>" + (rowCount + 1)  + "</td><td>" + coupons[0]['coupon_title'] + "</td><td>" + coupons[0]['coupon_information'] + "</td><td> <button type='button' class='btn btn-danger' onclick='remove_from_promo(" + coupons[0]['coupon_id'] + ");' >Remove Coupon</button> </td></tr> ";

          // append to table
          $('#cp_list_added').append(row);
        }

      });

    }


  }

  function remove_from_promo(coupon_id) {
    var promo_id = $('#promo_list').val();

    if( (promo_id > 0) && (coupon_id > 0) ){
      // add to data base
      $.get("<?php echo e(url('admin/red_promos/remove_coupon')); ?>/"+promo_id+"/"+coupon_id,function(data){

        if(data['status'] == 1) {
          // hide row
          $('#r_'+coupon_id).hide();

          // add row to other table
          var coupons = data['coupon'];

          var rowCount = $('#cp_list tr').length;

          var row = "<tr id='r_" + coupons[0]['coupon_id']  + "'><td>" + (rowCount + 1) + "</td><td>" + coupons[0]['coupon_title'] + "</td><td>" + coupons[0]['coupon_information'] + "</td><td> <button type='button' class='btn btn-danger' onclick='add_to_promo(" + coupons[0]['coupon_id'] + ");' >Add Coupon</button> </td></tr> ";

          // append to table
          $('#cp_list').append(row);
        }

      });
    }

  }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>