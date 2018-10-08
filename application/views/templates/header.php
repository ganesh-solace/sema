
<header>
    <?php

      if( isset( $this->session->userdata ) ) {
        if( isset( $this->session->userdata['logged_in'] ) && !empty( $this->session->userdata['logged_in'] ) ) {
          ?>
          <div class="row login-nav-bar">
              <!-- <div class="row"> -->
                <div class="col-md-10  text-right"> <img src="<?php echo base_url()?>assests/images/favicon.ico" title="" alt="sema user"> <a><?php echo $this->session->userdata['logged_in']['UserName']; ?></a></div>
                <div class="col-md-2"><a href="<?php base_url()?>users/logout"> Logout</a> </div>
              </div>
          <!-- </div> -->
          <?php
        }         
      }    
    ?>
  </header>

  