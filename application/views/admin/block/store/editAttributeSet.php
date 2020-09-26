{system_message}    
{system_info}
<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Update Attribute Set</b></h4>
                </div>
                
                <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            <?php echo form_open_multipart('admin/store/updateAttributeSet', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
			  <input type="hidden" name="catID" value="<?php echo $catID; ?>" />
              <div class="row">
              <div class="col-sm-4">
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
              <div class="col-sm-4">
               <div class="form-group">
                        <label>Status</label>                                    
                        <select id="select01" class="form-control" name="status">
							<option<?php if($categoryData['status'] == 1) : ?> selected="selected" <?php endif; ?> value="1">Active</option>
							<option<?php if($categoryData['status'] == 0) : ?> selected="selected" <?php endif; ?> value="0">Deactive</option>
						  </select>
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