{system_message}    
{system_info}
<?php echo form_open_multipart('admin/banners/saveBanner', array('id' => 'admin_profile'),array('method'=>'post')); ?>
<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Add Banner</b></h4>
                </div>
                
                <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            
              <input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
              <div class="row">
              <div class="col-sm-3">
              <div class="form-group">
							<label>Status</label>                                    
							<select id="select01" class="form-control" name="status">
								<option value="1">Active</option>
								<option value="0">Deactive</option>
							</select>
						</div>
              </div>
              <div class="col-sm-3">
              <div class="form-group">
							<label>Banner Type*</label>                                    
							<select id="select01" class="form-control" name="banner_type_id">
								<option value="">Select Banner Type</option>
								<?php if($bannerTypeList){ ?>
									<?php foreach($bannerTypeList as $list){ ?>
										<option value="<?php echo $list['id']; ?>"><?php echo $list['title']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('banner_type_id', '<div class="error">', '</div>'); ?>
						</div>
              </div>
              
              <div class="col-sm-3">
                <div class="form-group">
							<label>Banner Image*</label>                                    
							<input type="file" name="banner_image" />
							<p>Only .jpg,.png or .gif format allowed.</p>
							<?php echo form_error('banner_image', '<div class="error">', '</div>'); ?>
						</div>
              </div>
			  <div class="col-sm-3">
                <div class="form-group">
							<label>Position No. (optional)</label>                                    
							<?php
								$data = array('name' => 'order_no',
								'id' =>'order_no',
								'class' => 'form-control input-sm',
								'autocomplete' => 'off',
								'placeholder' => 'Position No. (Leave Blank for auto position)',
								'value' => set_value('order_no')

								);
								echo form_input($data);
							?>              
							<?php echo form_error('order_no', '<div class="error">', '</div>'); ?>
						</div>
              </div>
              </div>
			  <div class="row">
              <div class="col-sm-3">
              <div class="form-group">
							<label>Link URL (optional)</label>                                    
							<?php
								$data = array('name' => 'redirect_url',
								'id' =>'redirect_url',
								'class' => 'form-control input-sm',
								'autocomplete' => 'off',
								'placeholder' => 'Link URL',
								'value' => set_value('redirect_url')

								);
								echo form_input($data);
							?>              
							<?php echo form_error('redirect_url', '<div class="error">', '</div>'); ?>
						</div>
              </div>
              <div class="col-sm-3">
              <div class="form-group">
							<label>Is open link url in new tab ?</label><br />
							<input type="radio" name="is_new_tab" value="1" id="is_new_tab_1" />
							<label for="is_new_tab_1">Yes</label>
							<input type="radio" name="is_new_tab" value="0" id="is_new_tab_0" checked="checked" />
							<label for="is_new_tab_0">No</label>
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




