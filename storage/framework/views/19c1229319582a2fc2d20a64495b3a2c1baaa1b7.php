<?php $__env->startSection('content'); ?>

<div class="col-md-12">
    <div class="card">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item"> 
                <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab" onclick="create_tab();">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span> 
                    <span class="hidden-xs-down">ADD TEAM MEMBER</span>
                </a> 
            </li>
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" onclick="open_tab();">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span> 
                    <span class="hidden-xs-down">ACTIVE TEAM MEMBERS</span>
                </a> 
            </li>
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab" onclick="cloased_tab();">
                    <span class="hidden-sm-up"><i class="ti-email"></i></span> 
                    <span class="hidden-xs-down">INACTIVE TEAM MEMBERS</span>
                </a> 
            </li>
            <li class="nav-item"></li>
            <li class="nav-item"></li>

            
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">
                
                <form role="form" method="POST" action="<?php echo e(url('')); ?>">
                    <?php echo e(csrf_field()); ?>

                    
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Member Name</label>
                            <input type="text" id="member_name" name="member_name" class="form-control" placeholder="" value="" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Member Position</label>
                            <input type="text" id="position" name="position" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Member Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="" value="" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label class="control-label">Member Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="" value="" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Select Which Stores Member Can Colaborate On</label>
                            <div class="col-sm-12 col-md-6 col-lg-6 store_p_container left_scroll" >
                                <table class="category_table">
                                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $store): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>  

                                    <tr>
                                        <td style="width:5%;">&nbsp;</td>
                                        <td style="width:93%;"><?php echo e($store->contact_name . " - " . $store->city); ?></td>
                                        <td style="width:2%;">
                                            <label class="btn-container"> 
                                                <input type="checkbox" value="<?php echo e($store->place_id); ?>" id="store<?php echo e($store->place_id); ?>" name="store_ids[]" onclick="get_store_details(<?php echo e($store->place_id); ?>);">
                                                <span class="checkmark"></span>
                                                <input type="hidden" value="<?php echo e($store->latitude); ?>" id="store_lat_<?php echo e($store->place_id); ?>" name="store_lat_<?php echo e($store->place_id); ?>">
                                                <input type="hidden" value="<?php echo e($store->longitude); ?>" id="store_lng_<?php echo e($store->place_id); ?>" name="store_lng_<?php echo e($store->place_id); ?>">
                                                <input type="hidden" value="0" id="store_loc_<?php echo e($store->place_id); ?>" name="store_loc_<?php echo e($store->place_id); ?>">
                                            </label>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>  
                                </table>
                            </div>

                        </div>  

                        
                        <div class="form-group">
                            <button type="submit" class="col-md-8 custom_btn save_c"></button>
                        </div>


                    </div>


                </form>
                
            </div>
            <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Team Member Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Team Member Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

















<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

    <script>
        $(".left_scroll").perfectScrollbar();
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.business', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>