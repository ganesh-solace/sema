
<div class="container">
    <div class="col-md-6 login-panel" >
        <div class="col-md-12">
            <div class="row padding-5">
                <div class="col-md-12 text-center">
                    <div class="admin-logo-frame">
                        <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.jpg" />
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Admin Login</div>
                <div class="panel-body">                
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>users/login" autocomplete="off"> 
                    <fieldset>
                      

                       <div class="form-group">
                           <label class="control-label col-md-4" for="Name">User Name:</label>
                            <div class="col-md-7">
                                 <input type="text" class="form-control" id="UserName" name="Name" value="<?php echo set_value('Name'); ?>"><?php echo form_error('UserName', '<div class="text-danger">', '</div>'); ?>
                            
                            </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-4" for="password">Password:</label>
                            <div class="col-md-7">
                                 <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password'); ?>"><?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
                            
                            </div>
                        </div>
                        <div class="form-group">  
                        <?php $class = isset( $class ) ? $class : ""; ?>
                             <div class="col-sm-offset-2 row <?php echo $class; ?>">
                                    <?php echo isset($error_message) ? $error_message : ""; ?>
                            </div> 
                        </div>
                       
                        <div class="form-group">        
                          <div class="col-sm-offset-2 row">
                            <div class="checkbox">
                            <a href='<?php echo base_url(); ?>users/ResetPassword' id="ResetPassword"> forgot password? </a>
                                <!-- <label><input type="checkbox" name="remember"> Remember me</label> -->
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // jQuery( document ).ready( function( $ ) {
    //     $("#ResetPassword").click(function() {
    //          var data = {'id': $(this).val()};
    //             var url = "<?php //base_url()?>summary";
    //              url_redirect({url:url,  method: "post",data: data});
    //     });

    //     function url_redirect(options){
    //         var $form = $("<form />");                 
    //         $form.attr("action",options.url);
    //         $form.attr("method",options.method);                 
    //         for (var data in options.data)
    //         $form.append('<input type="hidden" name="'+data+'" value="'+options.data[data]+'" />');                      
    //         $("body").append($form);
    //         $form.submit();
    //     }
    // });
    
</script>
