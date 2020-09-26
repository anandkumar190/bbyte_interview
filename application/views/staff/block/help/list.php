<?php echo form_open_multipart('member/token/requestTokenAuth', array('id' => 'admin_profile'), array('method' => 'post')); ?>
<input type="hidden" value="<?php echo $site_url; ?>" id="siteUrl">
<div class="card shadow ">
    {system_message}
    {system_info}
    <div class="card-header py-3">
        <div class="row">
            <div class="col-sm-6">
                <h4><b>Help Support List</b></h4>
            </div>
            <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" type="button" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="helpSupportTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php echo form_close(); ?>
</div>




