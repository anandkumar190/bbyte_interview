{system_message}    
{system_info}
<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Update Category</b></h4>
                </div>
                
                <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            <?php echo form_open_multipart('admin/catalog/updateCategory', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
			  <input type="hidden" name="catID" value="<?php echo $catID; ?>" />
              <div class="row">
              <div class="col-sm-3">
              <div class="form-group">
                        <label>Title*</label>                                    
                        <?php
                        $data = array('name' => 'title',
                            'id' => 'title',
                            'class' => 'form-control input-sm',
                            'autocomplete' => 'off',
                            'placeholder' => 'Title',
							'value' => $categoryData['title']
                        );
                        echo form_input($data);
                        ?>   						
                        <?php echo form_error('title', '<div class="error">', '</div>'); ?>
                       </div>
              </div>
			  <div class="col-sm-3">
              <div class="form-group">
                        <label>Category Position</label>                                    
                        <?php
                        $data = array('name' => 'order_number',
                            'id' => 'order_number',
                            'class' => 'form-control input-sm',
                            'autocomplete' => 'off',
                            'placeholder' => 'Category Position',
							'value' => $categoryData['order_number']
                        );
                        echo form_input($data);
                        ?>   						
                        <?php echo form_error('order_number', '<div class="error">', '</div>'); ?>
                       </div>
              </div>
              <div class="col-sm-3">
              <div class="form-group">
                        <label>Parent Category</label>                                    
                        <select class="form-control" name="parent_cat_id">
							<option value="0">Select Parent Category</option>
							<?php if($parent_category_list){ ?>
								<?php foreach($parent_category_list as $list){ ?>
									<option <?php if($categoryData['parent_id'] == $list['id']) : ?> selected="selected" <?php endif; ?> value="<?php echo $list['id']; ?>"><?php echo $list['title']; ?></option>
								<?php } ?>
							<?php } ?>
						</select> 						
                        <?php echo form_error('parent_cat_id', '<div class="error">', '</div>'); ?>
                       </div>
              </div>
              
              <div class="col-sm-3">
                <div class="form-group">
                        <label>Status</label>                                    
                        <select id="select01" class="form-control" name="status">
							<option<?php if($categoryData['status'] == 1) : ?> selected="selected" <?php endif; ?> value="1">Active</option>
							<option<?php if($categoryData['status'] == 0) : ?> selected="selected" <?php endif; ?> value="0">Deactive</option>
						  </select>
                       </div>
              </div>
			  <div class="col-sm-4">
                <div class="form-group">
                        <input type="checkbox" name="is_cranes_choice"<?php if($categoryData['is_cranes_choice'] == 1) : ?> checked="checked" <?php endif; ?> value="1" id="is_cranes_choice" />
						<label for="is_cranes_choice">Is this category belong to CRANES CHOICE ?</label>                                    
                        
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




