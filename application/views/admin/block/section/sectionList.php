<div class="card shadow mb-4">
              {system_message}               
              {system_info}
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Home Sections</b></h4>
                </div>

                <div class="col-sm-2">
                <?php echo form_open('',array('id'=>'leadFilterForm')); ?>
                <input type="text" class="form-control" placeholder="Keyword" name="keyword" id="keyword" />
                </div>

                <div class="col-sm-4">
                <button type="button" class="btn btn-success" id="employeSearchBtn">Search</button>
                <a href="{site_url}admin/section" class="btn btn-secondary">View All</a>
                <a href="{site_url}admin/section/addSection" class="btn btn-primary">+Add New Section</a>
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
					  <th>Section Type</th>
					  <th>Section Name</th>
					  <th>Section Position</th>
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
                  <td><?php if($list['section_type_id']==1) { echo "Product Section"; } elseif($list['section_type_id']==2) { echo "2-Banner Section"; } else{ echo "3-Banner Section";}  ?></td>
                  <td><?php echo $list['section_name']; ?></td>
                  <td><?php echo $list['order_no']; ?></td>
                  
                 <td><?php echo ($list['status'] == 1) ? '<font color="green">Active</font>' : '<font color="red">Deactive</font>'; ?></td>
				  <td><a title="edit" class="btn btn-primary btn-sm" href="<?php echo base_url('admin/section/editSection').'/'.$list['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                  <td>
				  <a title="delete" class="btn btn-danger btn-sm" href="<?php echo base_url('admin/section/deleteSection').'/'.$list['id']; ?>" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a> </td>
                  
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
					  <th>Section Type</th>
					  <th>Section Name</th>
					  <th>Section Position</th>
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

