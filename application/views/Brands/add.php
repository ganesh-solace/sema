    <?php 
    $ClassID = (isset($BrandData[0]) && !empty($BrandData[0]->ClassID)) ?  $BrandData[0]->ClassID : null;
    $ID = (isset($BrandData[0]) && !empty($BrandData[0]->ID)) ?  $BrandData[0]->ID : null;
    $Code = (isset($BrandData[0]) && !empty($BrandData[0]->Code)) ?  $BrandData[0]->Code : '';
    $CreatedDate = (isset($BrandData[0]) && !empty($BrandData[0]->CreatedDate)) ?  $BrandData[0]->CreatedDate : '';
    $action = (isset($action) && !empty($action))  ? $action : 'add';
    // print_r($BrandData);
    if(isset($BrandData[0]) && !empty($BrandData[0])) {
        $BrandCode = $BrandData[0]->BrandCode;
    } else {
        $BrandCode ="";
    }
    
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
                    //   $BrandPostID = array( 'name' => 'ID', "value" => $ID, id="BrandID" 'type'=> 'hidden');
                    // echo form_input($BrandPostID);
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
                            // print_r($BrandData[0]);exit;
                            $BrandName =  isset($BrandData[0]) && !empty($BrandData[0]) ? $BrandData[0]->BrandName : "";
                            $BrandNameAttribute = array( 'name' => 'Name','id' => 'BrandName','class'=> "form-control", "value" => $BrandName);
                            echo form_input($BrandNameAttribute); ?>
                            <?php echo form_error('Brand name'); ?>
                        </div>
                    </div>
                </div>
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label('Short Name :','ShortName'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                            // print_r($BrandData[0]);exit;
                            $BrandName =  isset($BrandData[0]) && !empty($BrandData[0]) ? $BrandData[0]->ShortName : "";
                            $BrandNameAttribute = array( 'name' => 'ShortName','id' => 'ShortName','class'=> "form-control", "value" => $BrandName);
                            echo form_input($BrandNameAttribute); ?>
                            <?php echo form_error('Short name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row add-code-row">
                         <?php
                         $BrandCodeAttr = array( 'id' => 'BrandCode','class'=> "form-control input-count", "status" => 1);
                         $AddNewButton = array( 'class' => 'btn btn-success',"id" => 'AddNewRow');
                         ?>
                         <div class="col-md-4"> <?php echo form_label('Brand Code :','BrandCode'); ?> </div>
                          <div class=" col-md-2">
                          <?php   echo form_button('Add','Add', $AddNewButton); ?> 
                        </div>
                         <div class="col-md-6"><?php echo form_input($BrandCodeAttr); ?></div>
                         
                    </div>                     
                </div>
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo form_label('Sema Brand Alias :','SemaBrandAlias'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                            $SemaBrandAlias =  isset($BrandData[0]) && !empty($BrandData[0]) ? $BrandData[0]->SemaBrandAlias : "";
                            $SemaBrandAliasAttribute = array( 'name' => 'SemaBrandAlias','id' => 'SemaBrandAlias','class'=> "form-control", "value" => $SemaBrandAlias);
                            echo form_input($SemaBrandAliasAttribute); ?>
                            <?php echo form_error('Sema Brand Alias'); ?>
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
                        <?php $SubmitExtra = array( 'class' => 'btn btn-primary',"id" => 'FormSubmit');
                        echo form_submit('Submit','Submit', $SubmitExtra);
                        
                        $ButtonExtra = array( 'class' => 'btn btn-danger',"data-dismiss"=> "modal","id" => 'ModalClose');
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
    var action = "<?php echo $action; ?>";
    var BrandCode = "<?php echo $BrandCode;?>";           
    var BrandCodeResult = BrandCode.split(',');

    if(action != "add") {
        var BrandID = "<?php echo $ID; ?>";
        var PostData = {   "BrandID" :  BrandID };

        $.ajax({
            url: "<?php echo base_url();?>"+"brands/ajaxGetData",
            type: 'POST',                    
            dataType: "json",                    
            data: PostData,
            success: function(data) {
                console.log(data);
                $.each(data, function(index, Tevalue) {
                //      if(index == 0) {
                //     $("#BrandCode").val(Tevalue["BrandCode"]);
                //     $("#BrandCode").parent("div").append('<input type="hidden" name="CodeID[]" value="'+Tevalue['ID']+'" />');
                // } else {
                    generateHTMLStringEditCase(Tevalue["BrandCode"], 0,Tevalue['ID'],index);
                // }
                console.log($("input[name='BrandCode[]']"));
                });
                $("input[name='BrandCode[]']").prop("readonly",true);
            }
        });          
    }

    function generateHTMLStringEditCase(Code, flag,CodeID,key) {
          var BrandID = "<?php echo $ID; ?>";
          var RowState = "436";
          if(flag == 1) {
              key = $(".input-count").length - 1;
             var RowState = "435";
          }
         var GenerateAddHTMLStr = "";
             GenerateAddHTMLStr += '<div class="row add-code-row">';
             GenerateAddHTMLStr += '<div class="col-md-6"></div>';
             GenerateAddHTMLStr += '<div class="col-md-4">';
             GenerateAddHTMLStr += '<input type="text" class="form-control input-count readonly-set" name="Brand['+key+'][BrandCode]" value="'+Code+'" />';
             GenerateAddHTMLStr += '<input type="hidden"  name="Brand['+key+'][CodeID]" value="'+CodeID+'" />';
             GenerateAddHTMLStr += '<input type="hidden" id="RowState"  name="Brand['+key+'][RowState]" value="'+RowState+'" />';
             GenerateAddHTMLStr +='</div>';
             GenerateAddHTMLStr += '<div class="col-md-1 button-space"><button class="btn btn-default Delete-row-up" onclick="DeleteRow($(this),'+0+');">Del</button></div>';
             GenerateAddHTMLStr +='</div>';

             $("#AddNewRow").parents("div.row").find("#BrandCode").val("");
             $("#AddNewRow").parents("div.row").after(GenerateAddHTMLStr);
             setReadonlyAttribute( 0, "" );
    }

    // multiselect checkbox for class
        $( '#SemaClassList').multiselect({
            includeSelectAllOption: true,
            selectAll: true
        });
        
        $("#AddNewRow").click(function(){
            if($("div.text-danger").length > 0 ){
                $("div.text-danger").remove(); 
            }
            
            var InputValue = $(this).parents("div.row").find("#BrandCode").val();
            InputValue = InputValue.trim();
            if(InputValue == "") {
                alert("Please add brand Code");
            } else {
                generateHTMLStringEditCase( InputValue,1,0 );
                // if(action == 'edit') {
                //     setReadonlyAttribute($(this));
                // }
                setReadonlyAttribute(1,$(this));
            }
        });
       
       function setReadonlyAttribute(ReadonlyFlag, obj) {
           
           if(ReadonlyFlag == 0 ) {
               $(".readonly-set").prop("readonly",true);
           }
       }

       
        // set class in edit mode
        if(ClassID != '') {
           var selectedOptions = ClassID.split(",");
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
             var BrandCode = "";
            if(typeof $("input.readonly-set").val() != "undefined"){
                BrandCode = $("input.readonly-set").val();
            }
            
            var FormData = {   Name : $('#BrandName').val(), BrandCode: BrandCode   };

                var flag = false;
            $.ajax({
                url: "<?php echo base_url();?>"+"brands/ajaxValidation",
                type: 'POST',                    
                dataType: "json",                    
                data: FormData,
                success: function(data) {
                    if( !$.isEmptyObject(data)) {
                        $("div.text-danger").remove(); 
                        $.each(data["error"], function(i,Values) {
                            var ElementAddError =  $("#BrandCode");

                            if($("input[name='"+Values["key"]+"']").length > 0 ){
                                    var ElementAddError =  $("input[name='"+Values["key"]+"']");
                            }

                                ElementAddError.after('<div class="text-danger">'+Values["value"]+'</div>');
                            
                        });
                    }  else {
                        if( $(".error").length > 0 ) $("div.text-danger").remove(); 
                        $("#BrandAdd").submit();
                    }
                }
            });
        });
    });


    function DeleteRow(e,flag) {
        event.preventDefault();
        e.parent().parent("div.row").find("#RowState").val("437");
        e.parent().parent("div.row").css("display","none");
    }


</script>