<?php $__env->startSection('content'); ?>
<div class="col-md-12">
    <div class="card">

      <?php if($show_pre_launch == 1): ?>
      <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6" >
          <h2 class="text-center text-danger">This is Pre Launch Controll Page</h2><br>
          <div class="form-group text-center">
            <label> Select the winner of the pre launch </label><br><br>
            <button class="btn btn-danger col-8 " onclick="select_winner();">Select the Winner</button>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6" >
          <h1 id="winner_id" class="text-center text-success"></h1>
        </div>
      </div>
      <?php else: ?>

        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                    <span class="hidden-xs-down">STATS BY PROMO</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-pane-2" role="tab">
                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                    <span class="hidden-xs-down">STATS BY PROMO</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-pane-3" role="tab">
                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                    <span class="hidden-xs-down">TOTAL STATS</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-pane-4" role="tab">
                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                    <span class="hidden-xs-down">RETARGET CUSTOMERS</span>
                </a>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" data-toggle="tab" href="#tab-pane-5" role="tab">
                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                    <span class="hidden-xs-down">SEARCH</span>
                </a> -->
            </li>

        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="tab-pane-1" role="tabpanel">

                <div class="col-sm-12 col-lg-12">
                  <?PHP // print_r($temp_data); ?>
                    <div class="card">
                        <div class="card-body">
                          <?php if(sizeof($stores) > 0): ?>
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">

                                    <?PHP $storeCount = sizeof($stores); ?>

                                    <div class="carousel-item active">

                                        <h3 class="text-center m-b-5 text-danger"> <?php echo e(strtoupper($stores[0]['store_name'])); ?></h3>
                                        <h6 class="text-center m-b-20  text-danger"> <?php echo e(strtoupper($stores[0]['city'])); ?></h6>
                                        <div class="row">

                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['recent_day']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['recent_day']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['recent_day']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['recent_day']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['recent_day']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['7_day']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['7_day']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['7_day']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['7_day']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['7_day']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['30_day']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['30_day']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['30_day']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['30_day']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['30_day']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                            <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['all']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['all']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['all']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['all']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[0]['all']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <?php for($x = 1; $x < $storeCount; $x++): ?>
                                         <div class="carousel-item">

                                        <h3 class="text-center m-b-5 text-danger"> <?php echo e(strtoupper($stores[$x]['store_name'])); ?></h3>
                                        <h6 class="text-center m-b-2$x  text-danger"> <?php echo e(strtoupper($stores[$x]['city'])); ?></h6>
                                        <div class="row">

                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['recent_day']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['recent_day']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['recent_day']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['recent_day']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['recent_day']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>LAST 7 DAYS</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['7_day']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['7_day']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['7_day']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['7_day']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['7_day']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>LAST 30 DAYS</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['30_day']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['30_day']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['30_day']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['30_day']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['30_day']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-center text-danger"><b>ALL TIME</b></p>
                                                <div class="card">
                                                    <div class="stat-container">
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                            <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['all']['cp_1']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['all']['cp_2']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['all']['cp_3']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                            </div>
                                                            <div class="stat-tile">
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['all']['cp_4']); ?></h2>
                                                                <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 row justify-content-center">
                                                            <div class="col-12 stat-larg-tile">
                                                                <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                <h2 class="text-center stat_count" id="" ><?php echo e($stores[$x]['all']['new_c']); ?></h2>
                                                                <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <?php endfor; ?>



                                </div>


                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span> <img src="<?php echo e(asset('resources/assets/custom/images/arrow.png')); ?>" style="width: 70%;" > </span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <?php else: ?>
                              <?php echo e('You have No store.. Please create a store.. '); ?>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane p-20" id="tab-pane-2" role="tabpanel">
              <?php if(sizeof($promos) > 0): ?>
              <?php else: ?>
                <?php echo e('You have No Promos.. Please create a Promo.. '); ?>

              <?php endif; ?>
            </div>
            <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
              <?php if(sizeof($all_stats) > 0): ?>
              <?php else: ?>
                <?php echo e('You have No Stats.. '); ?>

              <?php endif; ?>
            </div>
            <div class="tab-pane p-20" id="tab-pane-4" role="tabpanel">
              <?php if(sizeof($retargeted_customers) > 0): ?>
              <?php else: ?>
                <?php echo e('You have No Retargeted customers.. '); ?>

              <?php endif; ?>
            </div>
            <!-- <div class="tab-pane p-20" id="tab-pane-5" role="tabpanel">5</div> -->
        </div>
      <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<!-- | Custom css for this page only | -->
<?php $__env->startSection('custom_css'); ?>
<?php $__env->stopSection(); ?>

<!-- | Custom js for this page only | -->
<?php $__env->startSection('custom_js'); ?>
  <script type="text/javascript">

    function select_winner(){
      $.get("<?php echo e(url('user/select_winner')); ?>",function(data){
        $('#winner_id').html("The winner is :" + data);
      });
    }

  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>