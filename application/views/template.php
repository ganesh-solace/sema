<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
        <meta name="author" content="Łukasz Holeczek">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
        <title>Sema Data</title> 
         <script src="<?php echo base_url(); ?>assests/js/jquery.min.js" rel="stylesheet"></script>
         <script src="<?php echo base_url(); ?>assests/js/common.js" rel="stylesheet"></script>
         <script src="<?php echo base_url(); ?>assests/js/jquery.multiselect.js" rel="stylesheet"></script>
        <link href="<?php echo base_url(); ?>assests/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assests/css/common.css?se" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assests/js/popper.min.js" rel="stylesheet"></script>
        <script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
 

    
    </head>
    <body>
         <?php $this->load->view('templates/header'); ?>

        <div id='whateverworks'>
             <?= $contents ?>
        </div>

         <?php $this->load->view('templates/footer'); ?>

    </body>
</html>