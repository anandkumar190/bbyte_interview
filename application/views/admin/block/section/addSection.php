{system_message}    
{system_info}
<?php echo form_open_multipart('admin/section/saveSection', array('id' => 'admin_profile'),array('method'=>'post')); ?>
<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Add Section</b></h4>
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
							<label>Section Type*</label>                                    
							<select id="selSectionType" class="form-control" name="section_type_id">
								<option value="">Select Section Type</option>
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
								<label>Section Name (optional)</label>                                    
								<?php
									$data = array('name' => 'section_name',
									'id' =>'section_name',
									'class' => 'form-control input-sm',
									'autocomplete' => 'off',
									'placeholder' => 'Section Name',
									'value' => set_value('section_name')

									);
									echo form_input($data);
								?>              
								<?php echo form_error('section_name', '<div class="error">', '</div>'); ?>
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
				  <div class="col-sm-12">
					  <div id="2-banner-section" style="display:none;">
								<div class="form-group">
									<label>Banner 1 Image</label>                                    
									<input type="file" name="two_banner_1_image" />
									<p>Only .jpg,.png or .gif format allowed.</p>
									<?php echo form_error('two_banner_1_image', '<div class="error">', '</div>'); ?>
								</div>
								<div class="form-group">
									<label>Link URL (optional)</label>                                    
									<?php
										$data = array('name' => 'two_banner_1_redirect_url',
										'id' =>'two_banner_1_redirect_url',
										'class' => 'form-control input-sm',
										'autocomplete' => 'off',
										'placeholder' => 'Link URL',
										'value' => set_value('two_banner_1_redirect_url')

										);
										echo form_input($data);
									?>              
									<?php echo form_error('two_banner_1_redirect_url', '<div class="error">', '</div>'); ?>
								</div>
								<div class="form-group">
									<label>Is open link url in new tab ?</label><br />
									<input type="radio" name="two_banner_1_is_new_tab" value="1" id="two_banner_1_is_new_tab_1" />
									<label for="two_banner_1_is_new_tab_1">Yes</label>
									<input type="radio" name="two_banner_1_is_new_tab" value="0" id="two_banner_1_is_new_tab_0" checked="checked" />
									<label for="two_banner_1_is_new_tab_0">No</label>
								</div>
								<hr />
								<div class="form-group">
									<label>Banner 2 Image</label>                                    
									<input type="file" name="two_banner_2_image" />
									<p>Only .jpg,.png or .gif format allowed.</p>
									<?php echo form_error('two_banner_2_image', '<div class="error">', '</div>'); ?>
								</div>
								<div class="form-group">
									<label>Link URL (optional)</label>                                    
									<?php
										$data = array('name' => 'two_banner_2_redirect_url',
										'id' =>'two_banner_2_redirect_url',
										'class' => 'form-control input-sm',
										'autocomplete' => 'off',
										'placeholder' => 'Link URL',
										'value' => set_value('two_banner_2_redirect_url')

										);
										echo form_input($data);
									?>              
									<?php echo form_error('two_banner_2_redirect_url', '<div class="error">', '</div>'); ?>
								</div>
								<div class="form-group">
									<label>Is open link url in new tab ?</label><br />
									<input type="radio" name="two_banner_2_is_new_tab" value="1" id="two_banner_2_is_new_tab_1" />
									<label for="two_banner_2_is_new_tab_1">Yes</label>
									<input type="radio" name="two_banner_2_is_new_tab" value="0" id="two_banner_2_is_new_tab_0" checked="checked" />
									<label for="two_banner_2_is_new_tab_0">No</label>
								</div>
							</div>
				  </div>
				  <div class="col-sm-12">
					  <div id="5-banner-section" style="display:none;">
							<div class="form-group">
								<label>Banner 1 Image</label>                                    
								<input type="file" name="five_banner_small_1_image" />
								<p>Only .jpg,.png or .gif format allowed.</p>
								<?php echo form_error('five_banner_small_1_image', '<div class="error">', '</div>'); ?>
							</div>
							<div class="form-group">
								<label>Link URL (optional)</label>                                    
								<?php
									$data = array('name' => 'five_banner_small_1_redirect_url',
									'id' =>'five_banner_small_1_redirect_url',
									'class' => 'form-control input-sm',
									'autocomplete' => 'off',
									'placeholder' => 'Link URL',
									'value' => set_value('five_banner_small_1_redirect_url')

									);
									echo form_input($data);
								?>              
								<?php echo form_error('five_banner_small_1_redirect_url', '<div class="error">', '</div>'); ?>
							</div>
							<div class="form-group">
								<label>Is open link url in new tab ?</label><br />
								<input type="radio" name="five_banner_small_1_is_new_tab" value="1" id="five_banner_small_1_is_new_tab_1" />
								<label for="five_banner_small_1_is_new_tab_1">Yes</label>
								<input type="radio" name="five_banner_small_1_is_new_tab" value="0" id="five_banner_small_1_is_new_tab_0" checked="checked" />
								<label for="five_banner_small_1_is_new_tab_0">No</label>
							</div>
							<hr />
							<div class="form-group">
								<label>Banner 2 Image</label>                                    
								<input type="file" name="five_banner_small_2_image" />
								<p>Only .jpg,.png or .gif format allowed.</p>
								<?php echo form_error('five_banner_small_2_image', '<div class="error">', '</div>'); ?>
							</div>
							<div class="form-group">
								<label>Link URL (optional)</label>                                    
								<?php
									$data = array('name' => 'five_banner_small_2_redirect_url',
									'id' =>'five_banner_small_2_redirect_url',
									'class' => 'form-control input-sm',
									'autocomplete' => 'off',
									'placeholder' => 'Link URL',
									'value' => set_value('five_banner_small_2_redirect_url')

									);
									echo form_input($data);
								?>              
								<?php echo form_error('five_banner_small_2_redirect_url', '<div class="error">', '</div>'); ?>
							</div>
							<div class="form-group">
								<label>Is open link url in new tab ?</label><br />
								<input type="radio" name="five_banner_small_2_is_new_tab" value="1" id="five_banner_small_2_is_new_tab_1" />
								<label for="five_banner_small_2_is_new_tab_1">Yes</label>
								<input type="radio" name="five_banner_small_2_is_new_tab" value="0" id="five_banner_small_2_is_new_tab_0" checked="checked" />
								<label for="five_banner_small_2_is_new_tab_0">No</label>
							</div>
							<hr />
							<div class="form-group">
								<label>Banner 3 Image</label>                                    
								<input type="file" name="five_banner_small_3_image" />
								<p>Only .jpg,.png or .gif format allowed.</p>
								<?php echo form_error('five_banner_small_3_image', '<div class="error">', '</div>'); ?>
							</div>
							<div class="form-group">
								<label>Link URL (optional)</label>                                    
								<?php
									$data = array('name' => 'five_banner_small_3_redirect_url',
									'id' =>'five_banner_small_3_redirect_url',
									'class' => 'form-control input-sm',
									'autocomplete' => 'off',
									'placeholder' => 'Link URL',
									'value' => set_value('five_banner_small_3_redirect_url')

									);
									echo form_input($data);
								?>              
								<?php echo form_error('five_banner_small_3_redirect_url', '<div class="error">', '</div>'); ?>
							</div>
							<div class="form-group">
								<label>Is open link url in new tab ?</label><br />
								<input type="radio" name="five_banner_small_3_is_new_tab" value="1" id="five_banner_small_3_is_new_tab_1" />
								<label for="five_banner_small_3_is_new_tab_1">Yes</label>
								<input type="radio" name="five_banner_small_3_is_new_tab" value="0" id="five_banner_small_3_is_new_tab_0" checked="checked" />
								<label for="five_banner_small_3_is_new_tab_0">No</label>
							</div>
							
						</div>
				  </div>
				  <div class="col-sm-12" id="product-section" style="display:none;">
					<table id="sectionProductDataTable" style="width:100%;" class="table table-bordered table-striped">
						<thead>
						<tr>
						  <th><input type="checkbox" id="check_all" value="1" /></th>
						  <th>ID</th>
						  <th>Thumbnail</th>
						  <th>Name</th>
						  <th>SKU</th>
						  
						</tr>
						</thead>
						
					   
					  </table>
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




