<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Datatables Tutorial - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('customer/customer.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="{{asset('customer/customer.js')}}"></script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <style type="text/css">

    </style>
</head>
<body>
    <div class="container">
        <br>
        <h1> Customer All Data </h1>
        <br>
        <div id="slide-table">

        <button type="submit" class="addCustomer btn-primary"> Add Customer </button>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>shop_id</th>
                    <th>first_name</th>
                    <th>last_name</th>
                    <th>city</th>
                    <th>birthdate</th>
                    <th>avatar</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    </div>
</body>
    
<div id="formCostomer">
 
    <form id="customer_data" class="form-horizontal" enctype="multipart/form-data">
       {{ csrf_field() }}
       <h2> Customer Form </h2>
       <div class="row">
             <input type="hidden" class="form-control" name="id" id="customerId">
            <div class="col-auto">
                <label class="visually-hidden" for="name">first_name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Fill first_name">
                <span id="first_name_err" class="errors"> </span>
            </div>

            <div class="col-auto">
                <label class="visually-hidden" for="name">last_name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Fill last_name">
                <span id="last_name_err" class="errors"> </span>
            </div>
       
            <div class="col-auto">
                <label class="visually-hidden" for="name">city</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="Fill City">
                <span id="city_err" class="errors"> </span>
            </div><br>
            <div class="col-auto">
                <label class="visually-hidden" for="name">birthdate</label>
                <input type="date" class="form-control" name="bdate" id="bdate" placeholder="Fill Birthdate">
                <span id="bdate_err" class="errors"> </span>
            </div><br>
            <div class="col-auto">
                <label class="visually-hidden" for="name">avatar</label>
                <input type="file" class="form-control" name="image" id="image" >
                <div id="file" style="width: '50px'"> </div>
            </div>
        </div><br>
        <button type="submit" class="btn btn-primary" name="submit">Change Customer</button>
    </form>
</div>

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
        {data: 'id', name: 'id'},
        {data: 'shop_id', name: 'shop_id'},
        {data: 'first_name', name: 'first_name'},
        {data: 'last_name', name: 'last_name'},
        {data: 'city', name: 'city'},
        {data: 'birthdate', name: 'birthdate'},
        {
            "name": "avatar",
            "data": "avatar",
            "render": function (data, type, full, meta) {
                return "<img src=\"upload/" + data + "\" height=\"50\"/>";
            },
            "title": "avatar",
            "orderable": true,
            "searchable": true
        },

           {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
 
    // Add New Customer 
    $(".addCustomer").on("click",function(e) {
         $("#customer_data").show();
    });


    $(".data-table").on("click", ".edit", function () {  
        $("#customer_data").show();
        var id = $(this).closest('tr').find('td:eq(0)').text();  
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: 'editCustomer',
            type: 'post',
            data: {_token: CSRF_TOKEN,id: id},
            success: function(response){ console.log(response);
                var len = response.length;
                for(var i = 0 ; i < len; i++ ){
                    $('#customerId').val(response[i].id);
                    $('#first_name').val(response[i].first_name);
                    $('#last_name').val(response[i].last_name);
                    $('#city').val(response[i].city);
                    $('#bdate').val(response[i].birthdate);
                   // $('#image').text('<img src="http://127.0.0.1:8000/upload/'+response[i].avatar+'"width="50px" height="40px" id="blah">');
                    $('#file').html("<img src='http://127.0.0.1:8000/upload/"+response[i].avatar+"' alt='Not Found' id='filesize' />");
                }
            }
        });
    });


    // update Data 
    $('#customer_data').submit(function(e) {
        e.preventDefault(); 
        var customerId  = $('#customerId').val();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var city = $('#city').val();
        var bdate = $('#bdate').val();
        var image = $('#image').val();
        var formdata = $('#customer_data').serialize()+ "&image="+image;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $('#image').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#preview-image-before-upload').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
        });
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
        // For Update 
        if(customerId != ""){
            if(first_name ==""){
                $('#first_name_err').text('Field Is Required');
            }if(last_name ==""){
                $('#last_name_err').text('Field Is Required');
            }
            if(city ==""){
                $('#city_err').text('Field Is Required');
            }
            if(bdate ==""){
                $('#bdate_err').text('Field Is Required');
            }
            else{
                $.ajax({
                    url: 'updateCustomer',
                    type: 'post',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                     success: function(response){
                        $('.data-table').DataTable().ajax.reload();
                        $('#formCostomer').hide();
                            toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.success("Update Customer Data..!!!!");
                    }
                });
            }
        }else{
             if(first_name ==""){
                $('#first_name_err').text('Field Is Required');
            }if(last_name ==""){
                $('#last_name_err').text('Field Is Required');
            }
            if(city ==""){
                $('#city_err').text('Field Is Required');
            }
            if(bdate ==""){
                $('#bdate_err').text('Field Is Required');
            }
            else{
                $.ajax({
                    url: 'addCustomer',
                    type: 'post',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                     success: function(response){
                        $('.data-table').DataTable().ajax.reload();
                        $('#formCostomer').hide();
                            toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.success("Add Customer Data..!!!!");
                    }
                });
            }
        }
    });

// For SoftDelete 

$(".data-table").on("click", ".softdelete", function (e) {  
     var del_id = $(this).closest('tr').find('td:eq(0)').text();  
        if (confirm("Are you sure Delete Customer?")) {
            $.ajax({
                url: 'delete',
                type: 'get',
                data: {
                    'id':del_id },
                success: function(response){
                    $('.data-table').DataTable().ajax.reload();
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Delete Data Success..!!!!");
                }
            });
        } else{
          toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.warning("Cancle Delete..!!!!");
        }
    });
 });

</script>

</html>