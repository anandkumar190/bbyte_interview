{system_message}
{system_info}
<style>
    .divDisable {
        display: none;
    }
</style>
<div class="card shadow ">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-sm-6">
                <h4><b>Update User</b></h4>
            </div>

            <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i>
                </button>
            </div>
        </div>

    </div>
    <div class="card-body">
        <?php echo form_open_multipart('admin/users/updateUser', array('id' => 'admin_profile'), array('method' => 'post')); ?>
        <input type="hidden" value="<?php echo $site_url; ?>" id="siteUrl">
        <input type="hidden" value="<?php echo $id; ?>" name="id">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label><b>Name*</b></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                           value="<?php echo $memberList['name']; ?>">
                    <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label><b>Email*</b></label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                           value="<?php echo $memberList['email']; ?>">
                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label><b>Mobile*</b></label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile"
                           value="<?php echo $memberList['mobile']; ?>">
                    <?php echo form_error('mobile', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label><b>Password</b></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label><b>Status</b></label>
                    <select class="form-control" name="is_active">
                        <option value="1" <?php if ($memberList['is_active'] == 1) { ?> selected="" <?php } ?>>Active
                        </option>
                        <option value="0" <?php if ($memberList['is_active'] == 0) { ?> selected="" <?php } ?>>
                            Deactive
                        </option>
                    </select>
                    <?php echo form_error('is_active  ', '<div class="error">', '</div>'); ?>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label><b>Role*</b></label>
                    <select class="form-control" name="role_id">
                        <option value="">Select Role</option>
                        <?php if ($roleList) { ?>
                            <?php foreach ($roleList as $list) { ?>
                                <option value="<?php echo $list['id']; ?>"<?php if ($memberList['role_id'] == $list['id']) { ?> selected="" <?php } ?>><?php echo $list['title']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <?php echo form_error('role_id', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <?php if($memberList['role_id']==6){ ?>
            <div class="col-sm-4" id="for-view">
                <div class="form-group">
                    <label><b>For View</b></label>
                    <select class="form-control" name="for_view">
                        <option value="">Select For View</option>
                        <option value="1" <?php if ($memberList['for_view'] == 1) { ?> selected="" <?php } ?>>KYC</option>
                        <option value="2" <?php if ($memberList['for_view'] == 2) { ?> selected="" <?php } ?>>Help Support</option>
                    </select>
                    <?php echo form_error('for_view', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <?php } ?>
        </div>

    </div>
</div>
<div class="card shadow">
    <div class="card-header py-3 text-right">
        <button type="submit" class="btn btn-success">Submit</button>
        <button onclick="window.history.back()" type="button" class="btn btn-secondary">Cancel</button>
    </div>
</div>
<?php echo form_close(); ?>
</div>



