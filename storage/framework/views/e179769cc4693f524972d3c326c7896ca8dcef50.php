<?php $__env->startSection('content'); ?>

<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/admin/red_promos/save')); ?>">
  <?php echo e(csrf_field()); ?>

  <div class="col-sm-12 col-md-12 col-lg-6">

    <div class="form-group col-sm-12">
      <label for="name">Coupon Name</label>
      <input type="text" class="form-control" id="promo_name" name="promo_name" value="" placeholder="Enter Name" required>
    </div>

    <div class="form-group col-sm-12">
      <label for="name">Availability</label>
      <input type="text" class="form-control" id="promo_name" name="promo_name" value="" placeholder="Enter Name" required>
    </div>

    <div class="form-group col-sm-12">
      <label for="name">Estimated Value</label>
      <input type="text" class="form-control" id="promo_name" name="promo_name" value="" placeholder="Enter Name" required>
    </div>

    <div class="form-group col-sm-12">
      <label for="red_photo">Coupon Photo</label>
      <input type="file" name="red_photo" id="red_photo"  required>
    </div>


  </div>
  <div class="col-sm-12 col-md-12 col-lg-6">

    <div class="form-group col-sm-12">
      <label for="name">Coupon Info & Basic Conditions</label>
      <textarea type="text" class="form-control" id="promo_name" name="promo_name" value="" placeholder="" required></textarea>
    </div>

    <div class="form-group col-sm-12">
      <label for="name">Detailed Terms & Conditions</label>
      <textarea type="text" class="form-control" id="promo_name" name="promo_name" value="" placeholder="" required></textarea>
    </div>

    <div class="form-group col-sm-12">
      <label for="red_photo">Coupon AR Model</label>
      <input type="file" name="red_photo" id="red_photo"  required>
    </div>

    <div class="form-group col-sm-12">
      <input type="submit" name="submit" value="Submit" class="btn btn-primary pull-right">
    </div>

  </div>

</form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>