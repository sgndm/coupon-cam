<?php $__env->startSection('content'); ?>
<span class="pull-right" style="display: inline; margin-bottom: 5px;">
    
    <form role="form" method="POST" action="<?php echo e(url('/admin/stores/category/filter')); ?>" >
    <!-- <a href="<?php echo e(url('admin/stores/category/create')); ?>" class="btn btn-default"><i class="fa fa-plus"></i> New Category</a> -->
    <!-- <?php echo e(csrf_field()); ?>

        <input type="text" class="form-control" style="display: inline; width: inherit; height: inherit; padding: 5px 10px 7px 10px !important" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Name or Email">
        <select class="form-control" style="display: inline; width: inherit; height: inherit; padding: 5px 10px 7px 10px !important" id="usertype" name="usertype">
            <option value="3" <?php if(old('usertype') == '3'): ?> selected="" <?php endif; ?>>All</option>
            <option value="1" <?php if(old('usertype') == '1'): ?> selected="" <?php endif; ?>>User</option>
            <option value="0" <?php if(old('usertype') == '0'): ?> selected="" <?php endif; ?>>Administrator</option>
        </select>
        <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-filter"></i></button> -->
    </form>
</span>
<div class="col-sm-6">
    <form role="form" method="POST" action="<?php echo e(url('/admin/stores/category/save')); ?>">
    <?php echo e(csrf_field()); ?>

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
</div>
<div class="col-sm-6">
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>Name</th>
            <th style="width: 80px;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storecategory): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <tr>
            <th><?php echo e($storecategory->category); ?></th>
            <th>
                <a href="<?php echo e(url('admin/stores/category/edit/'.$storecategory->id)); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a>
                <a href="<?php echo e(url('admin/stores/category/delete/'.$storecategory->id)); ?>" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </th>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </tbody>
</table>  
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>