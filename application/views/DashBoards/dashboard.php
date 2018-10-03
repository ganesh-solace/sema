<div class="container panel panel-body">
    <div id="append_brand_form" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" data-target="#myModal"></div>
    <div class="row">
        <div class="col-md-6">
            <!-- just part logo  -->
            <div class="row margin-bottom padding-5">
                <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.png" />
            </div>
            <!--  dashboard group -->
            <div class="row  border-bottom padding-5">
                <h4><strong>Dashboard</strong></h4>
            </div>
            <div class="row padding-5"><span>134</span><span>Data files</span></div>
            <div class="row padding-5"><span>3</span><span>sellers link to data feeds</span></div>
            <div class="row padding-5"><span>XXXXXXX</span></div>
            
            <!-- Recdent group -->
            <div class="row border-bottom padding-5">
                <h4><strong>Recent</strong></h4>
            </div>
            <div class="row">
                <?php
                  $BrandArr = array( "BDS Suspension","Air Lift", "Fuel Offroad", "Backrack","Husky Liners", "Wheathertech", "Pro comp Tires", "Mishimoto", "Yulon Gear");
            
                     if( isset( $BrandList ) && !empty( $BrandList ) ) {
                        foreach ($BrandList as $Brandkey => $Brandvalue) { ?>
                              <div class="col-md-4 padding-5">
                                  <a href="<?php echo $Brandvalue; ?>"><?php echo $Brandvalue; ?></a> 
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
                <select class="dropdown padding-5">
                    <option value="">--- choose a brand ---</option>
                    <?php
                        if ( isset( $BrandList ) && !empty( $BrandList ) ) {
                            foreach ($BrandList as $Brandk => $Brandv) { ?>
                                <option value="<?php echo $Brandk; ?>"><?php echo $Brandv; ?></option>
                    <?php
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
            <div class="row padding-5">
                    <button class="btn btn-default btn-block btn dropdown-toggle" data-toggle="dropdown">Edit Brand <span class = "caret pull-right"></span></button>
                    <ul class="dropdown-menu" style="width:40%" id="EditBrand">
                    <?php if( isset( $BrandList ) && !empty( $BrandList )){
                        foreach ($BrandList as $Brandkey => $Brandvalue) { ?>
                            <li value="<?php echo $Brandkey; ?>"><?php echo $Brandvalue;?></li>

                    <?php }
                    }?>
                    </ul>

              <!-- <button type="button" id="EditBrand" class="btn btn-default btn-block"></button>-->
            </div> 
            <div class="row padding-5">
                <button type="button" class="btn btn-default btn-block">Associate New Seller</button>
            </div>
            <!-- Reports -->
            <div class="row border-bottom padding-5">
                <h4><strong>Reports</strong></h4>
            </div>
            <div class="row padding-5">
                <a href="/brands"> View all brands </a>
            </div>
            <div class="row padding-5">
                <a href="/brands"> Most popular brands </a>
            </div>
            <div class="row padding-5">
                <a href="/brands"> XXXXX </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery( document ).ready(function( $ ){
        $( "#AddNewBrand" ).click( function() {                     
            $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'brands/add'; ?>" );
            $( "#append_brand_form" ).modal( "show" );
        });

        $("ul#EditBrand li").click( function() {
                var ID = $(this).attr("value");
                var data = {   ID: ID  };
             $( "div.modal-backdrop" ).removeClass( "hide" );            
            $( "div.modal-backdrop" ).addClass( "show" );    
            $( "#append_brand_form" ).load( "<?php echo base_url().'brands/editPost'; ?> ", data );
            $( "#append_brand_form" ).modal( "show" );
        });
    });

</script>