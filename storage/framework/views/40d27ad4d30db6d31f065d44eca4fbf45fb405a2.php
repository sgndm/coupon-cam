<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab" >
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">CREATE COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab" >
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">ACTIVE COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">PAUSED COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-4" aria-controls="tab-pane-4" role="tab" style="display: none;">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">PAUSED COUPONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-pane-5" role="tab">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">
                        <table>
                            <tr>
                                <td>SEARCH</td>
                                <td><input type="text" class="custom-input" id="search_coupon" ></td>
                                <td><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                            </tr>
                        </table>
                    </span>
                        </a>
                    </li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-20" id="tab-pane-1" role="tabpanel">

                        <div class="row">
                            <div class="col-md-9">

                                <ul class="nav nav-tabs customtab_2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" aria-controls="cpn_l_1" href="#cpn_l_1" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 1 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#cpn_l_2" aria-controls="cpn_l_2" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 2 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_l_3" href="#cpn_l_3" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 3 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_l_4" href="#cpn_l_4" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 4 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" style="display: none;">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_l_5" href="#cpn_l_5" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down"></span>
                                        </a>
                                    </li>

                                </ul>

                                <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/user/coupons/create')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="tab-content">
                                        <div class="tab-pane active p-20" id="cpn_l_1" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_1" id="promo_id_c_1">
                                                            <?php if(sizeof($inactivePromos) > 0): ?>
                                                                <?php $__currentLoopData = $inactivePromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php else: ?>
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_c_1" name="coupon_photo_1" class="dropify" data-height="100"  required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_1" oninput="search_ar_models(1,'c',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_1"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_1" >
                                                            <input type="hidden" name="ar_coupon_name_1" id="ar_coupon_name_c_1">
                                                            <input type="hidden" name="ar_marker_name_1" id="ar_marker_name_c_1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_1" name="coupon_name_1" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_1" name="coupon_info_1" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_c_1" name="coupon_availability_1" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_1" name="coupon_condition_1" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_c_1" name="coupon_value_1" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_1" id="loyalty_coupon_c_1" onchange="showHideLoyaltyCount(1, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_1" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_c_1" name="coupon_count_1" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="nextTab('cpn_l_2');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_2" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_2" id="promo_id_c_2">
                                                            <?php if(sizeof($inactivePromos) > 0): ?>
                                                                <?php $__currentLoopData = $inactivePromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php else: ?>
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_c_2" name="coupon_photo_2" class="dropify" data-height="100"  required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_2" oninput="search_ar_models(2,'c',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_2"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_2" >
                                                            <input type="hidden" name="ar_coupon_name_2" id="ar_coupon_name_c_2">
                                                            <input type="hidden" name="ar_marker_name_2" id="ar_marker_name_c_2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_2" name="coupon_name_2" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_2" name="coupon_info_2" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_c_2" name="coupon_availability_2" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_2" name="coupon_condition_2" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_c_2" name="coupon_value_2" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_2" id="loyalty_coupon_c_2" onchange="showHideLoyaltyCount(2, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_2" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_c_2" name="coupon_count_2" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="nextTab('cpn_l_3');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_3" id="promo_id_c_2">
                                                            <?php if(sizeof($inactivePromos) > 0): ?>
                                                                <?php $__currentLoopData = $inactivePromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php else: ?>
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_c_3" name="coupon_photo_3" class="dropify" data-height="100"  required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_3" oninput="search_ar_models(3,'c',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_3"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_3" >
                                                            <input type="hidden" name="ar_coupon_name_3" id="ar_coupon_name_c_3">
                                                            <input type="hidden" name="ar_marker_name_3" id="ar_marker_name_c_3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_3" name="coupon_name_3" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_3" name="coupon_info_3" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_c_3" name="coupon_availability_3" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_3" name="coupon_condition_3" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_c_3" name="coupon_value_3" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_3" id="loyalty_coupon_c_3" onchange="showHideLoyaltyCount(3, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_3" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_c_3" name="coupon_count_3" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="nextTab('cpn_l_4');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_4" id="promo_id_c_2">
                                                            <?php if(sizeof($inactivePromos) > 0): ?>
                                                                <?php $__currentLoopData = $inactivePromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php else: ?>
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_c_4" name="coupon_photo_4" class="dropify" data-height="100"  required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_c_4" oninput="search_ar_models(4,'c',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_c_4"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_c_4" >
                                                            <input type="hidden" name="ar_coupon_name_4" id="ar_coupon_name_c_4">
                                                            <input type="hidden" name="ar_marker_name_4" id="ar_marker_name_c_4">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_c_4" name="coupon_name_4" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_c_4" name="coupon_info_4" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_c_4" name="coupon_availability_4" class="form-control" placeholder="" required value="Unlimited" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_c_4" name="coupon_condition_4" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_c_4" name="coupon_value_4" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_4" id="loyalty_coupon_c_4" onchange="showHideLoyaltyCount(4, 'c');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_c_4" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_c_4" name="coupon_count_4" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_c_c" onclick="nextTab('cpn_l_5');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_l_5" role="tabpanel">

                                            <div class="form-group  row justify-content-md-center">
                                                <p class="col-sm-12 col-md-12 col-lg-12 text-danger text-center"><br><br>Save and Continue to Activate promo<br><br></p>
                                                <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                                                    <button type="submit" class="col-md-6 custom_btn save_c_c" ></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-3">
                                <div class="imagecontainer">
                                    <div class="headingc" id="heading_c_1"></div>
                                    <div class="contentc" id="content_c1">
                                        <div class="goimagec"></div>
                                        <img id="image_c_1" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_c_2"></div>
                                    <div class="contentc" id="content_c2">
                                        <div class="goimagec"></div>
                                        <img id="image_c_2" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_c_3"></div>
                                    <div class="contentc" id="content_c3">
                                        <div class="goimagec"></div>
                                        <img id="image_c_3" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_c_4"></div>
                                    <div class="contentc" id="content_c4">
                                        <div class="goimagec"></div>
                                        <img id="image_c_4" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
                        <?php
                        $promoCount = sizeof($activePromos);
                        $itemCount = 0;

                        if(($promoCount % 5) == 0){
                            $itemCount = intval($promoCount / 5);
                        } else {
                            $itemCount = intval(($promoCount / 5)) + 1;
                        }
                        ?>

                        <?php if($promoCount > 0): ?>

                            <div class="card">
                                <div class="card-body">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">
                                                <div class="row justify-content-md-center">
                                                    <?php if($itemCount == 1): ?>
                                                        <?php for($y = 0; $y < $promoCount; $y++): ?>
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($activePromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $activePromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($activePromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        <?php endfor; ?>


                                                    <?php else: ?>
                                                        <?php for($y = 0; $y < 5; $y++): ?>
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($activePromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $activePromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($activePromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>

                                                </div>
                                            </div>

                                            <?php for($y = 5; $y < $promoCount; $y++): ?>

                                                <?php if((intval($y % 5) == 0) && ($y == ($promoCount - 1)) ): ?>
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($activePromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $activePromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($activePromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php elseif(intval($y % 5) == 0): ?>
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($activePromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $activePromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($activePromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                <?php elseif((intval($y % 5) == 4) || ($y == ($promoCount - 1))): ?>
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($activePromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $activePromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($activePromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php else: ?>
                                                    <div class="col-sm-6 col-md-4 col-lg-2">
                                                        <h3 class="text-center text-danger"><?php echo e(strtoupper($activePromos[$y]->promo_name)); ?></h3>
                                                        <div class="imagecontainer2">

                                                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                <?php if($coupon->promo_id == $activePromos[$y]->promo_id): ?>
                                                                    <?php if($coupon->coupon_level == 1): ?>
                                                                        <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a1">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php elseif($coupon->coupon_level == 2): ?>
                                                                        <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a2">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php elseif($coupon->coupon_level == 3): ?>
                                                                        <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a3">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php elseif($coupon->coupon_level == 4): ?>
                                                                        <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a4">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                        </div>
                                                        <div class="col-md-12 text-center">
                                                            <a  class="" onclick="edit_active_coupons(<?php echo e($activePromos[$y]->promo_id); ?>);"  >
                                                                <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endfor; ?>
                                        </div>




                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span> <img src="<?php echo e(asset('resources/assets/custom/images/arrow.png')); ?>" style="width: 70%;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        <?php else: ?>
                            <?php echo e("No active Coupons available"); ?>

                        <?php endif; ?>
                    </div>
                    <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                        <?php
                        $promoCount = sizeof($puasedPromos);
                        $itemCount = 0;

                        if(($promoCount % 5) == 0){
                            $itemCount = intval($promoCount / 5);
                        } else {
                            $itemCount = intval(($promoCount / 5)) + 1;
                        }
                        ?>

                        <?php if($promoCount > 0): ?>

                            <div class="card">
                                <div class="card-body">
                                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">
                                                <div class="row justify-content-md-center">
                                                    <?php if($itemCount == 1): ?>
                                                        <?php for($y = 0; $y < $promoCount; $y++): ?>
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($puasedPromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $puasedPromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($puasedPromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        <?php endfor; ?>


                                                    <?php else: ?>
                                                        <?php for($y = 0; $y < 5; $y++): ?>
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($puasedPromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $puasedPromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($puasedPromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>

                                                </div>
                                            </div>

                                            <?php for($y = 5; $y < $promoCount; $y++): ?>

                                                <?php if((intval($y % 5) == 0) && ($y == ($promoCount - 1)) ): ?>
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($puasedPromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $puasedPromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($puasedPromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php elseif(intval($y % 5) == 0): ?>
                                                    <div class="carousel-item">
                                                        <div class="row justify-content-md-center">
                                                            <div class="col-sm-6 col-md-4 col-lg-2">
                                                                <h3 class="text-center text-danger"><?php echo e(strtoupper($puasedPromos[$y]->promo_name)); ?></h3>
                                                                <div class="imagecontainer2">

                                                                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                        <?php if($coupon->promo_id == $puasedPromos[$y]->promo_id): ?>
                                                                            <?php if($coupon->coupon_level == 1): ?>
                                                                                <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a1">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 2): ?>
                                                                                <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a2">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 3): ?>
                                                                                <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a3">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php elseif($coupon->coupon_level == 4): ?>
                                                                                <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                <div class="contenta" id="content_a4">
                                                                                    <div class="goimagea"></div>
                                                                                    <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                </div>
                                                                <div class="col-md-12 text-center">
                                                                    <a  class="" onclick="edit_active_coupons(<?php echo e($puasedPromos[$y]->promo_id); ?>);"  >
                                                                        <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <?php elseif((intval($y % 5) == 4) || ($y == ($promoCount - 1))): ?>
                                                                <div class="col-sm-6 col-md-4 col-lg-2">
                                                                    <h3 class="text-center text-danger"><?php echo e(strtoupper($puasedPromos[$y]->promo_name)); ?></h3>
                                                                    <div class="imagecontainer2">

                                                                        <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                            <?php if($coupon->promo_id == $puasedPromos[$y]->promo_id): ?>
                                                                                <?php if($coupon->coupon_level == 1): ?>
                                                                                    <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                    <div class="contenta" id="content_a1">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                    </div>
                                                                                <?php elseif($coupon->coupon_level == 2): ?>
                                                                                    <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                    <div class="contenta" id="content_a2">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                    </div>
                                                                                <?php elseif($coupon->coupon_level == 3): ?>
                                                                                    <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                    <div class="contenta" id="content_a3">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                    </div>
                                                                                <?php elseif($coupon->coupon_level == 4): ?>
                                                                                    <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                                    <div class="contenta" id="content_a4">
                                                                                        <div class="goimagea"></div>
                                                                                        <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                                    </div>
                                                                    <div class="col-md-12 text-center">
                                                                        <a  class="" onclick="edit_active_coupons(<?php echo e($puasedPromos[$y]->promo_id); ?>);"  >
                                                                            <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>

                                                <?php else: ?>
                                                    <div class="col-sm-6 col-md-4 col-lg-2">
                                                        <h3 class="text-center text-danger"><?php echo e(strtoupper($puasedPromos[$y]->promo_name)); ?></h3>
                                                        <div class="imagecontainer2">

                                                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                <?php if($coupon->promo_id == $puasedPromos[$y]->promo_id): ?>
                                                                    <?php if($coupon->coupon_level == 1): ?>
                                                                        <div class="headinga" id="heading_a_1"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a1">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php elseif($coupon->coupon_level == 2): ?>
                                                                        <div class="headinga" id="heading_a_2"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a2">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php elseif($coupon->coupon_level == 3): ?>
                                                                        <div class="headinga" id="heading_a_3"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a3">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php elseif($coupon->coupon_level == 4): ?>
                                                                        <div class="headinga" id="heading_a_4"> <?php echo e($coupon->coupon_title); ?> </div>
                                                                        <div class="contenta" id="content_a4">
                                                                            <div class="goimagea"></div>
                                                                            <img id="image_1" src="<?php echo e(asset('resources/assets/coupons/full/' . $coupon->coupon_photo )); ?>" style="width: 100%;">
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                        </div>
                                                        <div class="col-md-12 text-center">
                                                            <a  class="" onclick="edit_active_coupons(<?php echo e($puasedPromos[$y]->promo_id); ?>);"  >
                                                                <img src="<?php echo e(url('resources/assets/CCUI/edit_coup.png')); ?>" style="width:140px; height: 40px; cursor:pointer;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endfor; ?>
                                        </div>




                                        <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                                            <span> <img src="<?php echo e(asset('resources/assets/custom/images/arrow.png')); ?>" style="width: 70%;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        <?php else: ?>
                            <?php echo e("No Paused Coupons available"); ?>

                        <?php endif; ?>
                    </div>
                    <div class="tab-pane p-20" id="tab-pane-4" role="tabpanel">
                        <div class="row">
                            <div class="col-md-9">

                                <ul class="nav nav-tabs customtab_2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" aria-controls="cpn_e_1" href="#cpn_e_1" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 1 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#cpn_e_2" aria-controls="cpn_e_2" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                            <span class="hidden-xs-down">Level 2 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_e_3" href="#cpn_e_3" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 3 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_e_4" href="#cpn_e_4" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down">Level 4 Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" style="display: none;">
                                        <a class="nav-link" data-toggle="tab" aria-controls="cpn_e_5" href="#cpn_e_5" role="tab" >
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                            <span class="hidden-xs-down"></span>
                                        </a>
                                    </li>

                                </ul>

                                <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/user/coupons/update')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="tab-content">

                                        <input type="hidden" name="coupon_id_1" id="coupon_id_e_1" >
                                        <input type="hidden" name="coupon_id_2" id="coupon_id_e_2" >
                                        <input type="hidden" name="coupon_id_3" id="coupon_id_e_3" >
                                        <input type="hidden" name="coupon_id_4" id="coupon_id_e_4" >
                                        <input type="hidden" name="coup_img_1" id="coup_img_e_1" >
                                        <input type="hidden" name="coup_img_2" id="coup_img_e_2" >
                                        <input type="hidden" name="coup_img_3" id="coup_img_e_3" >
                                        <input type="hidden" name="coup_img_4" id="coup_img_e_4" >

                                        <div class="tab-pane active p-20" id="cpn_e_1" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_1" id="promo_id_e_1">
                                                            <?php if(sizeof($allPromos) > 0): ?>
                                                                <?php $__currentLoopData = $allPromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_e_1" name="coupon_photo_1" class="dropify" data-height="100" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_1" oninput="search_ar_models(1,'e',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_1"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_1" >
                                                            <input type="hidden" name="ar_coupon_name_1" id="ar_coupon_name_e_1">
                                                            <input type="hidden" name="ar_marker_name_1" id="ar_marker_name_e_1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_1" name="coupon_name_1" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_1" name="coupon_info_1" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_e_1" name="coupon_availability_1" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_1" name="coupon_condition_1" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_e_1" name="coupon_value_1" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_1" id="loyalty_coupon_e_1" onchange="showHideLoyaltyCount(1, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_1" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_e_1" name="coupon_count_1" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="nextTab('cpn_e_2');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_2" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_2" id="promo_id_e_2" disabled>
                                                            <?php if(sizeof($allPromos) > 0): ?>
                                                                <?php $__currentLoopData = $allPromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php else: ?>
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_e_2" name="coupon_photo_2" class="dropify" data-height="100" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_2" oninput="search_ar_models(2,'e',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_2"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_2" >
                                                            <input type="hidden" name="ar_coupon_name_2" id="ar_coupon_name_e_2">
                                                            <input type="hidden" name="ar_marker_name_2" id="ar_marker_name_e_2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_2" name="coupon_name_2" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_2" name="coupon_info_2" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_e_2" name="coupon_availability_2" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_2" name="coupon_condition_2" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_e_2" name="coupon_value_2" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_2" id="loyalty_coupon_e_2" onchange="showHideLoyaltyCount(2, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_2" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_e_2" name="coupon_count_2" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="nextTab('cpn_e_3');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_3" id="promo_id_e_2" disabled>
                                                            <?php if(sizeof($allPromos) > 0): ?>
                                                                <?php $__currentLoopData = $allPromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_e_3" name="coupon_photo_3" class="dropify" data-height="100" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_3" oninput="search_ar_models(3,'e',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_3"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_3" >
                                                            <input type="hidden" name="ar_coupon_name_3" id="ar_coupon_name_e_3">
                                                            <input type="hidden" name="ar_marker_name_3" id="ar_marker_name_e_3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_3" name="coupon_name_3" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_3" name="coupon_info_3" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_e_3" name="coupon_availability_3" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_3" name="coupon_condition_3" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_e_3" name="coupon_value_3" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_3" id="loyalty_coupon_e_3" onchange="showHideLoyaltyCount(3, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_3" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_e_3" name="coupon_count_3" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="nextTab('cpn_e_4');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Promo</label>
                                                        <select class="form-control custom-select" name="promo_id_4" id="promo_id_e_2" disabled>
                                                            <?php if(sizeof($allPromos) > 0): ?>
                                                                <?php $__currentLoopData = $allPromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                    <option value="<?php echo e($promo->promo_id); ?>"><?php echo e($promo->promo_name); ?></option>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                            <?php else: ?>
                                                                <option>-- No Promos Available.. Please create a Promo..</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Not Sure What To Offer?</label>
                                                        <select class="form-control custom-select" id="suggestion_1">
                                                            <option value="">Coupon Suggestion 1</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Coupon Photo</label>
                                                            <input type="file" id="coupon_photo_e_4" name="coupon_photo_4" class="dropify" data-height="100" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Choose Or Upload AR Coupon</label>
                                                        <table id="searc_ar_model">
                                                            <tr>
                                                                <td style="color: #e80602;"><br><br>SEARCH</td>
                                                                <td><br><br><input type="text" class="custom-input" id="search_coupon_e_4" oninput="search_ar_models(4,'e',this.value);" ></td>
                                                                <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="ar_search_res" id="ar_search_result_e_4"></div>
                                                            </div>
                                                            <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_e_4" >
                                                            <input type="hidden" name="ar_coupon_name_4" id="ar_coupon_name_e_4">
                                                            <input type="hidden" name="ar_marker_name_4" id="ar_marker_name_e_4">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Name</label>
                                                        <input type="text" id="coupon_name_e_4" name="coupon_name_4" class="form-control" placeholder="Enter Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Coupon Info & Basic Conditions</label>
                                                        <textarea id="coupon_info_e_4" name="coupon_info_4" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Availability</label>
                                                        <input type="text" id="coupon_availability_e_4" name="coupon_availability_4" class="form-control" placeholder="" required value="Unlimited" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Detailed Terms & Conditions</label>
                                                        <textarea id="coupon_condition_e_4" name="coupon_condition_4" class="form-control" placeholder="" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Estimated Value</label>
                                                        <input type="number" id="coupon_value_e_4" name="coupon_value_4" class="form-control" placeholder="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Loyalty Coupon ?</label><br>
                                                        <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="loyalty_coupon_4" id="loyalty_coupon_e_4" onchange="showHideLoyaltyCount(4, 'e');" />
                                                    </div>
                                                    <div class="form-group" id="lc_cont_e_4" style="display: none;">
                                                        <label class="control-label">Loyalty Count</label>
                                                        <input type="number" min="0" max="10" value="0" id="coupon_count_e_4" name="coupon_count_4" class="form-control" placeholder="" >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="col-md-12 custom_btn save_e_c" onclick="nextTab('cpn_e_5');" ></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-20" id="cpn_e_5" role="tabpanel">

                                            <div class="form-group  row justify-content-md-center">
                                                <p class="col-sm-12 col-md-12 col-lg-12 text-danger text-center"><br><br>Save and Continue to Update Coupons<br><br></p>
                                                <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                                                    <button type="submit" class="col-md-6 custom_btn save_c_c" ></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-3">
                                <div class="imagecontainer">
                                    <div class="headingc" id="heading_e_1"></div>
                                    <div class="contentc" id="content_e1">
                                        <div class="goimagec"></div>
                                        <img id="image_e_1" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_e_2"></div>
                                    <div class="contentc" id="content_e2">
                                        <div class="goimagec"></div>
                                        <img id="image_e_2" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_e_3"></div>
                                    <div class="contentc" id="content_e3">
                                        <div class="goimagec"></div>
                                        <img id="image_e_3" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>

                                    <div class="headingc" id="heading_e_4"></div>
                                    <div class="contentc" id="content_e4">
                                        <div class="goimagec"></div>
                                        <img id="image_e_4" src="<?php echo e(asset('resources/assets/user/images/imageplaceholder.png')); ?>" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20" id="tab-pane-5" role="tabpanel">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Coupon Name</th>
                                <th>Store(s)</th>
                                <th>Promo Name</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody id="search_result"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php $__env->stopSection(); ?>

    <!-- | Custom css for this page only | -->
    <?php $__env->startSection('custom_css'); ?>
    <?php $__env->stopSection(); ?>

    <!-- | Custom js for this page only | -->
        <?php $__env->startSection('custom_js'); ?>
            <script>
                $(document).ready(function(){
                    $('.dropify').dropify();

                    //$('#loyalty_coupon_c_1').prop('checked', true);
                });



                function showHideLoyaltyCount(id, page){
                    var checked = $('#loyalty_coupon_'+page+'_'+id).is(':checked');

                    if(checked){
                        $('#lc_cont_'+page+'_'+id).show();
                    } else {
                        $('#lc_cont_'+page+'_'+id).hide();
                    }

                }

                function search_ar_models(id, page, input) {
                    $.get("<?php echo e(url('user/search_ar_models')); ?>/"+input,function(data){
                        console.log(data);
                        var list = '<ul>';
                        for(var x =0; x < data.length; x++){
                            var ar_image = data[x]['image_thumbnail'];
                            var ar_name = data[x]['image_tags'];
                            var ar_marker = data[x]['marker'];
                            list += "<li><p class='ar_list' onclick='showInPrev("+id+",\""+page+"\",\""+ar_image+"\",\""+ar_marker+"\");'>"+ar_name+"</p></li>";

                        }
                        list+="</ul>";

                        $('#ar_search_result_'+page+'_'+id).html(list);
                    });
                }

                function showInPrev(id, page, ar_image, ar_marker){
                    $('#ar_prev_'+page+'_'+id).attr('src', "<?php echo e(url('resources/assets/media')); ?>/"+ar_image);
                    $('#ar_coupon_name_'+page+'_'+id).val(ar_image);
                    $('#ar_marker_name_'+page+'_'+id).val(ar_marker);
                }

                function readURL(input,id,page) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#image_'+page+'_'+id).attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function nextTab(next_tab){
                    $('a[aria-controls="'+next_tab+'"]').trigger("click");
                }

                $('#coupon_photo_c_1').on('change', function(){
                    readURL(this,1,'c');
                });
                $('#coupon_photo_c_2').on('change', function(){
                    readURL(this,2,'c');
                });
                $('#coupon_photo_c_3').on('change', function(){
                    readURL(this,3,'c');
                });
                $('#coupon_photo_c_4').on('change', function(){
                    readURL(this,4,'c');
                });

                $('#coupon_name_c_1').on('input', function(){
                    var coupon_name = $('#coupon_name_c_1').val();
                    $('#heading_c_1').html(coupon_name);
                });
                $('#coupon_name_c_2').on('input', function(){
                    var coupon_name = $('#coupon_name_c_2').val();
                    $('#heading_c_2').html(coupon_name);
                });
                $('#coupon_name_c_3').on('input', function(){
                    var coupon_name = $('#coupon_name_c_3').val();
                    $('#heading_c_3').html(coupon_name);
                });
                $('#coupon_name_c_4').on('input', function(){
                    var coupon_name = $('#coupon_name_c_4').val();
                    $('#heading_c_4').html(coupon_name);
                });

                $('#coupon_photo_e_1').on('change', function(){
                    readURL(this,1,'e');
                });
                $('#coupon_photo_e_2').on('change', function(){
                    readURL(this,2,'e');
                });
                $('#coupon_photo_e_3').on('change', function(){
                    readURL(this,3,'e');
                });
                $('#coupon_photo_e_4').on('change', function(){
                    readURL(this,4,'e');
                });

                $('#coupon_name_e_1').on('input', function(){
                    var coupon_name = $('#coupon_name_c_4').val();
                    $('#heading_e_1').html(coupon_name);
                });
                $('#coupon_name_e_2').on('input', function(){
                    var coupon_name = $('#coupon_name_c_4').val();
                    $('#heading_e_2').html(coupon_name);
                });
                $('#coupon_name_e_3').on('input', function(){
                    var coupon_name = $('#coupon_name_c_4').val();
                    $('#heading_e_3').html(coupon_name);
                });
                $('#coupon_name_e_4').on('input', function(){
                    var coupon_name = $('#coupon_name_c_4').val();
                    $('#heading_e_4').html(coupon_name);
                });

                $('#search_coupon').on('input', function(){
                    var input = $('#search_coupon').val();
                    $.get("<?php echo e(url('user/search_coupons')); ?>/"+input,function(data){
                        $('#search_result').html('');


                        for(var y = 0; y < data.length; y++){
                            var stores = data[y]['store_name'];
                            var store_list = '<ul>';
                            for(var x = 0; x < stores.length; x++){
                                store_list += '<li>'+stores[x]+"</li>";
                            }

                            store_list += '</ul>';

                            var row = '<tr><td>'+data[y]['coupon_title']+'</td><td>'+store_list+'</td><td>'+data[y]['promo_name']+'</td><td>'+data[y]['created_at']+'</td></tr>';

                            $('#search_result').append(row);
                        }



                        //console.log(data);
                    });
                });

                function edit_active_coupons(promo_id){
                    $('a[aria-controls="tab-pane-4"]').trigger("click");

                    $.get("<?php echo e(url('user/get_coupon_details')); ?>/"+parseInt(promo_id),function(data){
                        var y =5;

                        for(var x = 0; x < data.length; x++) {

                            var y = data[x]['coupon_level'];

                            $('#promo_id_e_'+y).val(promo_id);
                            $('#promo_id_e_'+y).attr('readonly', true);
                            $('#coupon_id_e_'+y).val(data[x]['coupon_id']);
                            $('#coupon_name_e_'+y).val(data[x]['coupon_title']);
                            $('#coupon_info_e_'+y).val(data[x]['coupon_information']);
                            $('#coupon_availability_e_'+y).val(data[x]['coupon_availabilty']);
                            $('#coupon_condition_e_'+y).val(data[x]['terms_conditions']);
                            $('#coupon_value_e_'+y).val(data[x]['estimated_value']);
                            $('#ar_coupon_name_e_'+y).val(data[x]['coupon_model']);

                            $('#ar_prev_e_'+y).attr('src', "<?php echo e(url('resources/assets/media')); ?>/"+data[x]['coupon_model']);
                            $('#image_e_'+y).attr('src', "<?php echo e(url('resources/assets/coupons/full')); ?>/"+data[x]['coupon_photo']);
                            $('#coup_img_e_'+y).val(data[x]['coupon_photo']);
                            var is_loyalty = data[x]['is_loyalty'];
                            var loyalty_count = data[x]['loyalty_count'];

                            if(is_loyalty == 1){
                                $('#loyalty_coupon_e_'+y).parent().find(".switchery").trigger("click");
                                $('#coupon_count_e_'+y).val(loyalty_count);
                                $('#lc_cont_e_'+y).show();
                            }


                        }

                    });

                }

            </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>