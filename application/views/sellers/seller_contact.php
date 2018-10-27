<script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content col-md-10">
            <div class="modal-header">
                <div class="row text-center ">
                    <h3> View Contact Details </h3>
                </div>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 ">
                             <?php echo form_label('Seller Name :','SellerName'); ?>
                        </div>
                        <div class="col-md-7">
                             <?php
                              $JPSellerName = $SellerData->JPSellerName;
                             ?>
                            <span>  <?php echo $JPSellerName; ?> </span>
                        </div>
                    </div>
                     <div class="row">  
                        <div class="col-md-5 ">
                             <?php echo form_label('Contact :','Contact'); ?>
                        </div>
                        <div class="col-md-7">
                             <?php                             
                             $Name = $SellerData->FirstName." ".$SellerData->LastName;
                             ?>
                        <span><?php echo $Name; ?> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <?php echo form_label('Address :','Address'); ?>
                        </div>
                        <div class="col-md-7">
                            <?php $Address = $SellerData->Address; ?>
                            <span>
                                <?php echo $Address; ?> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <?php echo form_label('Email :','Email'); ?>
                        </div>
                        <div class="col-md-7">
                            <?php $Email = ( !empty( $SellerData->Email ) ) ? $SellerData->Email : "-"; ?>
                            <span>
                                <?php echo $Email; ?> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <?php echo form_label('Mobile :','Mobile'); ?>
                        </div>
                        <div class="col-md-7">
                            <?php $Mobile = (!empty( $SellerData->Mobile ) ) ?$SellerData->Mobile : "-"; ?>
                            <span>
                                <?php echo $Mobile; ?> </span>
                        </div>
                    </div>
               
                <div class="row text-right padding-20">
            <?php
                 $ButtonExtra = array( 'class' => 'btn btn-default',"data-dismiss"=> "modal","id" => 'ModalClose');
                 echo form_button('Close','Close', $ButtonExtra);
            ?>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery( document ).ready(function( $ ) {
        $("#ModalClose").click(function() {
            $( "#append_brand_form" ).modal( 'hide' );
            $( "div.modal-backdrop" ).removeClass( "show" );            
            $( "div.modal-backdrop" ).addClass( "hide" );            
            $( "#append_brand_form" ).html("");
        });
    });    
</script>