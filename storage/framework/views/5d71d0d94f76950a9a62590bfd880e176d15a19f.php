<?php $__env->startSection('content'); ?>

<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/admin/gw_coupon/save')); ?>">
  <?php echo e(csrf_field()); ?>

  <div class="col-sm-12 col-md-12 col-lg-6">

    <div class="form-group col-sm-12">
      <label for="name">Select Red Friday Promo </label>
      <select class="form-control" name="promo_name" id="promo_name">
        <option value="0">-- Select a Red Friday Promo</option>
        <?php if(sizeof($red_promos) > 0): ?>
          <?php $__currentLoopData = $red_promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
            <option value="<?php echo e($promo->promo_id); ?>"> <?php echo e($promo->promo_name); ?> </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        <?php endif; ?>
      </select>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_name">Coupon Name</label>
      <input type="text" class="form-control" id="coupon_name" name="coupon_name" value=""   required>
    </div>

    <div class="form-group col-sm-12">
      <label for="availability">Availability</label>
      <input type="text" class="form-control" id="availability" name="availability" value=""   required>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_value">Estimated Value</label>
      <input type="text" class="form-control" id="coupon_value" name="coupon_value" value=""   required>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_photo">Coupon Photo</label>
      <input type="file" name="coupon_photo" id="coupon_photo"  required>
    </div>


  </div>
  <div class="col-sm-12 col-md-12 col-lg-6">

    <div class="form-group col-sm-12">
      <label for="coupon_info">Coupon Info & Basic Conditions</label>
      <textarea type="text" class="form-control" id="coupon_info" name="coupon_info" value="" placeholder="" required></textarea>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_details">Detailed Terms & Conditions</label>
      <textarea type="text" class="form-control" id="coupon_details" name="coupon_details" value="" placeholder="" required></textarea>
    </div>

    <div class="form-group col-sm-12">
      <label for="coupon_ar">Coupon AR Model</label>
      <input type="file" name="coupon_ar" id="coupon_ar"  required>
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