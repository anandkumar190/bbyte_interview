<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php echo form_open_multipart('admin/store/saveCommision', array('id' => 'admin_profile'),array('method'=>'post')); ?>
	<section class="content-header">
	{system_message}               
  {system_info}
	
		<h1>Commission</h1> 		<br />
		<?php
                        $data = array(
                            'name' => 'btn-create',
                            'value' => 'Save Commission',
                            'class' => 'btn btn-primary'
                        );
                        echo form_submit($data);
                        ?>
						
		
	</section>
	
	<section class="content">
		<div class="row">
		<!-- left column -->
			<div class="col-md-6">
                <div class="box box-success">                    
                    
					 
					<div class="box-body">                                                           
                    	          
					   <table class="table">
						<tr>
							<td><b>Category</b></td>
							<td><b>Commission (%)</b></td>
						</tr>
					   <?php if($categoryList){ ?>
					   <?php foreach($categoryList as $list){ ?>
						<tr>
							<td><?php echo $list['title']; ?></td>
							<td>
								<input type="text" class="form-control" name="commission[<?php echo $list['id'];?>]" value="<?php echo $list['commision'];?>" />
							</td>
						</tr>
					   <?php } ?>
					   <?php } else { ?>
					   <tr>
							<td colspan="2">No Category Found.</td>
						</tr>
					   <?php } ?>
					   </table> 
						             
                    
                </div><!-- /.box -->
            </div> 
		</div>
	</section>
	<?php echo form_close(); ?>     

</div><!-- /.content-wrapper -->
<script>

</script>