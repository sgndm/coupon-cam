<?php $__env->startSection('content'); ?>
<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/user/stores/create_store')); ?>">
    <?php echo e(csrf_field()); ?>

    <div class="row">

    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">

            <div class="col-sm-12 col-md-12 col-lg-6">

                <div class="form-group">
                    <label class="control-label">Store Name</label>
                    <input type="text" id="store_name_1" name="store_name" class="form-control" placeholder="Enter Name" required>
                    <!--small class="form-control-feedback"> This is inline help </small-->
                </div>

                <div class="form-group">
                    <label class="control-label">Store Address</label>
                    <input type="text" id="store_address_1" name="store_address" class="form-control" placeholder="Start Typing Full Address..." required>
                </div>

                <div class="form-group">
                    <label class="control-label">Cant Find Address?</label>
                    <label class="btn-container"> Input Manually
                        <input type="checkbox" name="manually" onchange="ChangeAutofill()" value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>

            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group">
                    <label class="control-label col-md-12 col-lg-12">Enter Full Address</label>
                    <input type="text" id="street_num_1" name="street_num" class="form-control col-sm-12 col-md-3 col-lg-3" placeholder="Number" required>
                    <input type="text" id="street_name_1" name="street_name" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Street Name" required>
                    <input type="text" id="city_1" name="city" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Town / City" required>
                    <input type="text" id="state_1" name="state" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="State / County" required>
                    <input type="text" id="postal_code_1" name="postal_code" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Zip / Postal Code" required>
                    <input type="text" id="country_1" name="country" class="form-control col-sm-12 col-md-8 col-lg-8" placeholder="Country" required>

                    <input type="hidden" id="store_lat_1" name="store_lat" required>
                    <input type="hidden" id="store_lng_1" name="store_lng" required>
                    <input type="hidden" id="country_short_1" name="country_short" required>
                </div>
            </div>

        </div>

        <hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group">
                    <label class="control-label">Store Image</label>
                    <input type="file" id="store_image_1" name="store_image" class="dropify" data-height="100" required/>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                 <div class="form-group">
                    <label class="control-label">Store AR Model</label>
                    <!-- <label><small class="form-control-feedback text-center">Please upload only pngs </small></label> -->
                    <input type="file" id="store_ar_1" name="store_ar" class="dropify" data-height="100"  required/>

                    <!-- <small class="form-control-feedback text-center">Please upload only pngs </small> -->
                </div>
            </div>
        </div>

        <!-- <hr>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="control-label">Store Description</label>
                    <textarea id="store_description_1" name="store_description" class="form-control" required ></textarea>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group">
                    <label class="control-label">Give Away Price</label><br>
                    <input type="checkbox" class="js-switch" data-color="#e80602" data-size="small" name="give_away" id="give_away_1" />
                </div>
            </div>
        </div> -->

        <!-- <hr> -->
        <!-- <div class="row">

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group">
                    <label class="control-label">Select A Business Type</label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>
                    <label class="btn-container">Business
                        <input type="radio" name="radio">
                        <span class="checkRadio"></span>
                    </label>

                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="form-group">
                    <label class="control-label">Select Relevent Category</label>
                    <div class="col-sm-12 col-md-8 col-lg-8 category_container left_scroll" >
                        <table class="category_table">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                            <tr>
                                <td style="width:5%;">&nbsp;</td>
                                <td style="width:93%;"><?php echo e($category->category); ?></td>
                                <td style="width:2%;">
                                    <label class="btn-container">
                                        <input type="checkbox" value="<?php echo e($category->id); ?>" id="category" name="category[]">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </table>
                    </div>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </div> -->
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="form-group">
              <button type="submit" class="btn btn-primary pull-right">Submit</button>
          </div>
        </div>


    </div>
    <div class="col-sm-12 col-md-5 col-lg-5">
    <h1 class="text-center" style="font-size: 26px;"> Check Location Is Correct Before Continuing</h1>
        <div id="map1" style="height: 400px;"></div>
    </div>

</div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>