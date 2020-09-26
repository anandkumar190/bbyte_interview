
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="title">Managment | User</h4>
    </div>
    <form id="form-data">
        <div class="modal-body" style="min-height:100px; overflow:auto;">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"> Fullname <span class="text-danger">*</span></label>
                            <input type="text" class="form-control inputField" name="fname" value="<?= isset($data['fullname']) ? $data['fullname'] : '' ?>" data-type="text" data-validate="required" data-message="Please Fill Fullname">
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"> Role <span class="text-danger">*</span></label>
                            <select class="form-control inputField" name="role" data-type="select" data-validate="required" data-message="Please Select Role">
                                <option value="">---Select Role---</option>
                                <?php
                                $roles = getRoles();
                                foreach ($roles as $role){
                                    ?>
                                    <option value="<?= $role['type']; ?>" <?php if(isset($data['role']) && $data['role'] == $role['type']){ echo 'selected'; } ?>><?= $role['title']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"> Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if($type == 'save'){ echo 'inputField'; } ?>" name="<?php if($type == 'save'){ echo 'email'; } ?>" value="<?= isset($data['email']) ? $data['email'] : '' ?>" data-type="email" data-validate="required" data-message="Please Fill Email" <?php if($type == 'update'){ echo 'readonly'; } ?>>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"> Contact No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if($type == 'save'){ echo 'inputField'; } ?>" onkeypress="return onlyNumber(event)" name="<?php if($type == 'save'){ echo 'contact_no'; } ?>" value="<?= isset($data['phone']) ? $data['phone'] : '' ?>" maxlength="10" data-type="text" data-validate="required" data-message="Please Fill Contact No." <?php if($type == 'update'){ echo 'readonly'; } ?>>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"> State <span class="text-danger">*</span></label>
                            <select class="form-control inputField" name="state_id" data-type="select" data-validate="required" data-message="Please Select State">
                                <option value="">---Select State---</option>
                                <?php
                                $states = getStateList();
                                foreach ($states as $state){
                                    ?>
                                    <option value="<?= $state['id']; ?>" <?php if(isset($data['state_id']) && $data['state_id'] == $state['id']){ echo 'selected'; } ?>><?= $state['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"> City <span class="text-danger">*</span></label>
                            <select class="form-control inputField" name="city_id" data-type="select" data-validate="required" data-message="Please Select City">
                                <option value="">---Select City---</option>
                                <?php
                                if(isset($data['all_city']) && !empty($data['all_city'])) {
                                    foreach ($data['all_city'] as $city) {
                                        ?>
                                        <option value="<?= $city['id']; ?>" <?php if (isset($data['city_id']) && $data['city_id'] == $city['id']) {
                                            echo 'selected';
                                        } ?>><?= $city['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <label class="text-danger err-msg"></label>
            <input type="hidden" name="id" value="<?= isset($data['id']) ? $data['id'] : ''; ?>">
            <input type="hidden" name="type" value="<?= $type ?>">
            <button type="button" class="btn btn-info" name="btn-save-data">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>


