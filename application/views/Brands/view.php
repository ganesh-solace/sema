  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
<script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
<script src="<?php echo base_url(); ?>assests/js/pagination.min.js" rel="stylesheet"></script>
<?php $datasource = json_encode($BrandData);
print_r($datasource);
?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row text-center ">
                    <h3> <?php echo $PageTitle; ?> </h3>
                </div>
            </div>
            <div class="modal-body">     
            
                <!-- <input class="form-control" type="text" placeholder="Search" aria-label="Search"> -->
            <div class="table-container data-container">
                <div class="row head-row ">
                    <div class="col-md-3 col-sm-3"><b>Code</b></div>
                    <div class="col-md-4 col-sm-4 "><b>Name</b></div>
                    <div class="col-md-4 col-sm-4 "><b>Description</b></div>
                </div>
                <div class="body-row"></div>

            </div> 
            <div class="row text-right margin-right-0"><a>Total records <?php echo $TotalRecords; ?></a></div>
            <nav aria-label="Page navigation example" class="example">
                <!-- <ul class="pagination">
                   <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                </ul> -->
               
            </nav>               
              </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
   jQuery( document ).ready(function( $ ) {
    var datasource = <?php echo $datasource;?>;
    console.log(datasource);
    $('.example').pagination({
    dataSource: datasource,
    pageSize: 2,
    showPrevious: true,
    ulClassName : "pagination",
    showNext: true,
    callback: function(data, pagination) {
        console.log(data);
        // template method of yourself
        var html = template( data );
        $(".body-row").html(html);
    }
});

function template( data ){
    var html ="";
    $.each( data, function( key, value ) {
        html += '<div class="row row-border">';
        html += '<div class="col-md-3 cell-border"><a value="'+value["ID"]+'" class="BrandCode">'+value["Code"]+'</a></div>';
         html += '<div class="col-md-4 cell-border"><a value="'+value["ID"]+'" class="BrandName">'+value["Name"]+'</a></div>';
        html += '<div class="col-md-4">'+value["Name"]+'</div>';
        html += '</div>';
    });
    return html;
}
    //click on brand code redirect to brand summary 
    $(document).on("click","a.BrandCode",function() {
            var data = {'id': $(this).attr('value')};
            var url = "<?php base_url()?>summary";
            url_redirect({url:url,  method: "post",data: data});
        });

        $(document).on("click","a.BrandName",function() {
            var data = {'id': $(this).attr('value')};
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