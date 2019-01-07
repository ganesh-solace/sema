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
                      $BrandPostID = array( 'name' => 'Brand[ID]', "value" => $ID,'type'=> 'hidden');
                    echo form_input($BrandPostID);
                    $BrandPostCode = array( 'name' => 'Brand[Code]', "value" => $Code,'type'=> 'hidden');
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
                            $BrandNameAttribute = array( 'name' => 'Brand[Name]','id' => 'BrandName','class'=> "form-control", "value" => $BrandName);
                            echo form_input($BrandNameAttribute); ?>
                            <?php echo form_error('Brand name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                     <div class="row add-code-row">
                         <?php
                         $BrandCodeAttr = array( 'name' => 'temp','id' => 'BrandCode','class'=> "form-control input-count", "status" => 1);
                         $AddNewButton = array( 'class' => 'btn btn-default',"id" => 'AddNewRow');
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
                            $SemaBrandAliasAttribute = array( 'name' => 'Brand[SemaBrandAlias]','id' => 'SemaBrandAlias','class'=> "form-control", "value" => $SemaBrandAlias);
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
                            $BrandDescriptionAttribute = array('name'=> 'Brand[Description]', 'id' => 'BrandDescription','value'=> $BrandDescription, 'rows' => '4','class'=> "form-control");
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
                                        echo form_multiselect('Brand[]ClassID[]', $SemaClassList,'',$js); ?>
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
                    generateHTMLString(Tevalue["BrandCode"], 0,Tevalue['ID']);
                // }
                // console.log($("input[name='BrandCode[]']"));
                });
                $("input[name='BrandCode[]']").prop("readonly",true);
            }
        });          
    }

    // multiselect checkbox for class
        $( '#SemaClassList').multiselect({
            includeSelectAllOption: true,
            selectAll: true
        });
        
        $("#AddNewRow").click(function(){
            var InputValue = $(this).parents("div.row").find("#BrandCode").val();
            InputValue = InputValue.trim();
            if(InputValue == "") {
                alert("Please add brand Code");
            } else {
                // if(action == "edit") disFlag = 0; else disFlag = 1;
                generateHTMLString( InputValue,1,0 );
                if(action == 'edit') {
                    setReadonlyAttribute($(this));
                }
            }
        });
       
       function setReadonlyAttribute(obj) {
           $("input[name='BrandCode[]']").prop("readonly",true);
           obj.parent().next("div").children("input#BrandCode").attr("readonly",false);
           var inputFielValue = obj.parent().next("div").children('input[type="hidden"]').val();
           obj.parent().next("div").children('input[type="hidden"]').val(0);
        obj.parent().parent(".add-code-row").next(".add-code-row").children("div.col-md-4").find('input[type="hidden"]').val(inputFielValue);
           
        //    console.log();
       }

       function generateHTMLString( InputValue,flag,CodeID ) {
            var GenerateAddHTMLStr = "";
            GenerateAddHTMLStr += '<div class="row add-code-row">';
            GenerateAddHTMLStr += '<div class="col-md-6"></div>';
            GenerateAddHTMLStr += '<div class="col-md-4">';
                GenerateAddHTMLStr += '<input type="text" class="form-control input-count" name="BrandCode[]" value="'+InputValue+'" status="1" />';
            //      if(flag == 0 ) {
            //          GenerateAddHTMLStr += '<input type="hidden"  name="CodeID" value="'+CodeID+'" />';
            // }
             GenerateAddHTMLStr += '<input type="hidden"  name="CodeID[]" value="'+CodeID+'" />';
            GenerateAddHTMLStr += '</div>';
           
         //   GenerateAddHTMLStr += '<div class="col-md-2 button-space"><button class="btn btn-default">Edit</button>';
          //  GenerateAddHTMLStr += '</div>';                    
            GenerateAddHTMLStr += '<div class="col-md-1 button-space"><button class="btn btn-default Delete-row-up" onclick="DeleteRow($(this),'+flag+');">Del</button>';
            GenerateAddHTMLStr += '</div>';
            GenerateAddHTMLStr += '</div>';
            if(flag != 0){
                 $("#AddNewRow").parents("div.row").find("#BrandCode").val("");
            } 
            $("#AddNewRow").parents("div.row").after(GenerateAddHTMLStr);
       }
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
             var BrandCode = "";
            if(typeof $("input[name='BrandCode[]']").val() != "undefined"){
                BrandCode = $("input[name='BrandCode[]']").val();
            }
            var FormData = {   Name : $('#BrandName').val(), BrandCode: BrandCode   };
            // console.log(FormData);return false;
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
                                    // console.log($("input[name='"+Values["key"]+"']"));
                                    // if(Values["key"] == "BrandCode[]"){
                                    //     ElementAddError =ElementAddError.eq(0);
                                    // }
                                   ElementAddError.after('<div class="text-danger">'+Values["value"]+'</div>');
                               
                           });
                       }  else {
                           if( $(".error").length > 0 ) $("div.text-danger").remove(); 
                            beforeSumitAddStatusFeild();
                            $("#BrandAdd").submit();
                       }
                    }
                });
        });
    });

function beforeSumitAddStatusFeild() {
     $.each($("input[name='BrandCode[]']"), function(k,Status) {
         $('<input />').attr('type', 'hidden')
          .attr('name', "Status[]")
          .attr('value',$(this).attr("status"))
          .appendTo('#FormSubmit');
     });
}

        function DeleteRow(e,flag) {
          event.preventDefault();
        //   if(flag == 1) {
        // e.parent().parent("div.row").remove();
        // $(".Delete-row-up").parent().parent().find("input[name='BrandCode[]']").attr("status",0);
        //   } else {
              e.parent().parent("div.row").remove();
        //       $(".Delete-row-up").parent().parent().find("input[name='BrandCode[]']").attr("status",0);
        //   } 
        //         e.parent().parent("div.row").css("display",'none');
        // e.parent().parent().find("input[name='BrandCode[]']").attr("status",0);         
        }


</script>