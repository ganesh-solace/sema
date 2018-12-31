<footer>
    <!-- <script src="<?php //echo base_url(); ?>assests/js/jquery.min.js" rel="stylesheet"></script> -->
    <script src="<?php echo base_url(); ?>assests/js/jquery.multiselect.js" rel="stylesheet"></script>
    <link href="<?php echo base_url(); ?>assests/css/jquery.multiselect.css" rel="stylesheet">

    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
                    url: "submitForm",
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
                    url: "delete",
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
                    url: "edit",
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
                    url: "updateform",
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
</footer>