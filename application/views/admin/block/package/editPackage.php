<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Update Package</b></h4>
                </div>
                
                <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            <?php echo form_open_multipart('admin/package/updatePackage', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
              <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
              <div class="row">
              <div class="col-sm-4">
              <div class="form-group">
              <label><b>Package Name*</b></label>
              <input type="text" class="form-control" name="package_name" id="package_name" placeholder="Package Name" value="<?php echo $packageList['package_name']; ?>">
              <?php echo form_error('package_name', '<div class="error">', '</div>'); ?>  
              </div>
              </div>

              <div class="col-sm-4">
              <div class="form-group">  
              <label><b>Amount*</b></label>
              <input type="text" class="form-control" name="package_amount" id="package_amount" placeholder="Package Amount (In Numbers Only)"  value="<?php echo $packageList['package_amount']; ?>">
              <?php echo form_error('package_amount', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
			  <div class="col-sm-4">
              <div class="form-group">
              <label><b>CM Points*</b></label>
              <input type="text" class="form-control" name="cm_points" id="cm_points"  value="<?php echo $packageList['cm_points']; ?>" placeholder="CM Points">
              <?php echo form_error('cm_points', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
              </div>

              <div class="row">
              <div class="col-sm-4">
              <div class="form-group">
              <label><b>Refer CM Points*</b></label>
              <input type="text" class="form-control" name="refer_cm_points" id="refer_cm_points"  value="<?php echo $packageList['refer_cm_points']; ?>" placeholder="Refer CM Points">
              <?php echo form_error('refer_cm_points', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
              
              <div class="col-sm-4">
              <div class="form-group">
              <label><b>Cashback (%)*</b></label>
              <input type="text" class="form-control" name="cashback" id="cashback"  value="<?php echo $packageList['cashback']; ?>" placeholder="Cashback (e.g - 5%)">
              <?php echo form_error('cashback', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
			  <div class="col-sm-4">
              <div class="form-group">
              <label><b>Status</b></label>
              <select class="form-control" name="status">
              <option value="1" <?php if($packageList['status']==1){ ?> selected="" <?php } ?>>Active</option>
              <option value="0"  <?php if($packageList['status']==0){ ?> selected="" <?php } ?>>Deactive</option>  
              </select>
              <?php echo form_error('is_active  ', '<div class="error">', '</div>'); ?>  
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




