$( document ).ready(function() {
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