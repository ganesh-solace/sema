<div class="container panel panel-body">
    <div id="append_brand_form" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" data-target="#myModal"></div>

    <div class="row">
        <div class="col-md-6">
        
            <!-- just part logo  -->
            <div class="row margin-bottom padding-5">
                <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.jpg">
            </div>
             <div class="row title-orange padding-5">
                <h3><strong ><?php echo $BrandName;?></strong></h3>
            </div>
               <div class="row color-blue margin-top-neg-20 padding-5">
                <h4><strong ><?php echo $SellerData[0]->JPSellerName."( ".$SellerData[0]->FirstName." ".$SellerData[0]->LastName." )";?></strong></h4>
            </div>
        </div>
        <div class="col-md-6">
                <div class="row padding-5">
                    <h2><b>Sema Data Co-Op</b></h2>
                </div> 
                <div class="row padding-5 sub-title-dashboard">
                    <h4>Data File Administration</h4>
                </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            
            <div class="row border-bottom padding-5">
                <h4><strong>Seller Summary</strong></h4>
            </div>
            <div class="row padding-5">
                <?php if(isset( $SellerData[0] ) && !empty( $SellerData[0] )) { 
                    foreach ($SellerData as $SellerKey => $SellerValue) {
                         $OnlineSince = date("F d, Y", strtotime($SellerValue->CreatedDate)); ?>
               
                <div class="row">
                <div class="col-md-5 padding-5"><span>Seller Name: </span></div><div class="col-md-3 padding-5"><span><?php echo $SellerData[0]->JPSellerName; ?></span></div><div class="col-md-4 padding-5"><span><a id="SellerContact">View Contact Details</a></span></div></div>
                 <div class="row">
                <div class="col-md-5 padding-5"><span>Business Name: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->BusinessName; ?></span></div></div>
                 <div class="row">
                <div class="col-md-5 padding-5"><span>Online Since: </span></div><div class="col-md-7 padding-5"><span><?php echo $OnlineSince; ?></span></div></div>
                 <div class="row">
                <div class="col-md-5 padding-5"><span>JustParts Seller ID: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->JPSellerID; ?></span></div></div>
                 <div class="row">
                <div class="col-md-5 padding-5"><span>Webstore URL: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->WebstoreURL; ?></span></div></div>
                 <div class="row">
                <div class="col-md-5 padding-5"><span>JustParts FTP Name: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->JPFTPName; ?></span></div></div>
              <?php   }              
                } ?>
            </div>
            
            <div class="row border-bottom padding-5">
                <h4><strong>Brand Summary</strong></h4>
            </div>
            <div class="row padding-5">
                <?php if(isset( $BrandData[0] ) && !empty( $BrandData[0])){
                    foreach ($BrandData as $BrandKey => $BrandValue) {
                        $AssociateDate = date("F d, Y", strtotime($BrandValue['CreatedDate'])); 
                    ?>                    
                <div class="row">
                <div class="col-md-5 padding-5"><span>Associated Date: </span></div><div class="col-md-7 padding-5"><span><?php echo $AssociateDate; ?></span></div></div>
                <div class="row">
                <div class="col-md-5 padding-5"><span>Last Data Refresh: </span></div>
                <?php 
                    if( isset( $LastDataRefresh ) && !empty( $LastDataRefresh ) ) {
                        $Time = date("h:i:s A", strtotime($LastDataRefresh['LastDataRefresh'] ) );
                        $LastDataRefresh = date("F d, Y", strtotime($LastDataRefresh['LastDataRefresh'] ) )." at ".$Time;
                        ?><div class="col-md-7 padding-5"><span><?php echo $LastDataRefresh; ?></span></div></div><?php
                    } else {
                        ?> <div class="col-md-7 padding-5"><span> - </span></div> </div><?php
                    }                    
                    ?>
                <div class="row">
                <div class="col-md-5 padding-5"><span>Number of Items: </span></div><div class="col-md-7 padding-5"><span><?php echo $BrandValue['NumberOfItem']; ?></span></div></div>
                <div class="row">
                <div class="col-md-5 padding-5"><span>SEMA Brand Class: </span></div><div class="col-md-7 padding-5"><span><?php echo $BrandValue['ClassName'];?></span></div></div>
                   <?php }
                } ?>
            </div>
            
            <div class="row border-bottom padding-5">
                <h4><strong>JustParts Import History (Last 15)</strong></h4>
            </div>
            <div class="row padding-5">
            <?php 
                    if( isset( $Last15ImportData ) && !empty( $Last15ImportData ) ) {
                        foreach ($Last15ImportData as $ImportKey => $ImportValue) {
                            $Time = date("h:i:s A", strtotime($ImportValue->LastSuccessImport ) );
                            $Last15ImportData = date("F d, Y", strtotime($ImportValue->LastSuccessImport ) )." at ".$Time;
                            ?><div class="col-md-5 padding-5"><span><?php echo $Last15ImportData; ?></span></div><?php
                        }
                    } else {
                        ?><div class="col-md-5 padding-5"><span> -  </span></div><?php
                    }
            ?>
            </div>
        </div>        
        <div class="col-md-6 ">
            <div class="row border-bottom padding-5">
                <h4><strong>Data Field Variables</strong></h4>
            </div>
            <div class="row padding-5">
                <div class="col-md-5 padding-5"><span>Price Adjustment: </span></div>
                <div class="col-md-7 padding-5"><span><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter">Create</a></span></div>
                <!-- <div class="col-md-5 padding-5"><span>xxxx </span></div>
                <div class="col-md-5 padding-5"><span>xxxx </span></div>
                <div class="col-md-5 padding-5"><span>xxxx </span></div> -->
            </div>

            <div class="row border-bottom padding-5">
                <h4><strong>JustParts Data Field Details</strong></h4>
            </div>
            <div class="row padding-5">
                <?php
                 $DataFeed =  (isset( $DataFeed ) && !empty( $DataFeed )) ? $DataFeed : "-"; 
                 $DataFeed = str_replace(" ", "_", $DataFeed);
                 ?>
                <div class="col-md-5 padding-5"><span>Data Feed Name: </span></div><div class="col-md-5 padding-5 text-data-feed"><span><?php echo $DataFeed; ?></span></div>
                <div class="col-md-5 padding-5 display-none"><input name="DataFeed" Class="input-data-feed form-control" value="<?php echo $DataFeed; ?>" /></div>
                 <div class="col-md-2 padding-5  margin-right-0"><button class="btn-primary btn" id="EditDataFile"> Edit </button></div>
                 <div class="col-md-2 padding-5  margin-right-0 display-none"><button class="btn-primary btn" id="UpdateDataFile"> Update </button></div>
                <div class="col-md-5 padding-5"><span>Last Success Import: </span></div>
                <?php  if( isset( $LastSuccessImportHistory ) && !empty( $LastSuccessImportHistory ) ) {
                     $HistoryTime = date("h:i:s A", strtotime($LastSuccessImportHistory->LastSuccessImport ) );
                    $LastSuccessImportHistory = date("F d, Y", strtotime($LastSuccessImportHistory->LastSuccessImport ) )." at ".$HistoryTime;
                    ?> <div class="col-md-7 padding-5"><span><?php echo $LastSuccessImportHistory; ?></span></div> <?php
                } else {
                   ?> <div class="col-md-7 padding-5"><span> - </span></div> <?php
                }
                ?>
            </div>
            <div class="row padding-5">
              <?php
                 $DataFeedXLS =  (isset( $DataFeed ) && !empty( $DataFeed )) ? WEBSTORE_AUTOMATE_URL.$DataFeed : "-"; 
                 $DataFeedXLS = str_replace(".csv", ".xlsx", $DataFeedXLS);
                 $DataFeedXLS = str_replace(" ", "_", $DataFeedXLS);
                 ?>
                <div class="col-md-5 padding-5"><span>Webstore Automatic URL: </span></div>

                <div class="col-md-7 input-xls"><?php echo $DataFeedXLS;?></div>
            </div>
            
           <!--   <div class="row border-bottom padding-5">
                <h4><strong>Generate a script for Brand</strong></h4>
            </div>
            <div class="row padding-5">
              <div class="col-md-6"><label><?php //echo $BrandName;  echo "  - ".$SellerData[0]->JPSellerName."( ".$SellerData[0]->FirstName." ".$SellerData[0]->LastName." )"; ?></label></div>
              <div class="col-md-6 text-right"><?php
                  // $GenerateExtra = array( 'class' => 'btn btn-primary',"id" => 'Generate');
                  //+ echo form_button('Generate','Generate', $GenerateExtra);
                ?></div>
                
                
            </div> -->
        </div>
        
    </div>
     <div class="row padding-5 pull-right">
                <?php
                     $PreviousExtra = array( 'class' => 'btn btn-primary',"id" => 'Previous');
                        echo form_button('Previous','Previous page', $PreviousExtra);
                ?>
            </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">

      <!-- Modal content-->
       <div class="modal-content" style="border-radius: 0;">
        <div class="modal-header">
        
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Price Adjustment</b></h4>
        </div>
        <div class="modal-body">
            <?php
              $attributes = array( 'id' => 'PriceAdjustment');
              echo form_open('sellers/PriceAdjustment', $attributes);
              
               $BrandID = array( 'name' => 'BrandID','type'=>"hidden","value"=>$BrandData[0]["ID"]);
               echo form_input($BrandID);
                $SellerID = array( 'name' => 'SellerID','type'=>"hidden", "value"=>$SellerData[0]->ID);
               echo form_input($SellerID);
                 $BrandNameArr = array( 'name' => 'BrandName','type'=>"hidden", "value"=>$BrandName);
               echo form_input($BrandNameArr);
                  $BrandCodeArr = array( 'name' => 'CodeID','type'=>"hidden", "value"=>$BrandData[0]["CodeID"]);
               echo form_input($BrandCodeArr);

            ?>
              <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <?php
                            echo form_label('Type','TypeID'); ?>
                        </div>
                        <div class="col-md-9">
                            <?php
                                 $TypeID = (isset( $ExistingData ) && !empty($ExistingData[0]->TypeID )) ? $ExistingData[0]->TypeID : "";
                                 $BrandAttr = array('id'=> 'TypeDropDown','class'=> 'form-control');         
                                  echo form_dropdown('TypeID', $type,$TypeID, $BrandAttr);
                             ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <?php echo form_label('Amount','Amount'); ?>                        </div>
                         <div class="col-md-2">
                             <?php
                               $Amount = (isset( $ExistingData ) && !empty($ExistingData[0]->Amount )) ? $ExistingData[0]->Amount : "";
                                 $Amount = array( 'name' => 'Amount','class'=>"amount-input-style  form-control","value" => $Amount);
                                 echo form_input($Amount);
                             ?>
                             </div>
                             <div class="col-md-7">
                                 <?php
                                  $AmountTypeID = (isset( $ExistingData ) && !empty($ExistingData[0]->AmountTypeID )) ? $ExistingData[0]->AmountTypeID : "";
                                 $AmountAttr = array('id'=> 'AmountDropDown','class'=> 'form-control');         
                                  echo form_dropdown('AmountTypeID', $amount,$AmountTypeID, $AmountAttr);
                             ?> 
                        </div>                        
                    </div>
                </div>
                 <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <?php echo form_label('Base','BaseID'); ?>
                        </div>
                        <div class="col-md-9">
                            <?php
                             $BaseID = (isset( $ExistingData ) && !empty($ExistingData[0]->BaseID )) ? $ExistingData[0]->BaseID : "";
                                 $BaseAttr = array('id'=> 'BaseDropDown','class'=> 'form-control');         
                                  echo form_dropdown('BaseID', $base,$BaseID, $BaseAttr);
                             ?>
                        </div>
                    </div>
                </div>

             <div class="row padding-5 text-right margin-right-0">  
                <?php $SubmitExtra = array( 'class' => 'btn btn-primary',"id" => 'FormSubmit');
                        echo form_submit('Submit','Submit', $SubmitExtra);
                        
                        $ButtonExtra = array( 'class' => 'btn btn-danger',"data-dismiss"=> "modal","id" => 'ModalClose');
                        echo form_button('Close','Close', $ButtonExtra);
                        ?>
            <?php echo form_close();?>
        </div>
      </div>      
    </div>
  </div>
  <?php
  $SellerID = $SellerData[0]->ID;
  $BrandID = $BrandData[0]["ID"];
  $CodeID = $BrandData[0]["CodeID"];
  $GenerateBrandName = $BrandData[0]["Name"];
  ?>
