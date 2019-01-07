<div class="container panel panel-body">
    <div id="append_brand_form" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" data-target="#myModal"></div>

    <div class="row">
        <div class="col-md-6">
            <!-- just part logo  -->
            <div class="row margin-bottom padding-5">
                <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.jpg">
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
             <div class="row title-orange">
                <h3><strong ><?php  echo $BrandData[0]["AppendBrandCode"]; ?></strong></h3>
            </div>
            <div class="row border-bottom padding-5">
                <h4><strong>Brand Summary</strong></h4>
            </div>
            <div class="row padding-5">
            
            <?php
                foreach($BrandData as $brand):
            ?>
                <div class="col-md-5 padding-5"><span>Associated Date: </span></div><div class="col-md-7 padding-5"><span><?php echo (isset($brand['CreatedDate'])) ? $brand['CreatedDate'] : '-' ?></span></div>
                <div class="col-md-5 padding-5"><span>Last Data Refresh: </span></div><div class="col-md-7 padding-5"><span><b><?php echo  (isset( $LastDataRefresh ) && !empty( $LastDataRefresh ) )  ? $LastDataRefresh : "-" ; ?></b></span></div>
                
                <div class="col-md-5 padding-5"><span>Number of Items: </span></div><div class="col-md-7 padding-5"><span><?php echo (isset($brand['NumberOfItem'])) ? $brand['NumberOfItem'] : '-' ?></span></div>

                <div class="col-md-5 padding-5"><span>SEMA Brand Class: </span></div><div class="col-md-7 padding-5"><span><?php echo (isset($brand['ClassName'])) ? $brand['ClassName'] : '-' ?></span></div>
                
 
            <?php
                endforeach;
            ?>
             <div class="col-md-5 padding-5"><span>Associate Sellers: </span></div><div class="col-md-7 padding-5"><span><?php echo (isset($NumberOfAssociateSeller[0]['AssociateSeller'])) ? $NumberOfAssociateSeller[0]['AssociateSeller'] : '-' ?></span></div>

                <div class="col-md-5 padding-5"><span>Associate Webstores: </span></div><div class="col-md-7 padding-5"><span><b>15</b></span></div>
            </div>
             <div class="row border-bottom padding-5">
                <h4><strong>Brand FTP Path Details</strong></h4>
            </div>
              <?php 
                $BrandDisplayFolder = strtolower($brand["Name"]); 
                $BrandDisplayFolder = str_replace(" ", "_", $BrandDisplayFolder);
                $BrandDisplayFolder = EXCEL_FILE_PATH.$BrandDisplayFolder;
                $BrandCode = strtolower($brand["BrandCode"]);
                $BrandCode = str_replace(" ", "_", $BrandCode);
                $BrandDisplayFolder =  $BrandDisplayFolder."/".$BrandCode;

                // print_r($BrandData[0]["CodeID"]);
                 
               ?>
            <div class="row padding-5">
                <div class="col-md-4"> With fitment: </div>
                <div class="col-md-8"><?php  echo $BrandDisplayFolder."/with_fitment/";?> </div>
            </div>
            <div class="row padding-5">
                <div class="col-md-4"> Without fitment: </div>
                <div class="col-md-8"> <?php  echo $BrandDisplayFolder."/without_fitment/";?> </div>
            </div>
            <div class="row padding-5">
                <div class="col-md-4"> Images: </div>
                <div class="col-md-8"> <?php  echo $BrandDisplayFolder."/images/";?>  </div>
            </div>
        </div>
        
        <div class="col-md-6 ">

            <div class="row border-bottom padding-5">
                <div class="col-md-6"> <h4><strong>Associated Seller</strong></h4></div>
                <div class="col-md-6 text-right color-blue"><h5>See all <?php echo (isset($NumberOfAssociateSeller[0]['AssociateSeller'])) ? $NumberOfAssociateSeller[0]['AssociateSeller'] : '-' ?>     sellers</h5></div>
            </div>

            <div class="row padding-5">
                <?php
                    if( isset( $seller_list ) && !empty( $seller_list ) ) {
                        foreach ($seller_list as $seller) { 
                            // print_r( $seller );
                            // $SellerName = $seller['FirstName']." ".$seller['LastName'];
                            $SellerName = $seller['JPSellerName'];
                            ?>
                            <div class="col-md-4 padding-5"><a class="SellerDisplay" value="<?php echo $seller["ID"]; ?>"><?php echo $SellerName; ?></a> </div>
                            <?php
                        }
                    }
                ?>
            </div>

            <div class="row padding-5">
                <button type="button" id="AssociateSeller" class="btn btn-warning btn-block">Associate New Seller</button>
            </div>

            <div class="row border-bottom padding-5">
                <div class="col-md-6"> <h4><strong>Set Title Configuration</strong></h4></div>               
            </div>
             <div class="row">
                    <div class="col-md-6 padding-5"><button type="button" id="SetTitle" class="btn btn-warning btn-block">Set Title</button></div>
                    <div class="col-md-6 padding-5">
                    <?php
                        $TitleDisplaylabel = "-";
                        if(isset($TitleDisplayData) && !empty($TitleDisplayData)){
                            if(isset($TitleDisplayData[0]->BrandTitle)){
                                $TitleDisplaylabel = str_replace(","," - ", $TitleDisplayData[0]->BrandTitle);
                            }
                        }
                    ?>
                    <label><?php echo $TitleDisplaylabel; ?></label>
                    </div>
                </div>

                <div class="row border-bottom padding-5">
                <div class="col-md-6"> <h4><strong>Set Tag Configuration</strong></h4></div>             
            </div>
            <div class="row">
                    <div class="col-md-5 padding-5"><button type="button" id="SetTag" class="btn btn-warning btn-block">Add Tag</button></div>
                    <div class="col-md-7 padding-5 text-center">
                   		<div  class="color-blue" id="AllTags"> view All Tags</div>
                    </div>
                </div>

        </div>
    </div>
    <div class="row padding-5 pull-right">
        <?php
                $PreviousExtra = array( 'class' => 'btn btn-primary',"id" => 'Previous', "onClick" =>"document.location.href='DashBoards'");
                echo form_button('Previous','Previous page', $PreviousExtra);
        ?>
    </div>
