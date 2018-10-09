<div class="container panel panel-body">
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
                <h4><strong ><?php echo $SellerData[0]->Name;?></strong></h4>
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
               
                <div class="col-md-5 padding-5"><span>Seller Name: </span></div><div class="col-md-3 padding-5"><span><?php echo $SellerValue->Name; ?></span></div><div class="col-md-4 padding-5"><span><a href="#">View Contact Details</a></span></div>
                <div class="col-md-5 padding-5"><span>Business Name: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->BusinessName; ?></span></div>
                <div class="col-md-5 padding-5"><span>Online Since: </span></div><div class="col-md-7 padding-5"><span><?php echo $OnlineSince; ?></span></div>
                <div class="col-md-5 padding-5"><span>JustParts Seller ID: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->JPSellerID; ?></span></div>
                <div class="col-md-5 padding-5"><span>Webstore URL: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->WebstoreURL; ?></span></div>
                <div class="col-md-5 padding-5"><span>JustParts FTP Name: </span></div><div class="col-md-7 padding-5"><span><?php echo $SellerValue->JPFTPName; ?></span></div>
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
                
                <div class="col-md-5 padding-5"><span>Associated Date: </span></div><div class="col-md-7 padding-5"><span><?php echo $AssociateDate; ?></span></div>
                <div class="col-md-5 padding-5"><span>Last Data Refresh: </span></div><div class="col-md-7 padding-5"><span>August 31, 2018 at 2:10:52 PM</span></div>
                <div class="col-md-5 padding-5"><span>Number of Items: </span></div><div class="col-md-7 padding-5"><span><?php echo $BrandValue['NumberOfItem']; ?></span></div>
                <div class="col-md-5 padding-5"><span>SEMA Brand Class: </span></div><div class="col-md-7 padding-5"><span><?php echo $BrandValue['ClassName'];?></span></div>
                   <?php }
                } ?>
            </div>
            
            <div class="row border-bottom padding-5">
                <h4><strong>JustParts Import History (Last 15)</strong></h4>
            </div>
            <div class="row padding-5">
                <div class="col-md-5 padding-5"><span>August 31, 2018 at 11:14:01 AM </span></div>
                <div class="col-md-5 padding-5"><span>August 31, 2018 at 2:10:52 PM </span></div>
                <div class="col-md-5 padding-5"><span>August 31, 2018 at 5:12:35 PM </span></div>
                <div class="col-md-5 padding-5"><span>September 5, 2018 at 8:51:01 AM </span></div>
            </div>
        </div>
        
        <div class="col-md-6 ">
            <div class="row border-bottom padding-5">
                <h4><strong>Data Field Variables</strong></h4>
            </div>
            <div class="row padding-5">
                <div class="col-md-5 padding-5"><span>Price Adjustment: </span></div>
                <div class="col-md-7 padding-5"><span><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter">Create</a></span></div>
                <div class="col-md-5 padding-5"><span>xxxx </span></div>
                <div class="col-md-5 padding-5"><span>xxxx </span></div>
                <div class="col-md-5 padding-5"><span>xxxx </span></div>
            </div>

            <div class="row border-bottom padding-5">
                <h4><strong>JustParts Data Field Details</strong></h4>
            </div>
            <div class="row padding-5">
                <div class="col-md-5 padding-5"><span>Data Feed Name: </span></div><div class="col-md-7 padding-5"><span>sema_bds-suspension.csv</span></div>
                <div class="col-md-5 padding-5"><span>Last Success Import: </span></div><div class="col-md-7 padding-5"><span>September 5, 2018 at 10:58:04 AM</span></div>
            </div>

        </div>
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
                <?php $SubmitExtra = array( 'class' => 'btn btn-default',"id" => 'FormSubmit');
                        echo form_submit('Submit','Submit', $SubmitExtra);
                        
                        $ButtonExtra = array( 'class' => 'btn btn-default',"data-dismiss"=> "modal","id" => 'ModalClose');
                        echo form_button('Close','Close', $ButtonExtra);
                        ?>
            <?php echo form_close();?>
        </div>
      </div>      
    </div>
  </div>