<script type="text/javascript">
    jQuery( document ).ready(function( $ ) {

        // Generate a script for the brand seller

          $("#Generate").click(function() {
            var GenerateBrandName = "<?php echo $GenerateBrandName; ?>";
            var data = { 'GenerateBrandName': GenerateBrandName };
            var url = "<?php base_url()?>sellers/GenerateBrandScript";
            alert("hi");
             url_redirect({url:url,  method: "post",data: data});

            // alert(GenerateBrandName.trim());
            return false;
          });
        //open seller contact form 
        $("#SellerContact").click(function() {
            var PostURL = "<?php echo base_url().'sellers/SellerContactDetails'; ?>" ;
            var SellerID = "<?php echo $SellerID; ?>";
            var BrandID = "<?php echo $BrandID; ?>";
            $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            
            var data = { 'SellerID' : SellerID, 'BrandID': BrandID };
            //  url_redirect({url:PostURL,  method: "post",data: data});
            $( "#append_brand_form" ).load( PostURL, data );
            $( "#append_brand_form" ).modal( "show" );
        });

        // when click on edit button for data feed file 
        $("#EditDataFile").click(function() {
            $(this).parent().addClass("display-none");
            $("#UpdateDataFile").parent().removeClass("display-none");
            $(".text-data-feed").addClass("display-none");
             $(".input-data-feed").parent().removeClass("display-none");
        }); 

        // update button gneterate when value change for data feed file update the name of file in database
        $("#UpdateDataFile").click(function() {
            var SellerID = "<?php echo $SellerID; ?>";
            var BrandID = "<?php echo $BrandID; ?>";
            var CodeID = "<?php echo $CodeID; ?>";
            var FormData = { "BrandID" : BrandID, "SellerID" : SellerID,"CodeID": CodeID, "DataFeed" : $(".input-data-feed").val() };
            
            var AjaxUrl = "<?php base_url(); ?>"+"sellers/UpdateDataFeedFile";
            var ChangeDataXLSURL = "<?php echo WEBSTORE_AUTOMATE_URL; ?>";
             $.ajax({
                    url: AjaxUrl,
                    type: 'POST',                    
                    dataType: "json",                    
                    data: FormData,
                    success: function(data) {                        
                        if( data != "" ) {
                            $(".text-data-feed").children().html( data );
                            $(".input-data-feed").val( data );
                            var XLSData = data.replace(".csv", ".xlsx");
                            $(".input-xls").html( ChangeDataXLSURL+XLSData );
                        } else {
                            $(".text-data-feed").children().html( $(".input-data-feed").val() );
                        }
                        $("#EditDataFile").parent().removeClass("display-none");
                        $("#UpdateDataFile").parent().addClass("display-none");
                        $(".text-data-feed").removeClass("display-none");
                        $(".input-data-feed").parent().addClass("display-none");                      
                    }
                });
        });

        // got to previous page i.e summary page
        $("#Previous").click(function() {
            var BrandID = "<?php echo $BrandData[0]["ID"]; ?>";
            var CodeID = "<?php echo $BrandData[0]["CodeID"]; ?>";
            var data = { 'id': BrandID,"CodeID" :CodeID };
            var url = "<?php base_url()?>summary";
             url_redirect({url:url,  method: "post",data: data});
        });

        function url_redirect(options){
            var $form = $("<form />");                 
            $form.attr("action",options.url);
            $form.attr("method",options.method);                 
            for (var data in options.data)
            $form.append('<input type="hidden" name="'+data+'" value="'+options.data[data]+'" />');                      
            $("body").append($form);
            $form.submit();
        }
    });
</script>