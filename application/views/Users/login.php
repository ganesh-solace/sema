
<div class="container">
    <div class="col-md-6" style="    margin-left: 271px;
    margin-top: 150px;">
        <div class="col-md-12">
            <div class="well well-sm">
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>users/login"> 
                    <fieldset>
                        <legend class="text-center header">User Login</legend>

                       <div class="form-group">
                           <label class="control-label col-md-4" for="Name">User Name:</label>
                            <div class="col-md-7">
                                 <input type="text" class="form-control" id="UserName" name="Name" value="<?php echo set_value('Name'); ?>"><?php echo form_error('user name'); ?>
                            
                            </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-4" for="password">Password:</label>
                            <div class="col-md-7">
                                 <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password'); ?>"><?php echo form_error('password'); ?>
                            
                            </div>
                        </div>
                        <div class="form-group">  
                             <div class="col-sm-offset-2 row">
                                    <?php echo isset($error_message) ? $error_message : ""; ?>
                            </div> 
                        </div>
                       
                        <div class="form-group">        
                          <div class="col-sm-offset-2 row">
                            <div class="checkbox">
                                <label><input type="checkbox" name="remember"> Remember me</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>