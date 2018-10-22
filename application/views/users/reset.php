
<div class="container">    
    <div class="col-md-6 login-panel" >
        <div class="col-md-12">
            <div class="row padding-20">
                <div class="col-md-12 text-center">
                    <div class="admin-logo-frame">
                        <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.jpg" />
                    </div>
                </div>
            </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Password Reset</div>
                
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>users/ResetPassword">
                        <div class="control-group" style="display:none;">
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Error!</strong> No reset password 'from' email address specified for this site. Please contact support.
                            </div>
                        </div>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-4 content-left control-label" for="inputEmail">Email</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="email" id="inputEmail" placeholder="Email" name="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 content-left control-label" for="inputName">User Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="inputName" placeholder="User Name" name="UserName">
                                </div>
                            </div>
                            <div class="form-group">  
                                <?php $class = isset( $class ) ? $class : ""; ?>
                                <div class="col-sm-offset-2 text-center row <?php echo $class; ?>">
                                     <?php echo isset($error_message) ? $error_message : ""; ?>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-default pull-right">Reset Password</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <small><a href="<?php echo base_url(); ?>users">Back to login</a></small>
                    </div>
                </div>
        </div>
    </div>
</div>

