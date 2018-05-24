<?php $__env->startSection('content'); ?>

<form role="form" method="POST" action="<?php echo e(url('/change_settings')); ?>">
    <?php echo e(csrf_field()); ?>


    <?php if($pre_launch == 0): ?>
    <h3 class="text-center">Main Launch Is Active</h3>
    <div class="col-md-12 text-center">
      <button type="submit" name="act_pre" class="btn btn-danger" >Activate Pre Launch</button>
    </div>
    <?php else: ?>
    <h3 class="text-center">Pre Launch Is Active</h3>
    <div class="col-md-12 text-center">
      <button type="submit" name="act_main" class="btn btn-danger " >Activate Main Launch</button>
    </div>
    <?php endif; ?>

</form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>