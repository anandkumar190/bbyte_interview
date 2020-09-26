<div class="card shadow mb-4">
              {system_message}               
              {system_info}
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Category List</b></h4>
                </div>

                <div class="col-sm-2">
                <?php echo form_open('',array('id'=>'leadFilterForm')); ?>
                <input type="text" class="form-control" placeholder="Keyword" name="keyword" id="keyword" />
                </div>

                <div class="col-sm-4">
                <button type="button" class="btn btn-success" id="employeSearchBtn">Search</button>
                <a href="{site_url}admin/catalog/categoryList" class="btn btn-secondary">View All</a>
                <a href="{site_url}admin/catalog/addCategory" class="btn btn-primary">+Add New Category</a>
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
					  <th>Category</th>
					  <th>Status</th>
					  <th>Edit</th>
					  <th>Delete</th>
                    </tr>
                  </thead>
				  <tbody>
				<?php if($categoryList): 
				$i = 1;
					foreach($categoryList as $list):
					
				?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $list['title']; ?></td>
				  <td><?php if($list['status']) { echo '<font color="green">Active</font>'; } else { echo '<font color="red">Deactive</font>'; } ?></td>
				  <td><a title="edit" class="btn btn-primary btn-sm" href="<?php echo base_url('admin/catalog/editCategory').'/'.$list['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                  <td>
				  <a title="delete" class="btn btn-danger btn-sm" href="<?php echo base_url('admin/catalog/deleteCategory').'/'.$list['id']; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a> </td>
                  
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
					  <th>Category</th>
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

