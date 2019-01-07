<script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
<script src="<?php echo base_url(); ?>assests/js/pagination.min.js" rel="stylesheet"></script>
<?php $datasource = json_encode($BrandData);
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
            <div class="row">
            <div class='col-md-8'>
            <nav aria-label="Page navigation example" class="example">
            </nav>
            </div>
            <div class="col-md-4 text-right padding-20">
                <?php  $ButtonExtra = array( 'class' => 'btn btn-danger',"data-dismiss"=> "modal","id" => 'ModalClose');
                        echo form_button('Close','Close', $ButtonExtra);?>   
            </div>
            </div>            
              </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
   jQuery( document ).ready(function( $ ) {
        var datasource = <?php echo $datasource;?>;
        $('.example').pagination({
            dataSource: datasource,
            pageSize: 3,
            showPrevious: true,
            ulClassName : "pagination",
            showNext: true,
            callback: function(data, pagination) {
                // template method of yourself
                var html = template( data );
                $(".body-row").html(html);
            }
        });

function template( data ){
    var html ="";
    $.each( data, function( key, value ) {
        html += '<div class="row row-border">';
        html += '<div class="col-md-3 cell-border"><a value="'+value["CodeID"]+'" class="BrandCode">'+value["BrandCode"]+'</a></div>';
         html += '<div class="col-md-4 cell-border"><a value="'+value["ID"]+'" class="BrandName">'+value["BrandName"]+'</a></div>';
        html += '<div class="col-md-4">'+value["Description"]+'</div>';
        html += '</div>';
    });
    return html;
}


        // on click of close button exit the modal popup
        $( "#ModalClose" ).click( function() {
            $( "#append_brand_form" ).modal( 'hide' );
            $( "div.modal-backdrop" ).removeClass( "show" );            
            $( "div.modal-backdrop" ).addClass( "hide" );            
            $( "#append_brand_form" ).html("");
        });
        
    //click on brand code redirect to brand summary 
    $(document).on("click","a.BrandCode",function() {
            var CodeID = $(this).attr('value');
            var id = $(this).parent("div").next("div").children("a").attr("value");
            RedirectOnclick(id, CodeID);
        });

        //click on brand Name redirect to brand summary 
        $(document).on("click","a.BrandName",function() {
            var CodeID =  $(this).parent("div").prev("div").children("a").attr("value");
            var id = $(this).attr('value');
            RedirectOnclick(id, CodeID);
            
        });
        
        // common redirect function from code and name 
        function RedirectOnclick(id, CodeID) {
            var data = {'id': id, "CodeID":CodeID};
            var url = "<?php base_url()?>summary";
            url_redirect({url:url,  method: "post",data: data});
        }

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