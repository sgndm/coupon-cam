<?php $__env->startSection('content'); ?>

<div class="col-md-12">
    <div class="card">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab" onclick="create_tab();">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                    <span class="hidden-xs-down">ACCOUNT INFO</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" onclick="open_tab();">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                    <span class="hidden-xs-down">CHANGE PASSWORD</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab" onclick="cloased_tab();">
                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                    <span class="hidden-xs-down">DEACTIVATE ACCOUNT</span>
                </a>
            </li>
            <li class="nav-item"></li>
            <li class="nav-item"></li>


        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">

                <form role="form" method="POST" action="<?php echo e(url('/profile/update')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <?php if(Auth::user()->usertype == 0): ?>
                    <input type="hidden" name="formid" value="<?php echo e($user->id); ?>" />
                    <?php else: ?>
                    <input type="hidden" name="formid" value="<?php echo e(Auth::id()); ?>" />
                    <?php endif; ?>


                    <div class="col-sm-12 col-md-12 col-lg-12">

                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Company Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="" value="<?php echo e($user->name); ?>" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Company Representitive</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="" value="<?php echo e($user->first_name); ?>" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Position</label>
                            <input type="text" id="position" name="position" class="form-control" placeholder="" value="<?php echo e($user->position); ?>" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="" value="<?php echo e($user->email); ?>" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Phone Number</label>
                            <input type="text" id="contact_details" name="contact_details" class="form-control" placeholder="" value="<?php echo e($user->contact); ?>" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Country</label>
                            <input type="text" id="country" name="country" class="form-control" placeholder="" value="<?php echo e($user->country); ?>" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="userProf" class="col-md-8 custom_btn update"></button>
                        </div>


                    </div>


                </form>

            </div>
            <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                <form role="form" method="POST" action="<?php echo e(url('/settings')); ?>">
                    <?php echo e(csrf_field()); ?>


                    <?php if(Auth::user()->usertype == 0): ?>
                    <input type="hidden" name="formid" value="<?php echo e($user->id); ?>" />
                    <?php else: ?>
                    <input type="hidden" name="formid" value="<?php echo e(Auth::id()); ?>" />
                    <?php endif; ?>

                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                        <label class="control-label">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter Current Password" value="" required>
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                        <label class="control-label">New Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter New Password" value="" required>
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                        <label class="control-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re Enter New Password" value="" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="userSett" class="col-md-8 custom_btn save_c"></button>
                    </div>


                </form>
            </div>
            <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel"></div>
        </div>
    </div>
</div>

















<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.business', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>