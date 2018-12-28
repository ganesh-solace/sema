
<script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
<script src="<?php echo base_url(); ?>assests/js/jquery.multi-select.js" rel="stylesheet"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<?php
    $TitleDisplaylabel = "";
    if(isset($TitleDisplayData) && !empty($TitleDisplayData)){
        if(isset($TitleDisplayData[0]->BrandTitle)){
            $TitleDisplaylabel = $TitleDisplayData[0]->BrandTitle;
        }
    }
    // $TitleJSONData = json_encode($TitleData);
?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row text-center ">
                    <h3> Title Configuration </h3>
                </div>
            </div>
            <div class="modal-body">
            <div class="row padding-5 switch">
            <select id='callbacks' multiple='multiple'>
                <?php
                    foreach ($TitleData as $key => $value) { ?>
                            <option value='<?php echo $value->value; ?>'><?php echo $value->text;?></option>
               <?php     }
                ?>
            </select>
            </div>
            <div class="row padding-20">
            <?php
                  $attributes = array( 'id' => 'SetTitle');
                    echo form_open('summary/PostDisplayTitle', $attributes);

            ?>
            <div class="form-group">
                <div class="row">
                        <div class="col-md-4"><strong>Title :</strong></div>
                        <div  id="InputElement" class="col-md-8"></div>
                </div>
            </div>
            <div class="form-group">
            <input type="hidden" name="Title" class="set-input" value="" />
            <input type="hidden" name="BrandID"  value="<?php echo $BrandID; ?>" />
            <input type="hidden" name="ID"  value="<?php echo $CodeID; ?>" />
            </div>

            <div class="form-group">
                    <div class="row text-right margin-right-0">
                        <?php $SubmitExtra = array( 'class' => 'btn btn-default',"id" => 'FormSubmit');
                        echo form_submit('Submit','Submit', $SubmitExtra);
                        
                        $ButtonExtra = array( 'class' => 'btn btn-default',"data-dismiss"=> "modal","id" => 'ModalClose');
                        echo form_button('Close','Close', $ButtonExtra);
                        ?>
                    </div>
                </div>
            <?php
                echo form_close();
            ?>
            </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">

	jQuery(document).ready(function( $ ){
	// run callbacks
        var TitleDisplaylabel =  "<?php echo $TitleDisplaylabel ?>";   
        var StringVal = "";
        
		$('#callbacks').multiSelect({
             selectableOptgroup: true,
			afterSelect: function(values) {
                var selectedText =  $("#callbacks option[value='"+values+"']").text();

                var concat = concatStr = "";
                if($(".count-class").length > 0 ){
                    concat = "-";
                    concatStr = ",";
                } 
				$("#InputElement").append('<span class="count-class"><span class="space">'+concat+'</span><label class="input-configuration" id="'+values+'">'+selectedText+'</label></span>');
                StringVal = StringVal+concatStr+selectedText;
                $(".set-input").val(StringVal);
			},
			afterDeselect: function(values){
                concatStr = ",";
                var selectedText =  $("#callbacks option[value='"+values+"']").text();
                selectedText = selectedText+ concatStr;
                $("#"+values).parent("span.count-class").remove();
                StringVal = StringVal.replace(selectedText,'');
                $(".set-input").val(StringVal);
			}
		});

        AddandAppendElementClass();
		


        $( "#ModalClose" ).click( function() {
            $( "#append_brand_form" ).modal( 'hide' );
            $( "div.modal-backdrop" ).removeClass( "show" );            
            $( "div.modal-backdrop" ).addClass( "hide" );            
            $( "#append_brand_form" ).html("");
        });


        $("#FormSubmit").click(function(){
            var StringVal = $(".set-input").val();
                StringVal = StringVal.replace(",", " - ");
            $.confirm({
                title: 'Title Configuration !',                
                content: 'Title sequence : '+StringVal,
                draggable: true,
                buttons: {
                    Yes: function () {
                        $("form#SetTitle").submit();   
                    },
                    No: function () {
                        $.alert('Canceled!');
                    }
                }
            });
            return false;
        });

            DisplaySelectedFields(TitleDisplaylabel);
        });

    function AddandAppendElementClass() {
        $(".ms-selectable").addClass("col-md-5");
        $(".ms-selectable").addClass("border");
		$(".ms-selectable").after('<div class="col-md-2 text-center"><div class="row"></div></div>');
		$(".ms-selection").addClass("col-md-5");
		$(".ms-selection").addClass("border");
    }

     function DisplaySelectedFields(TitleDisplaylabel) {
        TitleDisplaylabel = TitleDisplaylabel.split(',');
        var concat =concatStr=StringVal= "";
           
        $.each($(".ms-selectable ul li.ms-elem-selectable"),function(Titleindex, Titlevalues) {
                var CheckValTitle = $(this).children("span").html();
                var Element = $(this);

            $.each(TitleDisplaylabel,function(index, values) {
                if(CheckValTitle == values){
                     Element.trigger("click");
                }
            });
        });
    }


  </script>