<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <style type="text/css">
            tr{ border: #e4e4e4 solid 1px; }
            td{ padding: 5px 10px; }
        </style>
        <script type="text/javascript">
        
         function GetCode(value){
           document.getElementById(value).select();
    	   document.execCommand('copy');
           $('#'+value).parent().append('<span style="color:red;" class="copied">copied</span>');
           $('iframe').attr("id",document.getElementById(value).value);
           $('.copied').delay(1000).fadeOut();
         }
         
         
         $('.model-popupbutton').on("click",function () {
            var filename = $(this).data('id');
            window.open("<?php echo e(url('/')); ?>/3dobject.php?file="+filename, "3D Model", "height=600,width=600");
         });
         
         
        </script>
    </head>
    <body>
                            <div class="col-sm-9 listbox">
							<h4 style="border-bottom: 1px solid #e4e4e4;padding-bottom: 10px;">Choose From Coupons Models List</h4>
                            <form role="form" id="uploadimages" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/media/search')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                   <div class="form-group">
                                   	<input type="text" placeholder="Search 3D Coupons" required="required" id="search" value="<?php echo e($keyword); ?>" class="form-control" name="search" style="margin-bottom: 10px;" /> <button class="btn btn-default btn-xs" >Search</button> <a href="<?php echo e(url('media')); ?>" class="btn btn-info btn-xs">Clear</a>
                                   </div> 
                            </form>
                            <div class="clearfix"></div>
                            
                                <table style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <td style="width: 80px;">Choose</td>
                                            <td style="width: 80px;"><strong>Image</strong></td>
                                            <td><strong>Name / Tags</strong></td>
                                            <!--td style="width: 120px; text-align: center;">&nbsp;</td-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <tr>
                                            <td class="text-center">
                                                <input id="use_this_model_<?php echo e($key); ?>" name="use_this_model_<?php echo e($key); ?>" type="hidden" onclick="GetCode('fbx_img_<?php echo e($image->id); ?>')" value="<?php echo e($image->image_fbx); ?>" />
                                                <input style="cursor: pointer;" type="radio" id="use_this_radio_<?php echo e($key); ?>" name="choose_image" value="<?php echo e($key); ?>" /></td>
                                           <td><img onclick="$('#use_this_radio_<?php echo e($key); ?>').prop('checked',true)" id="use_this_image_<?php echo e($key); ?>" src="<?php echo e(url('resources/assets/media')); ?>/<?php echo e($image->image_thumbnail); ?>" style="width: 80px; cursor: pointer;" ></td>
                                               <td><a href="#" style="cursor: pointer;" onclick="$('#use_this_radio_<?php echo e($key); ?>').prop('checked',true)"><?php echo e($image->image_tags); ?></a></td>
                                           <!--<td><input id="use_this_model_<?php echo e($key); ?>" name="use_this_model_<?php echo e($key); ?>" type="text" onclick="GetCode('fbx_img_<?php echo e($image->id); ?>')" value="<?php echo e($image->image_fbx); ?>" /></td>-->
                                           <td style="text-align: center;">
                                           <!--a style="float:left" href="<?php echo e(url('/')); ?>/3dobject.php?file=<?php echo e($image->image_fbx); ?>" target="_blank" class="btn btn-info btn-xs" >3D Object</a--->
                                           <a href="<?php echo e(url('/media/delete')); ?>/<?php echo e($image->id); ?>" class="btn btn-default btn-xs">X</a></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </tbody>                                    
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"><div style="text-align: center;height: 50px;"><?php echo e($images->links()); ?></div></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                </div>
                                <div class="col-sm-3" style="border-left: #e4e4e4 solid 1px;">
								<h4 style="border-bottom: 1px solid #e4e4e4;padding-bottom: 10px;">Upload Coupon Models</h4>
                                <form role="form" id="uploadimages" method="POST" enctype="multipart/form-data" action="<?php echo e(url('/media/create')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="form-group">
                                        <label>Image Name / Tags: </label><br/>
                                        <input type="text" name="image_name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail Image: </label>
                                        <input type="file" name="image_thumbnail" />
                                    </div>
                                    <!--div class="form-group">
                                        <label>FBX Image: </label>
                                        <input type="file" name="image_fbx" />
                                    </div-->
                                    <div class="form-group">
                                        <label>Copyright Image: </label><br/>
                                        <select name="image_private">
                                           <option value="0">No</option>
                                           <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="upload" value="Upload">Upload</button>
                                        <button type="reset" name="reset" id="resetform" value="reset">Clear</button>
                                    </div>
                                </form>
                            </div>         
                            <div class="clearfix"></div>               
                            
                            
                	
    </body>
</html>