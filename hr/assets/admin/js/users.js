
$_tableData = $('#table-list-data').DataTable({
    paging:true,
    pageLength:10,
    processing:true,
    serverSide:true,
    ordering:false,
    destroy:true,
    "ajax": {
        "url": base_url+"admin/users/getUserList",
        "method": "GET",
        "data": function (data) {
        },
    },
});

$(document).on('click', 'button[name="btn-save-data"]', function (e) {
    var form_id = '#form-data';
    var validate = isValidate(form_id);
    if(validate == 'true'){
        var formData = $("#form-data").serialize();
        $.ajax({
            type: "POST",
            url: base_url+'admin/users/saveUpdateUsers',
            data: formData,
            dataType: "json",
            success: function(data) {
                if(data.status == 'success'){
                    $_tableData.draw();
                    jQuery('#modal_ajax').modal('hide');
                }
                swal(data.message, "", data.status)
            }
        });
    }
});