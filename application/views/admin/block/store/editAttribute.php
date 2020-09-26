{system_message}
{system_info}
<?php echo form_open_multipart('admin/store/updateAttribute', array('id' => 'admin_profile'), array('method' => 'post')); ?>
<div class="card shadow ">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-sm-6">
                <h4><b>Update Attribute</b></h4>
            </div>

            <div class="col-sm-6 text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i>
                </button>
            </div>
        </div>

    </div>
    <div class="card-body">

        <input type="hidden" value="<?php echo $site_url; ?>" id="siteUrl">
        <input type="hidden" value="{attribute_id}" name="attribute_id"/>
        <input type="hidden" value="<?php echo $attributeData['form_type']; ?>" name="form_type_id"/>
        <input type="hidden" value="<?php if ($attributeData['form_type'] == 1) {
            echo count($attributeFormData);
        } else {
            echo 0;
        } ?>" id="totalDropdownRecord"/>
        <input type="hidden" value="<?php if ($attributeData['form_type'] == 2) {
            echo count($attributeFormData);
        } else {
            echo 0;
        } ?>" id="totalVisualSwatchRecord"/>
        <input type="hidden" value="<?php if ($attributeData['form_type'] == 3) {
            echo count($attributeFormData);
        } else {
            echo 0;
        } ?>" id="totalTextSwatchRecord"/>
        <input type="hidden" value="<?php if ($attributeData['form_type'] == 4) {
            echo count($attributeFormData);
        } else {
            echo 0;
        } ?>" id="totalMultiselectRecord"/>
        <input type="hidden" value="<?php if ($attributeData['form_type'] == 5) {
            echo count($attributeFormData);
        } else {
            echo 0;
        } ?>" id="totalMultiDropdownRecord"/>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <select id="select01" class="form-control" name="status">
                        <option value="1" <?php if ($attributeData['status'] == 1) { ?> selected="selected" <?php } ?>>
                            Enable
                        </option>
                        <option value="0" <?php if ($attributeData['status'] == 0) { ?> selected="selected" <?php } ?>>
                            Disable
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Label*</label>
                    <?php
                    $data = array('name' => 'label',
                        'id' => 'label',
                        'class' => 'form-control input-sm',
                        'autocomplete' => 'off',
                        'placeholder' => 'Label',
                        'value' => $attributeData['label']
                    );
                    echo form_input($data);
                    ?>
                    <?php echo form_error('label', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Attribute Code*</label>
                    <?php
                    $data = array('name' => 'attribute_code',
                        'id' => 'attribute_code',
                        'class' => 'form-control input-sm',
                        'autocomplete' => 'off',
                        'placeholder' => 'Attribute Code',
                        'value' => $attributeData['attribute_code']
                    );
                    echo form_input($data);
                    ?>
                    <?php echo form_error('attribute_code', '<div class="error">', '</div>'); ?>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Use in filter option</label>
                    <select id="select01" class="form-control" name="is_filter">
                        <option value="1" <?php if ($attributeData['is_filter'] == 1) { ?> selected="selected" <?php } ?>>
                            Yes
                        </option>
                        <option value="0" <?php if ($attributeData['is_filter'] == 0) { ?> selected="selected" <?php } ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Catalog input type for Store Owner</label>
                    <select id="selAttributeFormType" class="form-control" name="form_type" disabled>
                        <option value="">Select Type</option>
                        <?php if ($formTypeList) { ?>
                            <?php foreach ($formTypeList as $list) { ?>
                                <option value="<?php echo $list['id']; ?>" <?php if ($attributeData['form_type'] == $list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['title']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Value Required</label>
                    <select id="select01" class="form-control" name="is_required">
                        <option value="1" <?php if ($attributeData['is_required'] == 1) { ?> selected="selected" <?php } ?>>
                            Yes
                        </option>
                        <option value="0" <?php if ($attributeData['is_required'] == 0) { ?> selected="selected" <?php } ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Is Input Box ?</label>
                    <select id="select01" class="form-control" name="is_input_box">
                        <option value="1" <?php if ($attributeData['is_input_box'] == 1) { ?> selected="selected" <?php } ?>>
                            Yes
                        </option>
                        <option value="0" <?php if ($attributeData['is_input_box'] == 0) { ?> selected="selected" <?php } ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <label>Color</label>
                    <input type="color" class="form-control" name="color" value="#fff">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Color Code</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="color_code" id="colorCodeInput" value="#fff" readonly="readonly" aria-describedby="colorCode">
                        <div class="input-group-prepend">
                            <button type="button" class="input-group-text btn btn-default" id="colorCode" title="Click for copy"><i class="fa fa-copy"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h4>Assign to Attribute Set</h4>
                <?php if ($attributeSetList) { ?>
                    <?php foreach ($attributeSetList as $list) { ?>
                        <input type="checkbox" <?php if (in_array($list['id'], $attributeSetAttributeData)) { ?> checked="checked" <?php } ?>
                               name="attribute_set_id[]" value="<?php echo $list['id']; ?>"
                               id="attribute_set_<?php echo $list['id']; ?>"/>
                        <label for="attribute_set_<?php echo $list['id']; ?>"><?php echo $list['title']; ?></label>
                        <br/>
                    <?php } ?>
                <?php } else { ?>
                    No Attribute Set Found.
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     id="dropdown-block" <?php if ($attributeData['form_type'] == 1) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="dropdown-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Label</b></td>
                            <td><b>Value</b></td>
                            <td></td>
                        </tr>
                        <?php if ($attributeFormData && $attributeData['form_type'] == 1) { ?>
                            <?php foreach ($attributeFormData as $list) { ?>
                                <tr id="dropdown_tr_<?php echo $list['order_no']; ?>">
                                    <td>
                                        <input type="radio" <?php if ($list['is_default'] == 1) { ?> checked="checked" <?php } ?>
                                               name="dropdown_is_default" value="<?php echo $list['order_no']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $list['label']; ?>"
                                               name="dropdown_label[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               value="<?php echo $list['description']; ?>"
                                               name="dropdown_value[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td><i class="fa fa-trash"
                                           onclick="deleteDropdownRow(<?php echo $list['order_no']; ?>)"
                                           aria-hidden="true"></i></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreDropdownBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     id="visual-swatch-block" <?php if ($attributeData['form_type'] == 2) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="visual-swatch-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Color Code</b></td>
                            <td><b>Label</b></td>
                            <td></td>
                        </tr>
                        <?php if ($attributeFormData && $attributeData['form_type'] == 2) { ?>
                            <?php foreach ($attributeFormData as $list) { ?>
                                <tr id="visual_swatch_tr_<?php echo $list['order_no']; ?>">
                                    <td>
                                        <input type="radio" <?php if ($list['is_default'] == 1) { ?> checked="checked" <?php } ?>
                                               name="dropdown_is_default" value="<?php echo $list['order_no']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $list['label']; ?>"
                                               name="dropdown_label[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               value="<?php echo $list['description']; ?>"
                                               name="dropdown_value[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td><i class="fa fa-trash"
                                           onclick="deleteVisualSwatchRow(<?php echo $list['order_no']; ?>)"
                                           aria-hidden="true"></i></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreVisualSwatchBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     id="text-swatch-block" <?php if ($attributeData['form_type'] == 3) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="text-swatch-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Label</b></td>
                            <td><b>Description</b></td>
                            <td></td>
                        </tr>
                        <?php if ($attributeFormData && $attributeData['form_type'] == 3) { ?>
                            <?php foreach ($attributeFormData as $list) { ?>
                                <tr id="text_swatch_tr_<?php echo $list['order_no']; ?>">
                                    <td>
                                        <input type="radio" <?php if ($list['is_default'] == 1) { ?> checked="checked" <?php } ?>
                                               name="dropdown_is_default" value="<?php echo $list['order_no']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $list['label']; ?>"
                                               name="dropdown_label[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               value="<?php echo $list['description']; ?>"
                                               name="dropdown_value[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td><i class="fa fa-trash"
                                           onclick="deleteTextSwatchRow(<?php echo $list['order_no']; ?>)"
                                           aria-hidden="true"></i></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreTextSwatchBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     id="multi-visual-swatch-block" <?php if ($attributeData['form_type'] == 4) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="multi-visual-swatch-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Color Code</b></td>
                            <td><b>Description</b></td>
                            <td></td>
                        </tr>
                        <?php if ($attributeFormData && $attributeData['form_type'] == 4) { ?>
                            <?php foreach ($attributeFormData as $list) { ?>
                                <tr id="multiselect_tr_<?php echo $list['order_no']; ?>">
                                    <td>
                                        <input type="checkbox" <?php if ($list['is_default'] == 1) { ?> checked="checked" <?php } ?>
                                               name="dropdown_is_default[<?php echo $list['order_no']; ?>]"
                                               value="<?php echo $list['order_no']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $list['label']; ?>"
                                               name="dropdown_label[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               value="<?php echo $list['description']; ?>"
                                               name="dropdown_value[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td><i class="fa fa-trash"
                                           onclick="deleteMultiselectRow(<?php echo $list['order_no']; ?>)"
                                           aria-hidden="true"></i></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreMultiselectBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"
                     id="multi-dropdown-block" <?php if ($attributeData['form_type'] == 5) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="multi-dropdown-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Label</b></td>
                            <td><b>Value</b></td>
                            <td></td>
                        </tr>
                        <?php if ($attributeFormData && $attributeData['form_type'] == 5) { ?>
                            <?php foreach ($attributeFormData as $list) { ?>
                                <tr id="multiselect_tr_<?php echo $list['order_no']; ?>">
                                    <td>
                                        <input type="checkbox" <?php if ($list['is_default'] == 1) { ?> checked="checked" <?php } ?>
                                               name="dropdown_is_default[<?php echo $list['order_no']; ?>]"
                                               value="<?php echo $list['order_no']; ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $list['label']; ?>"
                                               name="dropdown_label[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               value="<?php echo $list['description']; ?>"
                                               name="dropdown_value[<?php echo $list['order_no']; ?>]"/>
                                    </td>
                                    <td><i class="fa fa-trash"
                                           onclick="deleteMultiDropdownRow(<?php echo $list['order_no']; ?>)"
                                           aria-hidden="true"></i></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreMultiDropdownBtn">Add Option</button>
                </div>
            </div>
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