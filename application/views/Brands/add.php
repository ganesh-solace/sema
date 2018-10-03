<?php 
    $ClassID = (isset($BrandData[0]) && !empty($BrandData[0]->ClassID)) ?  $BrandData[0]->ClassID : null;
    $ID = (isset($BrandData[0]) && !empty($BrandData[0]->ID)) ?  $BrandData[0]->ID : null;
    $Code = (isset($BrandData[0]) && !empty($BrandData[0]->Code)) ?  $BrandData[0]->Code : '';
    $CreatedDate = (isset($BrandData[0]) && !empty($BrandData[0]->CreatedDate)) ?  $BrandData[0]->CreatedDate : '';
    $action = (isset($action) && !empty($action))  ? $action : 'add';
?>
<script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row text-center ">
                    <h3> <?php echo $PageTitle; ?> </h3>
                </div>
            </div>
            <div class="modal-body">
                
                <?php  
                    $attributes = array( 'id' => 'BrandAdd');
                    echo form_open('brands/'.$action, $attributes);
                      $BrandPostID = array( 'name' => 'ID', "value" => $ID,'type'=> 'hidden');
                    echo form_input($BrandPostID);
                    $BrandPostCode = array( 'name' => 'Code', "value" => $Code,'type'=> 'hidden');
                    echo form_input($BrandPostCode);
                    ?>
                    
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label('Brand Name :','Name'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                            $BrandName =  isset($BrandData[0]) && !empty($BrandData[0]) ? $BrandData[0]->Name : "";
                            $BrandNameAttribute = array( 'name' => 'Name','id' => 'BrandName','class'=> "form-control", "value" => $BrandName);
                            echo form_input($BrandNameAttribute); ?>
                            <?php echo form_error('Brand name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label('Description :','Description'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                             $BrandDescription =  isset($BrandData[0]) && !empty($BrandData[0]) ? $BrandData[0]->Description : "";
                            $BrandDescriptionAttribute = array('name'=> 'Description', 'id' => 'BrandDescription','value'=> $BrandDescription, 'rows' => '4','class'=> "form-control");
                                echo form_textarea($BrandDescriptionAttribute);
                             ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label('Sema Class :','ClassID'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                        $js = array(  'id'       => 'SemaClassList' );
                
                                        $SemaClassList =  (isset( $SemaClassList ) && !empty( $SemaClassList )) ? $SemaClassList : "";
                                        echo form_multiselect('ClassID[]', $SemaClassList,'',$js); ?>
                            <?php echo form_error('Sema Class'); ?>
                        </div>
                    </div>
                </div>
                 <div class="form-group">
                    <div class="row text-center">
                        <?php $SubmitExtra = array( 'class' => 'btn btn-default',"id" => 'FormSubmit');
                        echo form_submit('Submit','Submit', $SubmitExtra);
                        
                        $ButtonExtra = array( 'class' => 'btn btn-default',"data-dismiss"=> "modal","id" => 'ModalClose');
                        echo form_button('Close','Close', $ButtonExtra);
                        ?>
                    </div>
                </div>
                <?php
                 $CreatedDatePost = array( 'name' => 'CreatedDate', "value" => $CreatedDate,'type'=> 'hidden');
                    echo form_input($CreatedDatePost);
                echo form_close(); ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
   jQuery( document ).ready(function( $ ) {
    var ClassID = "<?php echo $ClassID; ?>";
    // multiselect checkbox for class
        $( '#SemaClassList').multiselect({
            includeSelectAllOption: true,
            selectAll: true
        });
        
        // set class in edit mode
        if(ClassID != '') {
           var selectedOptions = ClassID.split(",");
            // console.log( selectedOptions );
            for(var i in selectedOptions) {
            var optionVal = selectedOptions[i];
                $("select").find("option[value="+optionVal+"]").prop("selected", "selected");
            }
             $("select").multiselect('reload');
        } 
    
        // on click of close button exit the modal popup
        $( "#ModalClose" ).click( function() {
            $( "#append_brand_form" ).modal( 'hide' );
            $( "div.modal-backdrop" ).removeClass( "show" );            
            $( "div.modal-backdrop" ).addClass( "hide" );            
            $( "#append_brand_form" ).html("");
        });


        $("#FormSubmit").click(function( e ) {            
            e.preventDefault();
            var FormData = {   Name : $('#BrandName').val()   };
                var flag = false;
                $.ajax({
                    url: "<?php echo base_url();?>"+"brands/ajaxValidation",
                    type: 'POST',                    
                    dataType: "json",                    
                    data: FormData,
                    success: function(data) {
                       if( !$.isEmptyObject(data)) {
                            $("#BrandName").after('<div class="error">'+data.error+'</div>');
                       }  else {
                           if( $(".error").length > 0 ) $("div.error").remove(); 
                            $("#BrandAdd").submit();
                       }
                    }
                });
        });
    });



</script>