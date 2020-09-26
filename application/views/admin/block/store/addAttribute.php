{system_message}
{system_info}
<?php echo form_open_multipart('admin/store/saveAttribute', array('id' => 'admin_profile'), array('method' => 'post')); ?>
<div class="card shadow ">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-sm-6">
                <h4><b>Add New Attribute</b></h4>
            </div>

            <div class="col-sm-6 text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i>
                </button>
            </div>
        </div>

    </div>
    <div class="card-body">

        <input type="hidden" value="<?php echo $site_url; ?>" id="siteUrl">
        <input type="hidden" value="0" id="totalDropdownRecord"/>
        <input type="hidden" value="0" id="totalVisualSwatchRecord"/>
        <input type="hidden" value="0" id="totalTextSwatchRecord"/>
        <input type="hidden" value="0" id="totalMultiselectRecord"/>
        <input type="hidden" value="0" id="totalMultiDropdownRecord"/>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <select id="select01" class="form-control" name="status">
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
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
                        <option value="1">Yes</option>
                        <option value="0" selected="selected">No</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Catalog input type for Store Owner</label>
                    <select id="selAttributeFormType" class="form-control" name="form_type">
                        <option value="">Select Type</option>
                        <?php if ($formTypeList) { ?>
                            <?php foreach ($formTypeList as $list) { ?>
                                <option value="<?php echo $list['id']; ?>"><?php echo $list['title']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Value Required</label>
                    <select id="select01" class="form-control" name="is_required">
                        <option value="1">Yes</option>
                        <option value="0" selected="selected">No</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Is Input Box ?</label>
                    <select id="select01" class="form-control" name="is_input_box">
                        <option value="1">Yes</option>
                        <option value="0" selected="selected">No</option>
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
                        <input type="checkbox" name="attribute_set_id[]" value="<?php echo $list['id']; ?>"
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
                <div class="form-group" id="dropdown-block" style="display:none;">
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="dropdown-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Label</b></td>
                            <td><b>Value</b></td>
                            <td></td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreDropdownBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group" id="visual-swatch-block" style="display:none;">
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="visual-swatch-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Color Code</b></td>
                            <td><b>Label</b></td>
                            <td></td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreVisualSwatchBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group" id="text-swatch-block" style="display:none;">
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="text-swatch-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Label</b></td>
                            <td><b>Description</b></td>
                            <td></td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreTextSwatchBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group" id="multi-visual-swatch-block" style="display:none;">
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="multi-visual-swatch-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Color Code</b></td>
                            <td><b>Label</b></td>
                            <td></td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-primary" id="addMoreMultiselectBtn">Add Option</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group" id="multi-dropdown-block" style="display:none;">
                    <label>Manage Options (Values of Your Attribute)</label>
                    <table class="table" id="multi-dropdown-table">
                        <tr>
                            <td><b>Is Default</b></td>
                            <td><b>Label</b></td>
                            <td><b>Value</b></td>
                            <td></td>
                        </tr>
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