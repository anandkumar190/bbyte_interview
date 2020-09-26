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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <a class="btn btn-primary btn-sm" href="{site_url}seller-panel/dashboard/logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
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
  <script src="{site_url}skin/admin/js/seller-custom.js"></script>

<script type="text/JavaScript" language="JavaScript">

$('.datepick').each(function(){
$(this).datetimepicker({
formatTime:'H:i',
formatDate:'d.m.Y',
timepicker:false
});
});

$('.datetimepick').each(function(){
$(this).datetimepicker({
format:'Y-m-d H:i:s',
timepicker:true,
});
});
$("#start_date").datetimepicker({
			formatTime:'H:i',
			formatDate:'d.m.Y',
			timepicker:false
		});
       $("#end_date").datetimepicker({
            formatTime:'H:i',
            formatDate:'d.m.Y',
            timepicker:false
        });
$("#special_price_from").datetimepicker({
            formatTime:'H:i',
            format:'d-m-Y',
            timepicker:false
        });
		$("#special_price_to").datetimepicker({
            formatTime:'H:i',
            format:'d-m-Y',
            timepicker:false
        });

</script>
  
<script type="text/javascript">
  
function hidemenu(val){

if(val == 1){
document.getElementById('parent_menu').style.display="none";
document.getElementById('menu_icon_class').style.display="block";
}

else{
document.getElementById('parent_menu').style.display="block";
document.getElementById('menu_icon_class').style.display="none";
}

}

</script>

<script type="text/javascript">
    $(document).ready(function() {
      
      
      adminProductDataTable();
	  
	  function adminProductDataTable(stock_status = 0, keyword = '', approve_status = 0, vendor_id = 0)
	  {
			var siteUrl = $("#siteUrl").val();
			var adminProductDataTable = $('#adminProductDataTable').DataTable({
				"pageLength": 50,
				"lengthMenu": [ 10, 25, 50, 75, 100 ],
				"searching": false,
				"columnDefs": [ {"targets": 0,"orderable": false},{"targets": 1,"orderable": false},{"targets": 2,"orderable": false},{"targets": 3,"orderable": false},{"targets": 4,"orderable": false},{"targets": 5,"orderable": false},{"targets": 6,"orderable": false},{"targets": 7,"orderable": false},{"targets": 8,"orderable": false},{"targets": 9,"orderable": false},{"targets": 10,"orderable": false},{"targets": 11,"orderable": false},{"targets": 12,"orderable": false},{"targets": 13,"orderable": false},{"targets": 14,"orderable": false}],
				"processing": true,
				"serverSide": true,
				"order": [[ 1, "desc" ]],
				deferRender: true,
				"ajax": {
					"url": siteUrl+"seller-panel/catalog/getProductList",
					"data": function ( d ) {
						d.extra_search = stock_status+'-'+keyword+'-'+approve_status+'-'+vendor_id;
						//d.extra_search = stock_status+'- -'+approve_status+'-'+vendor_id;
					}
				},
				"initComplete": function( settings, json ) {
					$("#check_all").click(function(){
						
						var rows = adminProductDataTable.rows({ 'search': 'applied' }).nodes();
						$('input[type="checkbox"]', rows).prop('checked', this.checked);
						
						
					});
				}
					
				
			});
	  }
	  
      
      $('#packageSearchBtn').on('click', function() {
        $('#packageDataTable').DataTable().destroy();
        var keyword = $("#keyword").val();
        packageDataTable(keyword);
      });
      
      $('#employeSearchBtn').on('click', function() {
        $('#employeDataTable').DataTable().destroy();
        var keyword = $("#keyword").val();
        employeDataTable(keyword);
      });

      $('#walletSearchBtn').on('click', function() {
        $('#walletDataTable').DataTable().destroy();
        var keyword = $("#keyword").val();
        walletDataTable(keyword);
      });

      $('#rechargeSearchBtn').on('click', function() {
        $('#rechargeDataTable').DataTable().destroy();
        var keyword = $("#keyword").val();
        rechargeDataTable(keyword);
      });

      
      
      $('#leadFilterForm').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          $("#employeSearchBtn").click();
        e.preventDefault();
        return false;
        }

      });
    });
    
  </script>
   
</body>

</html>
