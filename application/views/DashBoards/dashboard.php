<div class="container panel panel-body">
    <div id="append_brand_form" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" data-target="#myModal"></div>
    <div class="row">
        <div class="col-md-6">
            <!-- just part logo  -->
            <div class="row margin-bottom padding-5">
                <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.jpg" />
            </div>
            <!--  dashboard group -->
            <div class="row  border-bottom padding-5">
                <h4><strong>Dashboard</strong></h4>
            </div>
            <div class="row padding-5"><span>134</span><span> Data files</span></div>
            <div class="row padding-5"><span>3</span><span> sellers link to data feeds</span></div>
            <!-- <div class="row padding-5"><span>XXXXXXX</span></div> -->
            
            <!-- Recdent group -->
            <div class="row border-bottom padding-5">
                <h4><strong>Recent</strong></h4>
            </div>
            <div class="row">
                <?php            
                     if( isset( $RecentBrandList ) && !empty( $RecentBrandList ) ) {
                        foreach ($BrandListWithCode as $Brandkey => $Brandvalue) {
                           ?>
                              <div class="col-md-4 padding-5 cursor">
                                <?php $BrandvalueId = str_replace(" ","_",$Brandvalue["BrandName"]["text"]); ?>
                                  <a value="<?php echo $Brandvalue["BrandName"]["value"]; ?>" class="BrandName"  data-toggle="collapse" href="#<?php echo $BrandvalueId;?>"><?php echo $Brandvalue["BrandName"]["text"]; ?>
                                 
                                  </a> 
                                 <ul class="BrandCode" id="<?php echo $BrandvalueId;?>">
                                   <?php
                                        foreach ($Brandvalue["BrandCode"] as $CodeKey => $CodeValue) { ?>
                                          <li value="<?php echo $CodeValue["value"];?>"><?php echo $CodeValue["text"]; ?></li>  
                                     <?php 
                                       }
                                   ?>
                                   </ul>
                              </div>
                <?php                            
                        }
                     }
                ?>
            </div>
            <!-- View Brand details -->
            <div class="row border-bottom padding-5">
                <h4><strong>View Brand Details</strong></h4>
            </div>
            <div class="row padding-5">
                <select class="dropdown padding-5" id="ViewBrandDetails">
                    <option value="">--- choose a brand ---</option>
                    <?php
                        if ( isset( $BrandList ) && !empty( $BrandList ) ) {
                            foreach ($BrandList as $Brandk => $Brandv) {
                                foreach ($Brandv["BrandCode"] as $CodeKey => $CodeValue) {?>
                                    <option value="<?php echo $CodeValue["value"]; ?>" brand_id="<?php echo $Brandv["BrandName"]["value"]?>"><?php echo  $CodeValue["text"]; ?></option>
                                <?php
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 ">
            <!-- sema data title -->
            <div class="row padding-5">
                <h2>Sema Data Co-Op</h2>
            </div>
            <div class="row padding-5 sub-title-dashboard">
                <h4>Data File Administration</h4>
            </div>
            <div class="row padding-5">
                <button type="button" id="AddNewBrand" class="btn btn-primary btn-block">Add Brand</button>
            </div>
            <div class="row padding-5 dropdown display-list show">
                    <button class="btn btn-info btn-block btn dropdown-toggle" data-toggle="dropdown">Edit Brand <span class = "caret pull-right"></span></button>
                    <ul class="dropdown-menu" style="width:45%" id="EditBrand" aria-labelledby="dropdownMenuButton">
                    <?php if( isset( $BrandList ) && !empty( $BrandList )){
                        foreach ($BrandList as $Brandkey => $Brandvalue) {
                            // print_r($Brandvalue["BrandName"]);
                            ?>
                            <li value="<?php echo $Brandvalue["BrandName"]["value"]; ?>"><?php echo $Brandvalue["BrandName"]["text"];?></li>

                    <?php
                            
                        }
                    }?>
                    </ul>

              <!-- <button type="button" id="EditBrand" class="btn btn-default btn-block"></button>-->
            </div> 
            <div class="row padding-5">
                <button type="button" id="AssociateSeller" class="btn btn-warning btn-block">Associate New Seller</button>
            </div>
            <!-- Reports -->
            <div class="row border-bottom padding-5">
                <h4><strong>Reports</strong></h4>
            </div>
            <div class="row padding-5">
                <a id="ViewAllBrands" > View all brands </a>
            </div>
            <div class="row padding-5">
                <a href="/brands"> Most popular brands </a>
            </div>
            <div class="row padding-5">
                <!-- <a href="/brands"> XXXXX </a> -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery( document ).ready(function( $ ){
        // add new brand pop up
        $( "#AddNewBrand" ).click( function() {                     
            $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'brands/add'; ?>" );
            $( "#append_brand_form" ).modal( "show" );
        });

        $('[data-toggle=dropdown]').dropdown();

        // open the asscoiate seller pop up
          $( "#AssociateSeller" ).click( function() {                     
            $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'sellers/AssociateSellerDashboard'; ?>" );
            $( "#append_brand_form" ).modal( "show" );
        });


        // edit button list click to display pop up form
        $("ul#EditBrand li").click( function() {
                var ID = $(this).attr("value");
                var data = {   ID: ID  };
             $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'brands/editPost'; ?> ", data );
            $( "#append_brand_form" ).modal( "show" );
        });

        $("#ViewAllBrands").click( function() {
            $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'brands/View'; ?> " );
            $( "#append_brand_form" ).modal( "show" );
        });
        // on click if recent brand 
        $("a.BrandName").dblclick(function() {
        //   var CodeID = $(this).children("ul").children("li").eq(0).attr("value");
         var CodeID = $(this).next("ul").children("li").eq(0).attr("value");
        
            var data = {'id': $(this).attr('value'),"CodeID": CodeID};
            var url = "<?php base_url()?>summary";
             url_redirect({url:url,  method: "post",data: data});
        });

        $("ul.BrandCode li").click(function(){
            var CodeID = $(this).attr("value");
            var id = $(this).parent("ul").prev("a.BrandName").attr("value");
            var dataS = {'id':id,"CodeID": CodeID};
            // console.log($(this).parent("ul").prev("a.BrandName"));return false;
            var url = "<?php base_url()?>summary";
             url_redirect({url:url,  method: "post",data: dataS});
        });
        // on click of view brand deatils drop down
        $("Select#ViewBrandDetails").change(function(){
            var CodeID = $(this).val();            
            var id = $(this).find('option:selected').attr("brand_id");
            var data = {"id":id, "CodeID" : CodeID};
                var url = "<?php base_url()?>summary";
                 url_redirect({url:url,  method: "post",data: data});
        });

        // create a input element to post the hidden id on summary page
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