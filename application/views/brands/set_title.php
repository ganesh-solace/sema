
<script src="<?php echo base_url(); ?>assests/js/bootstrap.min.js" rel="stylesheet"></script>
<script src="<?php echo base_url(); ?>assests/js/jquery.multi-select.js" rel="stylesheet"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<?php
    $TitleDisplaylabel = "";
    if(isset($TitleDisplayData) && !empty($TitleDisplayData)){
        
        $TitleSeprator = (isset($TitleDisplayData[0]->TitleSeprator) && !empty($TitleDisplayData[0]->TitleSeprator)) ? $TitleDisplayData[0]->TitleSeprator : "-";
        if(isset($TitleDisplayData[0]->BrandTitle)){
            $TitleDisplaylabel = $TitleDisplayData[0]->BrandTitle;
            $TitleDisplaylabel = explode($TitleSeprator, $TitleDisplaylabel);

            $TitleDisplaylabel = array_map('trim', $TitleDisplaylabel);

            $TitleDisplaylabel = implode($TitleSeprator, $TitleDisplaylabel);
        }
    }

    // print_r($TitleDisplaylabel);exit;
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
                        <div class="col-md-5"><strong>Title Seperator Configuration :</strong></div>
                       <div class="col-md-2"> <input type="text" class=" form-control text-center" name="Sperator" id="Sperator" class="set-seperator" value="<?php echo $TitleSeprator; ?>" /></div>
             </div>
                <div class="row">
                        <div class="col-md-2"><strong>Title :</strong></div>
                        <div  id="InputElement" class="col-md-10"></div>
                </div>
                
            </div>
            <div class="form-group">
            <input type="hidden" name="Title" class="set-input" value="" />
            <input type="hidden" name="TitleSeprator" class="set-seperator" value="<?php echo $TitleSeprator; ?>" />
            <input type="hidden" name="BrandID"  value="<?php echo $BrandID; ?>" />
            <input type="hidden" name="ID"  value="<?php echo $CodeID; ?>" />
             
            </div>

            <div class="form-group">
                    <div class="row text-right margin-right-0">
                        <?php $SubmitExtra = array( 'class' => 'btn btn-primary',"id" => 'FormSubmit');
                        echo form_submit('Submit','Submit', $SubmitExtra);
                        
                        $ButtonExtra = array( 'class' => 'btn btn-danger',"data-dismiss"=> "modal","id" => 'ModalClose');
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
        var TitleDisplaylabel =  "<?php echo trim($TitleDisplaylabel); ?>"; 
        var TitleSeprator =  "<?php echo trim($TitleSeprator); ?>"; 
        // console.log(TitleDisplaylabel);  
       
        var concat = concatStr = "";
		$('#callbacks').multiSelect({
             selectableOptgroup: true,
			afterSelect: function(values) {               
                var selectedText =  $("#callbacks option[value='"+values+"']").text();
                 var StringVal = "";
                 
                if($(".space").length > 0 ) {
                    concat = concatStr = $("input[name='TitleSeprator']").val();
                } 
                StringVal =  $(".set-input").val();
                
                $(".append_ul").append('<li id="'+values+'">'+selectedText+'</li>');
				$("#InputElement").append('<span class="count-class"><span class="space">'+concat+'</span><label class="input-configuration" id="values'+values+'">'+selectedText+'</label></span>');
                StringVal = StringVal+concatStr+selectedText;
                $(".set-input").val(StringVal);
            }
		});

        AddandAppendElementClass();
		
          $(document).on('click','.append_ul li',function() {
            var ElemntLi = $(this).html();
            AfterDelectOnUI( ElemntLi );   
            SetThePostInputValue(ElemntLi);            
            var id = $(this).attr("id");
            RemoveTitleConfiguration( id );
            $(this).remove();
        });

        $( "#ModalClose" ).click( function() {
            $( "#append_brand_form" ).modal( 'hide' );
            $( "div.modal-backdrop" ).removeClass( "show" );            
            $( "div.modal-backdrop" ).addClass( "hide" );            
            $( "#append_brand_form" ).html("");
        });


        $("#FormSubmit").click(function(){
                var ReplaceString = $(".set-input").val();
                // ReplaceString = ReplaceString.replace(/\,/g, ' - ');

                confirmDialog(ReplaceString);
           
            return false;
        });

            DisplaySelectedFields(TitleDisplaylabel, TitleSeprator);

            $("#Sperator").change(function() {
                var OldSeperator =  $("input[name='TitleSeprator']").val();
                $("input[name='TitleSeprator']").val($(this).val());
                ConfigureSeprator( OldSeperator );
            });
        });

    function AddandAppendElementClass() {
        $(".ms-selectable").addClass("col-md-5");
        $(".ms-selectable").addClass("border");
        $(".ms-selectable").after('<div class="col-md-2 text-center"><div class="row"></div></div>');
        $(".ms-selection").css("display","none");
        $(".ms-selection").after('<div class="col-md-5 border append-container"><ul class="append_ul"></ul></div>');
		// $(".ms-selection").addClass("col-md-5");
		$(".ms-selection").addClass("border");
    }

     function DisplaySelectedFields(TitleDisplaylabel, TitleSeprator) {
        TitleDisplaylabel = TitleDisplaylabel.split( TitleSeprator );
        var concat =concatStr= "";
    console.log(TitleSeprator);
        $.each(TitleDisplaylabel,function(index, values) {
            $.each($(".ms-selectable ul li.ms-elem-selectable"),function(Titleindex, Titlevalues) {
                 var CheckValTitle = $(this).children("span").html();
                 var Element = $(this);
                //  console.log(values.trim()+" == "+CheckValTitle.trim());
                 if(values.trim() == CheckValTitle.trim()){
                     Element.trigger("click");
                }
            });            
        });        
    }

    // on click of selected element function called to remove values from hidden ul structure
    function  AfterDelectOnUI(ElemntLi) {
        $.each($(".ms-selection ul li.ms-elem-selection"),function(Titleindex, Titlevalues) {
            if(ElemntLi.trim() == $(this).find("span").html().trim()){
                console.log(ElemntLi.trim()+" == "+$(this).find("span").html().trim());
                $(this).trigger("click");
            }
        });
    }

    // remove the title display after selecting and delecting the elements
    function  RemoveTitleConfiguration(id) {
        $.each($("#InputElement").find(".input-configuration"), function(index) {
            if($(this).attr("id") == "values"+id) {
                if(index == 0 ) {
                    $(this).parent("span").next("span").children("span.space").remove();
                    $("#values"+id).prev("span").remove();
                } else {
                    $("#values"+id).prev("span").remove();
                }
                $("#values"+id).remove();
            }                    
        });
    }

    // input hidden field value, set value to post in database
    function SetThePostInputValue(ElemntLi) {
        var ChangeString = $(".set-input").val();
        var SeperatorStr = $("input[name='TitleSeprator']").val();
        var result = ChangeString.split(SeperatorStr);

        for (var key in result) {
            if (result[key].trim() == ElemntLi.trim()) {
                 result.splice(key, 1);
            }
        }

        ChangeString = result.join(SeperatorStr);
        $(".set-input").val(ChangeString); 
    }

    function confirmDialog(StringVals) {
        $.confirm({
            title: 'Title Configuration !',                
            content: 'Title sequence : '+StringVals,
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
    }

    function ConfigureSeprator( OldSeperator ) {
        var SepratorStr = $("input[name='TitleSeprator']").val();
            SepratorStr = SepratorStr;
        var TitleStr = $(".set-input").val();
            TitleStr = TitleStr.replace(new RegExp(OldSeperator, 'g'), SepratorStr);
            $(".set-input").val( TitleStr );

            $.each($(".space"), function(index,value){
                if(index != 0 ){
                    $(this).html( " "+SepratorStr+" " );
                }
            });
    }

    // function replaceAll(str, term, replacement) {
    //     return str.replace(new RegExp(term, 'g'), replacement);
    // }
    
  </script>