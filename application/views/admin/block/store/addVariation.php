<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php echo form_open_multipart('admin/store/saveVariation', array('id' => 'admin_profile'),array('method'=>'post')); ?>
	<input type="hidden" value="0" id="totalDropdownRecord" />
	<section class="content-header">
		{system_message}               
  {system_info}
		<h1>Add New Variation</h1><br />
<?php
                        $data = array(
                            'name' => 'btn-create',
                            'value' => 'Save Variation',
                            'class' => 'btn btn-primary'
                        );
                        echo form_submit($data);
                        ?>
						<a href="{site_url}admin/store/variationList" class="btn btn-warning">Back to Variation List</a>	 		
		
	</section>
	
	<section class="content">
		<div class="row">
		<!-- left column -->
			<div class="col-md-6">
                <div class="box box-success">                    
                    
					 
					<div class="box-body">                                                           
                    	          
					   <div class="form-group">
                        <label>Status</label>                                    
                        <select id="select01" class="form-control" name="status">
							<option value="1">Enable</option>
							<option value="0">Disable</option>
						  </select>
                       </div>
					   <div class="form-group">
                        <label>Label*</label>                                    
                        <?php
                        $data = array('name' => 'label',
                            'id' => 'label',
                            'class' => 'form-control input-sm',
                            'autocomplete' => 'off',
                            'placeholder' => 'Label',
							
                        );
                        echo form_input($data);
                        ?>   						
                        <?php echo form_error('label', '<div class="error">', '</div>'); ?>
                       </div>
					   
					   <div class="form-group" id="dropdown-block">
                        <label>Manage Options</label>                                    
                        <table class="table" id="dropdown-table">
							<tr>
								<td><b>Label</b></td>
								<td><b>Is Color</b></td>
								<td></td>
							</tr>
						</table>
						<button type="button" class="btn btn-primary" id="addMoreVariationBtn">Add Option</button>
                       </div>
					    
                        
						                    </div><!-- /.box-body -->
                                      
                    
                </div><!-- /.box -->
            </div> 
			
		</div>
	</section>
<?php echo form_close(); ?>     
</div><!-- /.content-wrapper -->
<script>

</script>