<?php $__env->startSection('upper_content'); ?>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter"><?php echo e($users); ?></p>
                    <span class="info-box-title">Total Active Users</span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-users"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter"><?php echo e($stores); ?></p>
                    <span class="info-box-title">Total Active Stores</span>
                </div>
                <div class="info-box-icon">
                    <i class="icon-home"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter"><?php echo e($promos); ?></p>
                    <span class="info-box-title">Active Promos</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-briefcase"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p><span class="counter"><?php echo e($coupons); ?></span></p>
                    <span class="info-box-title">Active Coupons</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="info-box-progress">
                    <div class="progress progress-xs progress-squared bs-n">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- Row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

        <h2>Notifications</h2>

    <div class="clearfix"></div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td style="width:20px;">#</td>
            <td>Message</td>
            <td style="width:50px;">View</td>
        </tr>
    <tbody>
        <?php $count = 0; ?>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <?php $count += 1 ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td>You have <?php echo e(\App\Common::GetTotalNotify($notification->user_id)); ?> notifications from <?php echo e(\App\Common::UserInfo($notification->user_id)->name); ?>.</td>
            <td><a href="<?php echo e(url('admin/notify')); ?>/<?php echo e($notification->user_id); ?>" class="btn btn-xs btn-primary">view</a></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </tbody>
    </thead>
</table>
<div class="clearfix"></div>
<div class="pagination">
   <?php echo e($notifications->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_css'); ?>
<link href="<?php echo e(asset('resources/assets/user/plugins/metrojs/MetroJs.min.css')); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo e(asset('resources/assets/user/plugins/toastr/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>
<script type="text/javascript" src="<?php echo e(asset('resources/assets/user/plugins/metrojs/MetroJs.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>