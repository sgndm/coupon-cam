<?php $__env->startSection('content'); ?>
<span class="pull-right" style="display: inline; margin-bottom: 5px;">
    
    <form role="form" method="POST" action="<?php echo e(url('/admin/promos/filter')); ?>" >
    <a href="<?php echo e(url('admin/promos/trash')); ?>" class="btn btn-default"><i class="fa fa-trash"></i> Trash</a>
    <a href="<?php echo e(url('admin/promos/create')); ?>" class="btn btn-default"><i class="fa fa-plus"></i> New Promo</a>
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
            <th>Name</th>            
            <th>Start Time</th>
            <th>Lenght</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <tr>
            <th><?php echo e($promo->username); ?></th>            
            <th><?php echo e(date('H:i A',strtotime($promo->start_at))); ?></th>
            <th><?php echo e($promo->promo_lenght); ?> <?php if($promo->promo_lenght == 1): ?> hour <?php else: ?> hours <?php endif; ?></th>
            <th><?php echo e(date('d-m-Y',strtotime($promo->created_at))); ?></th>
            <th><?php echo e(date('d-m-Y',strtotime($promo->updated_at))); ?></th>
            <th>
                <a href="<?php echo e(url('admin/promos/edit/'.$promo->id)); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square"></i></a>
                <a href="<?php echo e(url('admin/promos/delete/'.$promo->id)); ?>" onclick="return confirm('Are you sure want to delete ?')?true:false" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            </th>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </tbody>
</table>  

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>