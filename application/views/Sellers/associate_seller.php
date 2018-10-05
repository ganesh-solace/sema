
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
            <?php
                  $attributes = array( 'id' => 'AssociateSeller');
                    echo form_open('sellers/AssociateSeller', $attributes);

            ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo form_label('Brand List :','BrandID'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php    
                        $BrandAttr = array('id'       => 'BrandDropDown','class'=> 'form-control');         
                    
                        echo form_dropdown('BrandID', $BrandList,"", $BrandAttr); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo form_label('Seller List :','SellerID'); ?>
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
            <div class="form-group">
                    <div class="row text-right margin-right-0">
                        <?php $SubmitExtra = array( 'class' => 'btn btn-default',"id" => 'FormSubmit');
                        echo form_submit('Submit','Submit', $SubmitExtra);
                        
                        $ButtonExtra = array( 'class' => 'btn btn-default',"data-dismiss"=> "modal","id" => 'ModalClose');
                        echo form_button('Close','Close', $ButtonExtra);
                        ?>
                    </div>
                </div>
            <?php
                $CreatedDatePost = array( 'name' => 'CreatedDate', "value" => "",'type'=> 'hidden');
                echo form_input($CreatedDatePost);
                echo form_close();
            ?>
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

        // if value is deafult selected display the respective seller
        MultiSellerCheckSelect($("#BrandDropDown").val());

        // change the brands and dislay the default seller selected
        $("select#BrandDropDown").change(function() {
            var data = {"BrandID" : $(this).val() };
            $.ajax({
                url: "<?php echo base_url();?>"+"sellers/AjaxgetSellerID",
                type: 'POST',                    
                dataType: "json",                    
                data: data,
                success: function(data) {
                    var SellerID = data.SellerID;
                    if( !$.isEmptyObject({ SellerID }) ) {
                        if( SellerID[0]['SellerID'] != null) {
                            MultiSellerCheckSelect( SellerID[0]['SellerID'] );
                        }                             
                    }                        
                }
            });
        });

        // default check the checkbox in multi-select drop downlist
        function MultiSellerCheckSelect( SellerID ) {
             var selectedOptions = SellerID.split(",");
            for(var i in selectedOptions) {
                 var optionVal = selectedOptions[i];
                $("select#SellerMultiSelect").find("option[value="+optionVal+"]").prop("selected", "selected");
            }
             $("select#SellerMultiSelect").multiselect('reload');
        }

        // popup modal close
          $( "#ModalClose" ).click( function() {
                $( "#append_brand_form" ).modal( 'hide' );
                $( "div.modal-backdrop" ).removeClass( "show" );            
                $( "div.modal-backdrop" ).addClass( "hide" );            
                $( "#append_brand_form" ).html("");
        });
    });    
        </script>