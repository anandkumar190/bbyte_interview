<div class="card shadow mb-4">
              {system_message}               
              {system_info}
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Banners</b></h4>
                </div>

                <div class="col-sm-2">
                <?php echo form_open('',array('id'=>'leadFilterForm')); ?>
                <input type="text" class="form-control" placeholder="Keyword" name="keyword" id="keyword" />
                </div>

                <div class="col-sm-4">
                <button type="button" class="btn btn-success" id="employeSearchBtn">Search</button>
                <a href="{site_url}admin/banners" class="btn btn-secondary">View All</a>
                <a href="{site_url}admin/banners/addBanner" class="btn btn-primary">+Add New Banner</a>
                </div>
               </div>  
              <?php echo form_close(); ?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
					  <th>Banner Type</th>
					  <th>Banner Position</th>
					  <th>Redirect Url</th>
					  <th>Image</th>
					  <th>New Tab</th>
					  <th>Status</th>
					  <th>Edit</th>
					  <th>Delete</th>
                    </tr>
                  </thead>
				  <tbody>
				<?php if($bannerList): 
				$i = 1;
					foreach($bannerList as $list):
					
				?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php if($list['banner_type_id']==1){echo "Home Banner";} else{ echo "Home Small Banner";}  ?></td>
                  <td><?php echo $list['order_no']; ?></td>
                  <td><?php echo $list['redirect_url']; ?></td>      
				 <td><img src="{site_url}<?php echo $list['image_path']; ?>" width="70"></td>
                 <td><?php echo ($list['is_new_tab'] == 1) ? 'Yes' : 'No'; ?></td>  
                 <td><?php echo ($list['is_active'] == 1) ? '<font color="green">Active</font>' : '<font color="red">Deactive</font>'; ?></td>
				  <td><a title="edit" class="btn btn-primary btn-sm" href="<?php echo base_url('admin/banners/editBanner').'/'.$list['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                  <td>
				  <a title="delete" class="btn btn-danger btn-sm" href="<?php echo base_url('admin/banners/deleteBanner').'/'.$list['id']; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a> </td>
                  
                </tr>
                <?php $i++; endforeach; else :
				?>
				<tr>
                  <td colspan="11">No Record Found</td>
                  
                </tr>
				<?php
				endif; ?>
                </tbody>
                  <tfoot>
                    <tr>
                      <th>#</th>
					  <th>Banner Type</th>
					  <th>Banner Position</th>
					  <th>Redirect Url</th>
					  <th>Image</th>
					  <th>New Tab</th>
					  <th>Status</th>
					  <th>Edit</th>
					  <th>Delete</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

