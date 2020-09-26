<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php echo form_open_multipart('admin/store/updateVariation', array('id' => 'admin_profile'),array('method'=>'post')); ?>
	<input type="hidden" value="<?php echo count($variationOption); ?>" id="totalDropdownRecord" />
	<input type="hidden" value="{variationID}" name="variationID" id="variationID" />
	<section class="content-header">
		{system_message}               
  {system_info}
		<h1>Update Variation</h1><br />
<?php
                        $data = array(
                            'name' => 'btn-create',
                            'value' => 'Update Variation',
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
							<option value="1" <?php if($variationData['status'] == 1){ ?> selected="selected" <?php } ?>>Enable</option>
							<option value="0" <?php if($variationData['status'] == 0){ ?> selected="selected" <?php } ?>>Disable</option>
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
							'value' => $variationData['title']
							
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
							<?php if($variationOption){ ?>
								<?php $i = 1; foreach($variationOption as $val){ ?>
								<tr id="dropdown_tr_<?php echo $i; ?>">
									<td>
										<input type="hidden" name="option_id[<?php echo $i; ?>]" value="<?php echo $val['id']; ?>" />
										<input type="text" value="<?php echo $val['label']; ?>" class="form-control" name="variation_lable[<?php echo $i; ?>]" />
									</td>
									<td>
										<input type="checkbox" <?php if($val['is_color'] == 1){ ?> checked="checked" <?php } ?> name="is_color[<?php echo $i; ?>]" value="1" />
									</td>
									<td>
										<i class="fa fa-trash" onclick="deleteDropdownRow(<?php echo $i; ?>)" aria-hidden="true"></i>
									</td>
								</tr>
								<?php $i++; } ?>
							<?php } ?>
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