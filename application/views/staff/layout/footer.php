<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Cranes Mart 2019-2020</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary btn-sm" href="{site_url}staff/dashboard/logout">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script> var base_url = "<?= base_url(); ?>"; </script>
<script src="{site_url}skin/admin/vendor/jquery/jquery.min.js"></script>
<script src="{site_url}skin/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="{site_url}skin/admin/js/bootstrap-timepicker.min.js"></script>
<script src="{site_url}skin/admin/js/jquery.datetimepicker.js"></script>


<!-- Core plugin JavaScript-->
<script src="{site_url}skin/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{site_url}skin/admin/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="{site_url}skin/admin/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="{site_url}skin/admin/js/demo/chart-area-demo.js"></script>
<script src="{site_url}skin/admin/js/demo/chart-pie-demo.js"></script>

<script src="{site_url}skin/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{site_url}skin/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="{site_url}skin/admin/js/demo/datatables-demo.js"></script>
<script src="{site_url}skin/admin/js/custom.js"></script>

<script type="text/JavaScript" language="JavaScript">

    $('.datepick').each(function () {
        $(this).datetimepicker({
            formatTime: 'H:i',
            formatDate: 'd.m.Y',
            timepicker: false
        });
    });

    $('.datetimepick').each(function () {
        $(this).datetimepicker({
            format: 'Y-m-d H:i:s',
            timepicker: true,
        });
    });
    $("#start_date").datetimepicker({
        formatTime: 'H:i',
        formatDate: 'd.m.Y',
        timepicker: false
    });
    $("#end_date").datetimepicker({
        formatTime: 'H:i',
        formatDate: 'd.m.Y',
        timepicker: false
    });
    $("#special_price_from").datetimepicker({
        formatTime: 'H:i',
        format: 'd-m-Y',
        timepicker: false
    });
    $("#special_price_to").datetimepicker({
        formatTime: 'H:i',
        format: 'd-m-Y',
        timepicker: false
    });

</script>

<script type="text/javascript">

    function hidemenu(val) {
        if (val == 1) {
            document.getElementById('parent_menu').style.display = "none";
            document.getElementById('menu_icon_class').style.display = "block";
        } else {
            document.getElementById('parent_menu').style.display = "block";
            document.getElementById('menu_icon_class').style.display = "none";
        }
    }
    $(document).ready(function () {
        kycDataTable();
    });
    function kycDataTable(keyword = '') {
        var siteUrl = $("#siteUrl").val();
        var kycDataTable = $('#kycDataTable').DataTable({
            "pageLength": 25,
            "lengthMenu": [10, 25, 50, 75, 100],
            "searching": false,
            "columnDefs": [{"targets": 0, "orderable": false}, {"targets": 1, "orderable": false}, {
                "targets": 2,
                "orderable": false
            }, {"targets": 3, "orderable": false}, {"targets": 4, "orderable": false}, {
                "targets": 5,
                "orderable": false
            }, {"targets": 6, "orderable": false}],
            "processing": false,
            "serverSide": true,
            "order": [[6, "desc"]],
            deferRender: true,
            "ajax": {
                "url": "getKycList",
                "data": function (d) {
                    d.extra_search = keyword;
                }
            },
            "initComplete": function (settings, json) {
            }
        });
    }

    $('#helpSupportTable').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: 200,
        method: 'GET',
        ajax: "<?= base_url('staff/help/getHelpList') ?>"
    });
</script>

</body>

</html>
