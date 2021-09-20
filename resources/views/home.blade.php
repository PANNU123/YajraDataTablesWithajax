{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!DOCTYPE html>

<html>

<head>

    <title>Yajra Datatable Using Ajax</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    


</head>
<body>
<div class="container">

    <h1>Yajra Datatable Using Ajax</h1>
    <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewEmploy"> Create New Employ</a>
    <br><br>
    <table class="table table-bordered datatable" id="user_table">
        <thead>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Title</th>
                <th>Salary</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

   

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="employForm" name="employForm" class="form-horizontal">
                   <input type="hidden" name="employ_id" id="employ_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Frist Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Salary</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Salary" value="" maxlength="50" required="">
                        </div>
                    </div>
                    
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>

    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            var table = $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            search:true,
            ajax:{url: "{{ route('home') }}"},
            columns:[
                {data: 'DT_RowIndex',   name: 'DT_RowIndex' },
                { data:'first_name',    name:  'first_name' },
                { data:'last_name',     name:  'last_name'  },
                { data:'title',         name:  'title'      },
                { data:'salary',        name:  'salary'     },
                { data: 'action',       name: 'action'      },
            ]
        });
        $('#createNewEmploy').click(function(){
            $('#saveBtn').html('Create-Employ');
            $('#employ_id').val('');
            $('#employForm').trigger("reset");
            $('#modelHeading').html("Create New Employ");
            $('#ajaxModel').modal('show');
        });


        $('body').on('click', '.editProduct', function () {
        var id = $(this).data('id');
        $.ajax({
            method:"GET",
            dataType:"json",
            url:'/employ/'+id,
            success:function(data){
                $('#employ_id').val(id);
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#title').val(data.title);
                $('#salary').val(data.salary);
                $('#modelHeading').html("Edit Product");
                $('#saveBtn').html("Update");
                $('#ajaxModel').modal('show');
            }
        })

});
        /*Adding part*/
        $('#saveBtn').click(function(e){
            e.preventDefault();
            $(this).html('Sending...');

            $.ajax({
                data:$('#employForm').serialize(),
                url:"{{route('employ-store')}}",
                type:"post",
                dataType:'json',
                success:function(data){
                    $('#employForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error:function(data){
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });
/*close Add part*/

//Delete Part
$('body').on('click', '.deleteProduct', function () {
    var id = $(this).data("id");
    confirm("Are You sure want to delete !");      
    $.ajax({
        url:'/employ/delete/'+id,
         type: "GET",
         dataType:"JSON",
        success: function (data) {
            table.draw();
        },
        error: function (data) {
            console.log('Error:', data);
             }
        });
     });
});
    </script>
</html>
