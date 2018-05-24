<?php $__env->startSection('content'); ?>

                    <form class="form-horizontal" role="form" class="login-form" method="POST" action="<?php echo e(url('/login')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email" required autofocus>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control"  placeholder="Password" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-left">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" style="width: 20px;" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                <p style="padding: 0px 15px; text-align: center;">
                                <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">
                                    Forgot Your Password?
                                </a>
                                </p>
                            </div>
                        </div>
                    </form>
               
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>