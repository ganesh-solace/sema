<div class="container panel panel-body">
    <div class="row">
        <div class="col-md-6">
            <!-- just part logo  -->
            <div class="row margin-bottom padding-5">
                <img src="<?php echo base_url(); ?>assests/images/JustParts-Logo.jpg" />
            </div>
        </div>
    </div>
    <div class="row">
        <h2> Tag Management </h2>

        <form id="tagManagementForm" action="#" >
            <div class="form-group col-md-7">
                <label>Short Code Name :</label>
                <input type="text" class="form-control" id="short_name" name="short_name">
            </div>
            <div class="form-group col-md-7">
                <label>Description :</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>
            <div class="form-group col-md-7">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </form>
    </div>
    <div class="row">
        <table id="tagManagementTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Short Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($data as $value) {
                ?>
                    <tr>
                        <td><?php echo $value->short_name?></td>
                        <td><?php echo $value->description?></td>
                        <td>
                            <a class="btn btn-primary edit-tag" data-id="<?php echo $value->id?>">Edit</a>
                            <a class="btn btn-danger delete-tag" data-id="<?php echo $value->id?>">Delete</button>
                        </td>
                    </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>

    </div>
</div>

<div class="modal fade" id="editTag" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Tag</h4>
        </div>
        <div class="modal-body">
            <div class='clearfix'>
                <form id="updateTagManagementForm" action="#" >
                    <div class="form-group col-md-7">
                        <label>Short Code Name :</label>
                        <input type="text" class="form-control" id="short_name" name="short_name">
                    </div>
                    <div class="form-group col-md-7">
                        <label>Description :</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="form-group col-md-7">
                        <button type="submit" id="update-tag" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
      
    </div>
  </div>
<script>
        $(document).ready( function () {
            myTable = $('#tagManagementTable').DataTable();
        } );
    </script>

    <script>
        $(document).ready( function(){
            $("#tagManagementForm").submit(function(e) {
                var form = $(this);
                var data = form.serialize();
                $.ajax({
                    type: "POST",
                    url: "TagManagements/submitForm",
                    data: data, // serializes the form's elements.
                    success: function(insertId)
                    {   
                        var short_name = $("#short_name").val();
                        var description = $("#description").val();
                        var row = "<tr> <td>"+short_name+"</td> <td>"+description+"</td> <td><a class='btn btn-primary edit-tag' data-toggle='modal' data-target='#editTag' data-id='"+insertId+"'>Edit</a> <a class='btn btn-danger delete-tag' data-id='"+insertId+"'>Delete</button></td></tr>";
                        $('#tagManagementTable tbody').prepend(row);
                    }
                    });

                return false;
            });

            $('#tagManagementTable tbody').on('click', '.delete-tag', function() {
                var row = $(this);
                var id = $(this).data('id');
                data = "id="+id;
                $.ajax({
                    type: "POST",
                    url: "TagManagements/delete",
                    data: data, // serializes the form's elements.
                    success: function(data)
                    {
                        if( data ){
                           row.closest("tr").remove();
                        }
                    }
                });

                return false;
            });

            $('#tagManagementTable tbody').on('click', '.edit-tag', function() {
                var row = $(this);
                var id = $(this).data('id');
                data = "id="+id;
                $.ajax({
                    type: "POST",
                    url: "TagManagements/edit",
                    data: data, // serializes the form's elements.
                    success: function(data)
                    {
                        $('#editTag').modal('show');
                        var obj = JSON.parse(data);
                        $('#editTag').find("#short_name").val( obj[0].short_name );
                        $('#editTag').find("#description").val( obj[0].description );
                        $("#updateTagManagementForm").append("<input type='hidden' name='id' value='"+obj[0].id+"'>");
                        $('#editTag').find("button").attr('data-id', obj[0].id );
                    }
                });

                return false;
            });

            $("#updateTagManagementForm").submit(function(e) {
                var form = $(this);
                var data = form.serialize();
                $.ajax({
                    type: "POST",
                    url: "TagManagements/updateform",
                    data: data, // serializes the form's elements.
                    success: function(id)
                    {   
                        $('#editTag').modal('hide');
                        location.reload();
                    }
                    });

                return false;
            });

            
        });
    </script>