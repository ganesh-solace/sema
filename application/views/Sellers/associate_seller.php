
<script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row text-center ">
                    <h3> Associate New Seller </h3>
                </div>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo form_label('Brand List :','BrandID'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php    
                        $BrandAttr = array('id'       => 'BrandDropDown');            
                        echo form_dropdown('BrandID', $BrandList,"", $BrandAttr); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo form_label('Brand List :','BrandID'); ?>
                    </div>
                    <div class="col-md-6">
                    <?php 
                        $js = array(  'id'       => 'SellerMultiSelect' );

                        $SellerList =  (isset( $SellerList ) && !empty( $SellerList )) ? $SellerList : "";
                        echo form_multiselect('SellerID[]', $SellerList,'',$js);
                    ?>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
   jQuery( document ).ready(function( $ ) {
        $( '#SellerMultiSelect').multiselect({
            includeSelectAllOption: true,
            selectAll: true
        });
    });    
        </script>