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
                <h4><strong>Seller Summary</strong></h4>
            </div>
            <div class="row padding-5">
                <div class="col-md-5 padding-5"><span>Seller Name: </span></div><div class="col-md-3 padding-5"><span>Michael Racco</span></div><div class="col-md-4 padding-5"><span><a href="#">View Contact Details</a></span></div>
                <div class="col-md-5 padding-5"><span>Business Name: </span></div><div class="col-md-7 padding-5"><span>Thunder Bay Auto Parts</span></div>
                <div class="col-md-5 padding-5"><span>Online Since: </span></div><div class="col-md-7 padding-5"><span>August 25, 2018</span></div>
                <div class="col-md-5 padding-5"><span>JustParts Seller ID: </span></div><div class="col-md-7 padding-5"><span>tbauto</span></div>
                <div class="col-md-5 padding-5"><span>Webstore URL: </span></div><div class="col-md-7 padding-5"><span>tbautoparts.com</span></div>
                <div class="col-md-5 padding-5"><span>JustParts FTP Name: </span></div><div class="col-md-7 padding-5"><span>tbauto</span></div>
            </div>
            
            <div class="row border-bottom padding-5">
                <h4><strong>Brand Summary</strong></h4>
            </div>
            <div class="row padding-5">
                <div class="col-md-5 padding-5"><span>Associated Date: </span></div><div class="col-md-7 padding-5"><span>August 28, 2018</span></div>
                <div class="col-md-5 padding-5"><span>Last Data Refresh: </span></div><div class="col-md-7 padding-5"><span>August 31, 2018 at 2:10:52 PM</span></div>
                <div class="col-md-5 padding-5"><span>Number of Items: </span></div><div class="col-md-7 padding-5"><span>4,125</span></div>
                <div class="col-md-5 padding-5"><span>SEMA Brand Class: </span></div><div class="col-md-7 padding-5"><span>Platinum</span></div>
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
            <div class="row padding-5">
                <div class="col-md-3"><label>Type: </label></div>
                <div class="col-md-9">
                    <select style="width: 100%;height: 24px;">
                        <?php
                            foreach( $type as $option){
                                echo "<option>$option</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row padding-5">
                <div class="col-md-3"><label>Amount: </label></div>
                <div class="col-md-2"><input type="text" value="30"  style="width: 40px;padding: 0 5px;"></div>
                <div class="col-md-7">
                    <select style="width: 100%;height: 24px;">
                        <?php
                            foreach( $amount as $option){
                                echo "<option>$option</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row padding-5">
                <div class="col-md-3"><label>Base</label></div>
                <div class="col-md-9">
                    <select style="width: 100%;height: 24px;">
                        <?php
                            foreach( $base as $option){
                                echo "<option>$option</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>