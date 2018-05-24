<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <div class="card">

            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-pane-1" role="tab">
                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                        <span class="hidden-xs-down">STATS BY STORE</span>
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
                    <a class="nav-link" data-toggle="tab" href="#tab-pane-4" role="tab" onclick="cloased_tab();">
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
                        <div class="card">
                            <div class="card-body">
                                <?php if(sizeof($stores) > 0): ?>
                                    <div id="store_slider_stat" class="carousel slide" data-ride="carousel">
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


                                        <a class="carousel-control-next" href="#store_slider_stat" role="button" data-slide="next">
                                            <span> <img src="<?php echo e(asset('resources/assets/custom/images/arrow.png')); ?>" style="width: 70px;" > </span>
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
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if(sizeof($promos) > 0): ?>
                                    <div id="promo_slider_store" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <?PHP $promoCount = sizeof($promos); ?>

                                            <div class="carousel-item active">

                                                <h3 class="text-center m-b-5 text-danger"> <?php echo e(strtoupper($promos[0]['promo_name'])); ?></h3>
                                                <div class="row">

                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['recent_day']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['recent_day']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['recent_day']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['recent_day']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['recent_day']['new_c']); ?></h2>
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
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['7_day']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['7_day']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['7_day']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['7_day']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['7_day']['new_c']); ?></h2>
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
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['30_day']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['30_day']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['30_day']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['30_day']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['30_day']['new_c']); ?></h2>
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
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['all']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['all']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['all']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['all']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($promos[0]['all']['new_c']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <?php for($x = 1; $x < $promoCount; $x++): ?>
                                                <div class="carousel-item">

                                                    <h3 class="text-center m-b-5 text-danger"> <?php echo e(strtoupper($promos[$x]['promo_name'])); ?></h3>
                                                    <div class="row">

                                                        <div class="col-sm-6 col-md-6 col-lg-3">
                                                            <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                            <div class="card">
                                                                <div class="stat-container">
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['recent_day']['cp_1']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['recent_day']['cp_2']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['recent_day']['cp_3']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['recent_day']['cp_4']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['recent_day']['new_c']); ?></h2>
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
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['7_day']['cp_1']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['7_day']['cp_2']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['7_day']['cp_3']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['7_day']['cp_4']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['7_day']['new_c']); ?></h2>
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
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['30_day']['cp_1']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['30_day']['cp_2']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['30_day']['cp_3']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['30_day']['cp_4']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['30_day']['new_c']); ?></h2>
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
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['all']['cp_1']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['all']['cp_2']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['all']['cp_3']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                        </div>
                                                                        <div class="stat-tile">
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['all']['cp_4']); ?></h2>
                                                                            <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 row justify-content-center">
                                                                        <div class="col-12 stat-larg-tile">
                                                                            <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                            <h2 class="text-center stat_count" id="" ><?php echo e($promos[$x]['all']['new_c']); ?></h2>
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


                                        <a class="carousel-control-next" href="#promo_slider_store" role="button" data-slide="next">
                                            <span> <img src="<?php echo e(asset('resources/assets/custom/images/arrow.png')); ?>" style="width: 70px;" > </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <?php echo e('You have No Promos.. Please create a Promo.. '); ?>


                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if(sizeof($all_stats) > 0): ?>
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">

                                                <h3 class="text-center m-b-5 text-danger"> ALL STATS </h3>
                                                <div class="row">

                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <p class="text-center text-danger"><b>MOST RECENT DAY</b></p>
                                                        <div class="card">
                                                            <div class="stat-container">
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['recent_day']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['recent_day']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['recent_day']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['recent_day']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['recent_day']['new_c']); ?></h2>
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
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['7_day']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['7_day']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['7_day']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['7_day']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['7_day']['new_c']); ?></h2>
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
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['30_day']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['30_day']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['30_day']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['30_day']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['30_day']['new_c']); ?></h2>
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
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['all']['cp_1']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 1 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['all']['cp_2']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 2 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['all']['cp_3']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 3 COUPONS ISSUED</p>
                                                                    </div>
                                                                    <div class="stat-tile">
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['all']['cp_4']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">LEVEL 4 COUPONS ISSUED</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row justify-content-center">
                                                                    <div class="col-12 stat-larg-tile">
                                                                        <p class="text-center stat_lable" id="">THIS PROMO BROUGHT A TOTAL OF</p>
                                                                        <h2 class="text-center stat_count" id="" ><?php echo e($all_stats[0]['all']['new_c']); ?></h2>
                                                                        <p class="text-center stat_lable" id="">NEW CUSTOMER THIS MONTH</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        
                                        
                                        
                                        
                                    </div>
                                <?php else: ?>
                                    <?php echo e('You have No Stats.. '); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane p-20" id="tab-pane-4" role="tabpanel">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="row">

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <form class="" action="user/retarget/create" method="post" enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6">

                                            <div class="form-group">
                                                <label class="control-label col-md-12 col-lg-12">Select Store</label>
                                                <div class="col-sm-12 col-md-8 col-lg-8 store_container left_scroll">
                                                    <table class="category_table">
                                                        <?php if(sizeof($active_stores)>0): ?>
                                                            <?php $__currentLoopData = $active_stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                                                <tr>
                                                                    <td style="width:5%;">&nbsp;</td>
                                                                    <td style="width:93%;"><?php echo e($store->contact_name); ?></td>
                                                                    <td style="width:2%;">
                                                                        <label class="btn-container">
                                                                            <input type="checkbox" value="<?php echo e($store->place_id); ?>" id="store2<?php echo e($store->place_id); ?>" name="store[]" onclick="get_retarget_coupons(<?php echo e($store->place_id); ?>, 2);" class="radio">
                                                                            <span class="checkmark"></span>

                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                        <?php endif; ?>
                                                    </table>
                                                    <input type="hidden" name="store_id" id="store_id_1" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Coupon Name</label>
                                                <input type="text" id="coupon_name_1" name="coupon_name" class="form-control" placeholder="Enter Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Estimated Value</label>
                                                <input type="number" id="coupon_value_1" name="coupon_value" class="form-control" placeholder="" required min="0" step="0.1">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Coupon Info & Basic Conditions</label>
                                                <textarea id="coupon_info_1" name="coupon_info" class="form-control" placeholder="" required></textarea>
                                            </div>

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">

                                            <div class="form-group">
                                                <label class="control-label">Coupon Photo</label>
                                                <input type="file" id="coupon_photo_1" name="coupon_photo" class="dropify" data-height="100"  required />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Choose Or Upload AR Coupon</label>
                                                <table id="searc_ar_model">
                                                    <tr>
                                                        <td style="color: #e80602;"><br><br>SEARCH</td>
                                                        <td><br><br><input type="text" class="custom-input" id="search_coupon_1" oninput="search_ar_models(1,this.value);" ></td>
                                                        <td><br><br><img src="<?php echo e(url('resources/assets/custom/images/search.png')); ?>" style="width: 20px;" ></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="ar_search_res" id="ar_search_result_1"></div>
                                                    </div>
                                                    <img src="<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>" class="col-sm-12 col-md-6 col-lg-6 pull-right" id="ar_prev_1" >
                                                    <input type="hidden" name="ar_coupon_name" id="ar_coupon_name_1">
                                                    <input type="hidden" name="ar_marker_name" id="ar_marker_name_1">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Detailed Terms & Conditions</label>
                                                <textarea id="coupon_condition_1" name="coupon_condition" class="form-control" placeholder="" required></textarea>
                                            </div>


                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <button type="submit" class="custom_btn_2 col-12 send_push" name="send_push"></button>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <button type="submit" class="custom_btn_2 col-12 start_geo" name="start_geo" id="geo_start"></button>
                                                    <button type="submit" class="custom_btn_2 col-12 stop_geo" name="stop_geo" id="geo_stop" style="display: none"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="stat-container">
                                            <br>
                                            <h5 class="text-center text-danger" style=""><b> PUSH STATS</b></h5>
                                            <p class="text-center text-danger"><b>( Current )</b></p>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_push_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">RECEIVED LAST PUSH COUPON</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_push_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">USED LAST PUSH COUPON</p>
                                                </div>
                                            </div>
                                            <br>
                                            <p class="text-center text-danger"><b>( All Time )</b></p>
                                            <br>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_push_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL PUSH COUPONS RECEIVED</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_push_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL PUSH COUPONS USED</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="stat-container">
                                            <br>
                                            <h5 class="text-center text-danger" style=""><b> GEO STATS</b></h5>
                                            <p class="text-center text-danger"><b>( Current )</b></p>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_geo_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">GEO COUPONS RECEIVED</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="last_geo_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">GEO COUPONS USED</p>
                                                </div>
                                            </div>
                                            <br>
                                            <p class="text-center text-danger"><b>( All Time )</b></p>
                                            <br>
                                            <div class="col-12 row justify-content-center">
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_geo_rec" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL GEO COUPONS RECEIVED</p>
                                                </div>
                                                <div class="stat-tile">
                                                    <h2 class="text-center stat_count" id="all_geo_used" >0</h2>
                                                    <p class="text-center stat_lable" id="">TOTAL GEO COUPONS USED</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- <div class="tab-pane p-20" id="tab-pane-5" role="tabpanel">5</div> -->
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<!-- | Custom css for this page only | -->
<?php $__env->startSection('custom_css'); ?>
<?php $__env->stopSection(); ?>

