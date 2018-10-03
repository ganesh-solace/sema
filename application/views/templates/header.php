
<header>
    <?php
      if( isset( $this->session->userdata ) ) {
        if( isset( $this->session->userdata['logged_in'] ) && !empty( $this->session->userdata['logged_in'] ) ) {
          ?>
            <div class="row">
              <div class="col-md-2 pull-right"> 
                <div class="col-md-6 text-right">
                    <img src="<?php echo base_url()?>assests/images/favicon.ico" title="" alt="sema user"> 
                </div>      
                <div class="col-md-6 text-right"> 
                   <a><?php echo $this->session->userdata['logged_in']['UserName']; ?> </a> 
                </div>
              </div>
            </div>
          <?php
        }         
      }    
    ?>
  </header>