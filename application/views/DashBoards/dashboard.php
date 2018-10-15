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
                        foreach ($RecentBrandList as $Brandkey => $Brandvalue) {
                            if($Brandkey != 0 ) { ?>
                              <div class="col-md-4 padding-5 cursor">
                                  <a value="<?php echo $Brandkey; ?>" class="BrandName"><?php echo $Brandvalue; ?></a> 

                              </div>

                <?php
                            }
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
                                if( $Brandk != 0 ){
                                ?>
                                <option value="<?php echo $Brandk; ?>"><?php echo $Brandv; ?></option>
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
                <button type="button" id="AddNewBrand" class="btn btn-default btn-block">Add Brand</button>
            </div>
            <div class="row padding-5 dropdown display-list show">
                    <button class="btn btn-default btn-block btn dropdown-toggle" data-toggle="dropdown">Edit Brand <span class = "caret pull-right"></span></button>
                    <ul class="dropdown-menu" style="width:45%" id="EditBrand" aria-labelledby="dropdownMenuButton">
                    <?php if( isset( $BrandList ) && !empty( $BrandList )){
                        foreach ($BrandList as $Brandkey => $Brandvalue) {
                            if($Brandkey != 0) { ?>
                            <li value="<?php echo $Brandkey; ?>"><?php echo $Brandvalue;?></li>

                    <?php
                            }
                        }
                    }?>
                    </ul>

              <!-- <button type="button" id="EditBrand" class="btn btn-default btn-block"></button>-->
            </div> 
            <div class="row padding-5">
                <button type="button" id="AssociateSeller" class="btn btn-default btn-block">Associate New Seller</button>
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
        $("a.BrandName").click(function() {
            var data = {'id': $(this).attr('value')};
            var url = "<?php base_url()?>summary";
             url_redirect({url:url,  method: "post",data: data});
        });

        // von click of view brand deatils drop down
        $("Select#ViewBrandDetails").change(function(){
                var data = {'id': $(this).val()};
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