<!-- | Custom js for this page only | -->
<?php $__env->startSection('custom_js'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dropify').dropify();

            //$('#loyalty_coupon_c_1').prop('checked', true);
        });

        function cloased_tab(){
//      set_stat_tile();
        }

        $(".radio").change(function() {
            $(".radio").prop('checked', false);
            $(this).prop('checked', true);
        });

        function search_ar_models(id, input) {
            $.get("<?php echo e(url('user/search_ar_models')); ?>/"+input,function(data){
                console.log(data);
                var list = '<ul>';
                for(var x =0; x < data.length; x++){
                    var ar_image = data[x]['image_thumbnail'];
                    var ar_name = data[x]['image_tags'];
                    var ar_marker = data[x]['marker'];
                    list += "<li><p class='ar_list' onclick='showInPrev("+id+",\""+ar_image+"\",\""+ar_marker+"\");'>"+ar_name+"</p></li>";

                }
                list+="</ul>";

                $('#ar_search_result_'+id).html(list);
            });
        }

        function showInPrev(id,ar_image, ar_marker){
            $('#ar_prev_'+id).attr('src', "<?php echo e(url('resources/assets/media')); ?>/"+ar_image);
            $('#ar_coupon_name_'+id).val(ar_image);
            $('#ar_marker_name_'+id).val(ar_marker);

           $('#ar_search_result_'+id).hide();
        }

        function get_retarget_coupons(store_id) {
            // set store id
            $('#store_id_1').val(store_id);

            // get retarget coupon details
            $.get("<?php echo e(url('user/retarget/get_details')); ?>/"+parseInt(store_id),function(data){
//                alert(data);
                console.log(data);

                // empty form
                $('#coupon_name_1').val('');
                $('#coupon_value_1').val('');
                $('#coupon_info_1').val('');
                $('#coupon_condition_1').val('');
                $('#ar_coupon_name_1').val('');
                $('#ar_marker_name_1').val('');

                $('#ar_prev_1').attr('src',"<?php echo e(url('resources/assets/custom/images/no-image.png')); ?>");


                // set data to form
                var coupon = data['coupon_data'];


                if(coupon.length > 0) {
                    console.log(coupon);

                    $('#coupon_name_1').val(coupon[0]['coupon_name']);
                    $('#coupon_value_1').val(coupon[0]['estimated_value']);
                    $('#coupon_info_1').val(coupon[0]['coupon_info']);
                    $('#coupon_condition_1').val(coupon[0]['coupon_details']);
                    $('#ar_coupon_name_1').val(coupon[0]['coupon_ar']);
                    $('#ar_marker_name_1').val(coupon[0]['coupon_marker']);

                    $('#coupon_photo_1').prop('required', false);
                    $('#ar_prev_1').attr('src', "<?php echo e(url('resources/assets/media')); ?>/" + coupon[0]['coupon_ar']);

                    $('#geo_start').hide();
                    $('#geo_stop').show();
                } else {
                    $('#geo_start').show();
                    $('#geo_stop').hide();
                }



                // set stat
                var last_push = data['last_push'];
                var all_push = data['all_push'];
                var last_geo = data['last_geo'];
                var all_geo = data['all_geo'];

                $('#last_push_rec').html(last_push['received']);
                $('#last_push_used').html(last_push['used']);
                $('#all_push_rec').html(all_push['received']);
                $('#all_push_used').html(all_push['used']);
                $('#last_geo_rec').html(last_geo['received']);
                $('#last_geo_used').html(last_geo['used']);
                $('#all_geo_rec').html(all_geo['received']);
                $('#all_geo_used').html(all_geo['used']);


            });
        }



    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>