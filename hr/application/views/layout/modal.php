    <script type="text/javascript">
        function showAjaxModal(url){
            jQuery('#modal_ajax .modal-dialog').html('<div style="text-align:center;margin-top:200px;"><img src="<?= base_url('assets/images/preloader.gif');?>" /></div>');
            jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
            $.ajax({
                url: url,
                success: function(response)
                {
                    jQuery('#modal_ajax .modal-dialog').html(response);
                }
            });
//            jQuery('#modal_ajax .modal-content').html(response);
        }
	</script>
	<style>
		body.modal-open {
			overflow: hidden;
		}
	</style>
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">

        </div>
    </div>

    <script type="text/javascript">
        function confirm_modal(delete_url)
        {
            jQuery('#modal-4').modal('show', {backdrop: 'static'});
            document.getElementById('delete_link').setAttribute('href' , delete_url);
        }
	</script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>

                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="JavaScript:void(0);" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

	<script type="text/javascript">
        function confirm_session()
        {
            jQuery('#modal-5').modal('show', {backdrop: 'static'});
        }
	</script>

	<!-- (Normal Modal)-->
	<div class="modal fade" id="modal-5">
		<div class="modal-dialog">
			<div class="modal-content" style="margin-top:100px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" style="text-align:center;">Are you sure to change session..!</h4>
				</div>

				<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
					<a href="JavaScript:void(0);" class="btn btn-danger" onclick="return saveSession()" id="confirmSessionLink">Confirm</a>
					<button type="button" class="btn btn-info" data-dismiss="modal" onclick="javascript:window.location.reload()" id="closeSessionCancel">Cancel</button>
				</div>
			</div>
		</div>
	</div>
