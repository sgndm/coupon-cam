<?php $__env->startSection('content'); ?>
<span class="pull-right" style="display: inline;  margin-bottom: 5px;">
    
    <form role="form" method="POST" action="<?php echo e(url('/admin/users/filter')); ?>" >
    <a href="<?php echo e(url('admin/users/trash')); ?>" class="btn btn-default"><i class="fa fa-trash"></i> Trash</a>
    <a href="<?php echo e(url('admin/users/create')); ?>" class="btn btn-default"><i class="fa fa-plus"></i> New User</a>
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
<table id="example" class="display table table-striped" style="width: 100%; cellspacing: 0;">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>User Type</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <tr>
        	<th><?php echo e($key+1); ?></th>
            <th><?php echo e($user->name); ?></th>
            <th><?php echo e($user->email); ?></th>
            <th style="max-width:150px;"><div style="max-height: 22px; overflow: hidden;"><?php echo e($user->contact); ?></div></th>
            <th><?php if($user->usertype == 1): ?> User <?php else: ?> Administrator <?php endif; ?></th>
            <th><?php echo e(date('d-m-Y',strtotime($user->created_at))); ?></th>
            <th><?php echo e(date('d-m-Y',strtotime($user->updated_at))); ?></th>
            <th>
                <a href="<?php echo e(url('admin/users/edit/'.$user->id)); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a>
                <a href="<?php echo e(url('admin/users/delete/'.$user->id)); ?>" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </th>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </tbody>
</table>  

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>