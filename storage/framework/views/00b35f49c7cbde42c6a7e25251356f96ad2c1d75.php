<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">

  <div class="col-sm-12 col-md-4 col-lg-4">

    <div class="col-sm-12 col-md-12 col-lg-12">
      <h3 class="text-center">App Settings</h3><hr>
      <form role="form" method="POST" action="<?php echo e(url('/change_settings')); ?>">
          <?php echo e(csrf_field()); ?>


          <?php if($pre_launch == 0): ?>
          <h4 class="text-center">Main Launch Is Active</h4>
          <div class="col-md-12 text-center">
            <button type="submit" name="act_pre" class="btn btn-danger" >Activate Pre Launch</button>
          </div>
          <?php else: ?>
          <h4 class="text-center">Pre Launch Is Active</h4>
          <div class="col-md-12 text-center">
            <button type="submit" name="act_main" class="btn btn-danger " >Activate Main Launch</button>
          </div>
          <?php endif; ?>

      </form>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12">
      <br><br>
      <form role="form" method="POST" action="<?php echo e(url('/change_app_version')); ?>">
          <?php echo e(csrf_field()); ?>

        <h3 class="text-center">App Version</h3><hr>
        <div class="form-group col-sm-12">
          <!-- <label for="" class="text-center">App Version</label> -->
          <input type="number" class="form-control" name="app_version" id="app_version" value="<?php echo e($app_version); ?>" min="0" step="1">
        </div>
        <div class="form-group col-sm-12 text-center">
          <input type="submit" name="submit" value="Update App Version" class="btn btn-danger">
        </div>
      </form>
    </div>


  </div>

  <div class="col-sm-12 col-md-4 col-lg-4">
    <h3 class="text-center">Coupon Extend Values</h3><hr>
    <form role="form" method="POST" action="<?php echo e(url('/update_extend_values')); ?>">
        <?php echo e(csrf_field()); ?>


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
              <input type="number" class="form-control" id="val_uk" name="val_uk" value="<?php echo e($e_gb); ?>" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>United States</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_us" name="val_us" value="<?php echo e($e_us); ?>" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>Australia</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_au" name="val_au" value="<?php echo e($e_au); ?>" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>Caneda</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_ca" name="val_ca" value="<?php echo e($e_ca); ?>" placeholder="Enter value" required min="0" step="0.01">
            </td>
          </tr>
          <tr>
            <td>
              <label>New Zealand</label>
            </td>
            <td>
              <input type="number" class="form-control" id="val_nz" name="val_nz" value="<?php echo e($e_nz); ?>" placeholder="Enter value" required min="0" step="0.01">
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
    <form role="form" method="POST" action="<?php echo e(url('/update_save_limit')); ?>">
        <?php echo e(csrf_field()); ?>


      <div class="form-group">
        <!-- <label for="saving_limit"> Savings Limit</label> -->
        <input type="number" name="saving_limit" value="<?php echo e($saving_limit); ?>" class="form-control" min="0" step="0.01" required>
      </div>

    <div class="form-group">
      <input type="submit" name="submit" value="Update Save Limit" class="btn btn-primary pull-right">
    </div>

    </form>
  </div>


</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>