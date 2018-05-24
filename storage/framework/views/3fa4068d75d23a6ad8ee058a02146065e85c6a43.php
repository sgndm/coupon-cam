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

                    <form role="form" method="POST" action="<?php echo e(url('user/team/create')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="col-sm-12 col-md-12 col-lg-12">

                            <input type="hidden" value="<?php echo e($user->name); ?>" name="company_name" id="company_name">


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
                                <input type="email" id="email" name="email" class="form-control" placeholder="" value="" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label class="control-label">Member Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="" value="" required>
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
                        <tr class="text-center">
                            <th>Team Member Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody id="act_mem_table">
                        <?php if(sizeof($active_members) > 0): ?>
                            <?php $__currentLoopData = $active_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td> <?php echo e($member->first_name); ?> </td>
                                    <td> <?php echo e($member->email); ?> </td>
                                    <td> <?php echo e($member->contact); ?> </td>
                                    <td class="text-center">
                                        <button class="btn btn-small btn-danger" onclick="deactivate_member(<?php echo e($member->id); ?>);">
                                            Deactivate Member
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        <?php else: ?>
                            <tr class="text-center">
                                <td colspan="4">
                                    No Active Member in the Team
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane p-20" id="tab-pane-3" role="tabpanel">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>Team Member Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody id="inact_mem_table">
                        <?php if(sizeof($inactive_members) > 0): ?>
                            <?php $__currentLoopData = $inactive_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td> <?php echo e($member->first_name); ?> </td>
                                    <td> <?php echo e($member->email); ?> </td>
                                    <td> <?php echo e($member->contact); ?> </td>
                                    <td class="text-center">
                                        <button class="btn btn-small btn-danger"onclick="activate_member(<?php echo e($member->id); ?>);">
                                            Activate Member
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        <?php else: ?>
                            <tr class="text-center">
                                <td colspan="4">
                                    No Inactive Member in the Team
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

















<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_js'); ?>

    <script type="text/javascript">

        $(document).ready(function(){});

        function create_tab() {}

        function open_tab() {
            get_active_members();
        }

        function cloased_tab(){
            get_inactive_members();
        }

        function finished_tab(){}


        $(".left_scroll").perfectScrollbar();

        function deactivate_member(user_id) {

            $.get("<?php echo e(url('user/deactivate_member')); ?>/"+parseInt(user_id),function(data){
                get_active_members();
            });
        }

        function activate_member(user_id) {
            $.get("<?php echo e(url('user/activate_member')); ?>/"+parseInt(user_id),function(data){
                get_inactive_members();
            });
        }

        function get_active_members(){

            $.get("<?php echo e(url('user/get_act_mem')); ?>",function(data){

                console.log(data);
                if(data.length > 0 ){
                    $('#act_mem_table').html('');

                    var html_t = [];

                    for(var x = 0; x < data.length; x++) {
                        var row = "<tr>"+
                            "<td>" + data[x]['first_name'] + "</td>"+
                            "<td>" + data[x]['email'] + "</td>"+
                            "<td>" + data[x]['contact'] + "</td>"+
                            "<td class='text-center'>" +
                            "<button class='btn btn-small btn-danger' onclick='deactivate_member(" + data[x]['id'] + ");'>Deactivate Member</button>" +
                            "</td>"+
                            "</tr>";

                        html_t.push(row);
                    }

                    $('#act_mem_table').html(html_t);

                }

            });
        }

        function get_inactive_members(){

            $.get("<?php echo e(url('user/get_inact_mem')); ?>",function(data){

                console.log(data);
                if(data.length > 0 ){
                    $('#inact_mem_table').html('');

                    var html_t = [];

                    for(var x = 0; x < data.length; x++) {
                        var row = "<tr>"+
                            "<td>" + data[x]['first_name'] + "</td>"+
                            "<td>" + data[x]['email'] + "</td>"+
                            "<td>" + data[x]['contact'] + "</td>"+
                            "<td class='text-center'>" +
                            "<button class='btn btn-small btn-danger' onclick='activate_member(" + data[x]['id'] + ");'>Activate Member</button>" +
                            "</td>"+
                            "</tr>";

                        html_t.push(row);
                    }

                    $('#inact_mem_table').html(html_t);

                }

            });
        }

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.business', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>