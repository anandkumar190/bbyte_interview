<div class="content-wrapper">
	<section class="content-header">
		{system_message}	
		{system_info}
	</section>
    <!-- Content Header (Page header) -->
     <section class="content-header">
    <h1>
   Variation Theme
   
   <a href="{site_url}admin/store/addVariation" class="btn btn-primary">+Add New Variation</a>
        
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <!-- left column -->
        <div class="col-xs-12">
          <!-- general form elements -->
            
			<div class="box">
           
            <!-- /.box-header -->
            <div class="box-body">
              <table id="memberDatatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Label</th>
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
				  <td><a title="edit" href="<?php echo base_url('admin/store/editVariation').'/'.$list['id']; ?>"><img src="<?php echo base_url(); ?>resources/icons/pencil.png"/></a></td>
                  <td>
				  <a title="delete" class="del" href="<?php echo base_url('admin/store/deleteVariation').'/'.$list['id']; ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="<?php echo base_url(); ?>resources/icons/delete.png"/></a> </td>
                  
                </tr>
                <?php $i++; endforeach; else :
				?>
				<tr>
                  <td colspan="11">No Record Found</td>
                  
                </tr>
				<?php
				endif; ?>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
            
         
          <!-- /.box -->

          <!-- Form Element sizes -->
         
          <!-- /.box -->

          

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>