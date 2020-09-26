{system_message}    
{system_info}
<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Add Member Package</b></h4>
                </div>
                
                <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            <?php echo form_open_multipart('admin/member/saveMemberPackage', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
              <div class="row">
              <div class="col-sm-4">
              <div class="form-group">
              <label><b>Member*</b></label>
              <select class="selectpicker form-control" name="member_id" data-live-search="true">
				<option value="">Select Member</option>
				<?php if($memberList){ ?>
					<?php foreach($memberList as $list){ ?>
						<option value="<?php echo $list['id']; ?>"><?php echo ucwords($list['name']).' ('.$list['user_code'].')'; ?></option>  
					<?php } ?>
				<?php } ?>
              </select>
              <?php echo form_error('member_id  ', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
			  <div class="col-sm-4">
              <div class="form-group">
              <label><b>Package*</b></label>
              <select class="form-control" name="package_id">
				<option value="">Select Package</option>
				<?php if($packageList){ ?>
					<?php foreach($packageList as $list){ ?>
						<option value="<?php echo $list['id']; ?>"><?php echo ucwords($list['package_name']); ?></option>  
					<?php } ?>
				<?php } ?>
              </select>
              <?php echo form_error('package_id  ', '<div class="error">', '</div>'); ?>  
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