</div>

<script type="text/javascript">
jQuery( document ).ready(function( $ ) {
    $("a.SellerDisplay").click(function() {
        // var BrandName = "<?php //echo $BrandData[0]["Name"]; ?>";
        var BrandName = "<?php echo $BrandData[0]["AppendBrandCode"]; ?>";
        
        var BrandID = "<?php echo $BrandData[0]["ID"]; ?>";
        var CodeID = "<?php echo $BrandData[0]["CodeID"]; ?>";
        var data = {'id': $(this).attr('value'), "BrandName": BrandName,"BrandID":BrandID,"CodeID":CodeID};
        // console.log(data);return false;
        var url = "<?php base_url()?>sellers";
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

     // open the asscoiate seller pop up
          $( "#AssociateSeller" ).click( function() {   
             var BrandID = "<?php echo $BrandData[0]["ID"]; ?>"; 
             var CodeID = "<?php echo $BrandData[0]["CodeID"]; ?>";     
             var BrandData = { "BrandID" : BrandID, "CodeID" : CodeID, "action" : "summary" };             
            $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'sellers/AssociateSellerSummary'; ?> " , BrandData );
            $( "#append_brand_form" ).modal( "show" );
        });


        //Set TITLE
        $("#SetTitle").click(function(){
             var BrandID = "<?php echo $BrandData[0]["ID"]; ?>"; 
             var CodeID = "<?php echo $BrandData[0]["CodeID"]; ?>";     
             var BrandData = { "BrandID" : BrandID, "CodeID" : CodeID, "action" : "summary" }; 
              $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'summary/SetDisplayTitle'; ?> " , BrandData );
            $( "#append_brand_form" ).modal( "show" );
        });


        $("#SetTag").click(function(){
			var BrandName = "<?php echo $BrandData[0]["AppendBrandCode"]; ?>";
			var BrandID = "<?php echo $BrandData[0]["ID"]; ?>";
			var CodeID = "<?php echo $BrandData[0]["CodeID"]; ?>";
			var data = {"BrandName": BrandName,"BrandID":BrandID,"CodeID":CodeID};
			// console.log(data);return false;
			var url = "<?php base_url()?>TagManagements/DisplayTagPopUp";
			//  url_redirect({url:url,  method: "post",data: data});
			$( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'TagManagements/DisplayTagPopUp'; ?> " , data );
			$( "#append_brand_form" ).modal( "show" );
        });

        $("#AllTags").click(function() {
        	var BrandName = "<?php echo $BrandData[0]["AppendBrandCode"]; ?>";
			var BrandID = "<?php echo $BrandData[0]["ID"]; ?>";
			var CodeID = "<?php echo $BrandData[0]["CodeID"]; ?>";
			var data = {"BrandName": BrandName,"BrandID":BrandID,"CodeID":CodeID};
			// console.log(data);return false;
			$( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'TagManagements/ViewAllTagsPopUp'; ?> " , data );
			$( "#append_brand_form" ).modal( "show" );
        });
});
</script>