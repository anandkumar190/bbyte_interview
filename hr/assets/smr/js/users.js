
$_tableData = $('#table-list-data').DataTable({
    paging:true,
    pageLength:10,
    processing:true,
    serverSide:true,
    ordering:false,
    destroy:true,
    "ajax": {
        "url": base_url+"smr/users/getUserList",
        "method": "GET",
        "data": function (data) {
        },
    },
});