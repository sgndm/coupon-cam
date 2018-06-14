<?php $__env->startSection('content'); ?>

    
    
    
    
        
        
            
            
            
        
        
    


<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <h4 class="text-center">Business Types</h4><hr>
        <form role="form" method="POST" action="<?php echo e(url('/admin/stores/category/business/save')); ?>">
        <?php echo e(csrf_field()); ?>


            <div class="form-group col-sm-6 <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                <label for="name">New Business Type</label>
                <input type="text" class="form-control" required="required" id="business" name="business" value="<?php echo e(old('business')); ?>" placeholder="Enter Business Type">
                <?php if($errors->has('business')): ?>
                    <span class="help-block"><strong><?php echo e($errors->first('business')); ?></strong></span>
                <?php endif; ?>
            </div>

            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>

        </form>

        <div class="col-sm-12 col-md-12 col-lg-12">
            <br>
            <table class="table" id="busines_type_tbl">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(sizeof($business_types) > 0): ?>
                        <?php $__currentLoopData = $business_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <tr>
                            <td> <?php echo e($type->business); ?> </td>
                            <td>
                                <a href="<?php echo e(url('admin/stores/category/delete_type/'.$type->id)); ?>" class="btn btn-xs btn-danger pull-right">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <h4 class="text-center">Categories</h4><hr>
        <form role="form" method="POST" action="<?php echo e(url('/admin/stores/category/save')); ?>">
        <?php echo e(csrf_field()); ?>


            <div class="form-group col-sm-6 <?php echo e($errors->has('type') ? ' has-error' : ''); ?>">
                <label for="type">Business Type</label>
                <select class="form-control" id="type" name="type" value="<?php echo e(old('type')); ?>" required>
                    <option>Select Business Type</option>
                    <?php if(sizeof($business_types) > 0): ?>
                        <?php $__currentLoopData = $business_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           <option value="<?php echo e($type->id); ?>"><?php echo e($type->business); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    <?php endif; ?>
                </select>
                <?php if($errors->has('type')): ?>
                    <span class="help-block"><strong><?php echo e($errors->first('type')); ?></strong></span>
                <?php endif; ?>
            </div>
            <div class="form-group col-sm-6 <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                <label for="name">New Category</label>
                <input type="text" class="form-control" required="required" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Name">
                <?php if($errors->has('name')): ?>
                    <span class="help-block"><strong><?php echo e($errors->first('name')); ?></strong></span>
                <?php endif; ?>
            </div>
            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>


        </form>

        <div class="col-sm-12 col-md-12 col-lg-12">
            <br>
            <table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Business Type</th>
                    <th style="width: 80px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storecategory): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <tr>
                        <th><?php echo e($storecategory->category); ?></th>
                        <th><?php echo e($storecategory->business); ?></th>
                        <th>
                            <a href="<?php echo e(url('admin/stores/category/edit/'.$storecategory->id)); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a>
                            <a href="<?php echo e(url('admin/stores/category/delete/'.$storecategory->id)); ?>" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                        </th>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>