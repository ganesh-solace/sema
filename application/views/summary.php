<div class="container panel panel-body">
    <div class="row">
        <div class="col-md-6">
            <!-- just part logo  -->
            <div class="row margin-bottom padding-5">
                <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.png">
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
                <h4><strong>Brand Summary</strong></h4>
            </div>
            <div class="row padding-5">
            
            <?php
                // echo "<pre>";
                // print_r($brand_data);
                // exit;
                foreach($brand_data as $brand):
            ?>
                <div class="col-md-5 padding-5"><span>Associated Date: </span></div><div class="col-md-7 padding-5"><span><?=$brand['CreatedDate'];?></span></div>
                <div class="col-md-5 padding-5"><span>Last Data Refresh: </span></div><div class="col-md-7 padding-5"><span><b>August 31, 2018 at 2:10:52 PM</b></span></div>
                <div class="col-md-5 padding-5"><span>Number of Items: </span></div><div class="col-md-7 padding-5"><span><?=$brand['NumberOfItem'];?></span></div>
                <div class="col-md-5 padding-5"><span>SEMA Brand Class: </span></div><div class="col-md-7 padding-5"><span><?=$brand['sema_class'];?></span></div>
                <div class="col-md-5 padding-5"><span>Associate Sellers: </span></div><div class="col-md-7 padding-5"><span><?=$brand['associate_seller_count'];?></span></div>
                <div class="col-md-5 padding-5"><span>Associate Webstores: </span></div><div class="col-md-7 padding-5"><span><b>15</b></span></div>
            <?php
                endforeach;
            ?>
            </div>
            
        </div>
        
        <div class="col-md-6 ">

            <div class="row border-bottom padding-5">
                <h4><strong>Associated Seller</strong></h4>
            </div>

            <div class="row padding-5">
                <?php
                    
                    // $BrandArr = array( "BDS Suspension","Air Lift", "Fuel Offroad", "Backrack","Husky Liners", "Wheathertech", "Pro comp Tires", "Mishimoto", "Yulon Gear");

                    if( isset( $seller_list ) && !empty( $seller_list ) ) {
                        foreach ($seller_list as $seller) { ?>
                            <div class="col-md-4 padding-5"><a href="<?php echo $seller["ID"]; ?>"><?php echo $seller["Name"]; ?></a> </div>
                            <?php
                        }
                    }
                ?>
            </div>

            <div class="row padding-5">
                <button>Associate New Seller</button>
            </div>

        </div>
    </div>
</div>


</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>