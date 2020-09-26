
	<script> var base_url = "<?= base_url(); ?>";</script>
	<script src="<?= base_url('assets/'); ?>js/lib/jquery.js"></script>
	<script src="<?= base_url('assets/'); ?>js/lib/jquery-migrate.js"></script>
	<script src="<?= base_url('assets/'); ?>js/lib/bootstrap.js"></script>
	<script src="<?= base_url('assets/'); ?>js/lib/login-validation.js"></script>
	<script src="<?= base_url('assets/'); ?>js/lib/jquery.dataTables.js"></script>
	<script src="<?= base_url('assets/'); ?>js/lib/dataTables.tableTools.js"></script>
	<script src="<?= base_url('assets/'); ?>js/lib/dataTables.bootstrap.js"></script>

    <script src="<?= base_url('assets/'); ?>js/lib/jRespond.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/hammerjs.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/jquery.hammer.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/jquery.syntaxhighlighter.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/velocity.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/jquery-jvectormap.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/jquery-jvectormap-world-mill.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/jquery-jvectormap-us-aea.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/smart-resize.js"></script>
    <script src="<?= base_url('assets/'); ?>js/lib/jquery.slimscroll.js"></script>

	<!--Forms-->
	<script src="<?= base_url('assets/'); ?>js/lib/sweetalert.js"></script>
	<script src="<?= base_url('assets/'); ?>js/apps.js"></script>
	<script src="<?= base_url('assets/'); ?>js/formValidate.js"></script>
    <script> var $_tableData = ''; </script>
    <?php
        $jsFile = 'assets/'.$this->uri->segment(1).'/js/'.$this->uri->segment(2).'.js';
        if(file_exists($jsFile)){
    ?>
        <script src="<?= base_url($jsFile); ?>"></script>
    <?php } ?>

    <script>
        $(document).on('change', 'select[name="state_id"]', function (e) {
            var state_id = this.value;
            $('select[name="city_id"]').html('<option value="">---Select City---</option>');
            $.ajax({
                type: "GET",
                url: base_url + "common/getCityByStateId",
                data: {stateId: state_id},
                dataType: 'json',
                success: function(res){
                    if(res.status == true){
                        var html = '<option value="">---Select City---</option>';
                        $.each(res.data, function(key, val) {
                            html += '<option value="'+val['id']+'">'+val['name']+'</option>';
                        });
                        $('select[name="city_id"]').html(html);
                    }
                }
            });
        })
    </script>