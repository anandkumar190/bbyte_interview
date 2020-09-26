<div class="select_section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					{system_message}
					{system_warning}
				</div>
			</div>
		</div>
		<?php if($addressList){ ?>
    	<div class="container">
        	<div class="row">
            	<div class="col-sm-12">
                	<div class="select_div">
                    	<h3>Select a shopping address</h3>
                        <p>Is the address you'd like to use displayed below? If so, click the corresponding "Deliver to this address" button. Or you can enter a new shipping address. </p>
                    </div>
                </div>
            </div>
            <div class="row content_row">
            	<div class="col-sm-12">
					<div class="row">
						<?php foreach($addressList as $aList){ ?>
						<div class="col-sm-4" id="checkout-add-block-<?php echo $aList['id']; ?>">
							<div class="content_new_div">
								<h4><?php echo $aList['name']; ?></h4>
								<p><?php echo $aList['address_1']; ?>,<br /><?php echo $aList['address_2']; ?><br /><?php echo $aList['city']; ?>,<?php echo $aList['state_name']; ?>,<?php echo $aList['country_name']; ?> - <?php echo $aList['zip_code']; ?><br />
                                Phone: <?php echo $aList['phone_number']; ?></p>
										<div class="col-sm-12" style="padding-left:0px;">
											<a href="{site_url}checkout/review/<?php echo $aList['id']; ?>"><button type="button" class="btn btn-success btn-block checkout-btn" value="deliver">Deliver to this address</button></a>
										</div>
										<div class="col-sm-12" style="padding-left:0px;">
                                		<button type="button" onclick="openUpdateAddModal(<?php echo $aList['id']; ?>)" class="btn_edit" value="edit">Edit</button>
                                		<button type="button" onclick="deleteCheckoutAdd(<?php echo $aList['id']; ?>)" class="btn_edit" value="delete">Delete</button>
                                    </div>
							</div>
						</div>
						<?php } ?>
						
					</div>
                </div>
            </div>
        </div>
		<?php } ?>		
      </div>
<div class="form_section">
      	<div class="container">
        	<div class="row">
            	<div class="col-sm-12 text-center">
                	<div class="form_content">
						<br /><br />
                    	<h3>Add a new address</h3>
                        <p>Be sure to click "Deliver to this address" when done.</p>
                    </div>
                </div>
            </div>
			<?php echo form_open('checkout/addAuth'); ?>
            <div class="row" style="margin-top:3%;">
				
            	<div class="col-sm-12">
					<div class="row">
                	<div class="col-sm-6">
                    
						<label for="name">Full Name : </label>
                        <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo set_value('name'); ?>">                    
						<?php echo form_error('name', '<div class="error">', '</div>'); ?>

                        <label for="address1"> Address line 1 :  </label>
                        <input type="text" name="address_line_1" class="form-control" placeholder="Street address, P.O. box, company name, c/o " value="<?php echo set_value('address_line_1'); ?>">
						<?php echo form_error('address_line_1', '<div class="error">', '</div>'); ?>

                        <label for="city"> City :  </label>
                        <input type="text" name="city" class="form-control" placeholder="City Name" value="<?php echo set_value('city'); ?>">
						<?php echo form_error('city', '<div class="error">', '</div>'); ?>

                        <label for="zip"> ZIP/Postal Code : </label>
                        <input type="text" name="postal_code" class="form-control" placeholder="Zip/Postal Code" value="<?php echo set_value('postal_code'); ?>">
						<?php echo form_error('postal_code', '<div class="error">', '</div>'); ?>

                    
                    </div>
                	<div class="col-sm-6">
                   	
						<label for="name">Phone Number : </label>
                        <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" value="<?php echo set_value('phone_number'); ?>">
						<?php echo form_error('phone_number', '<div class="error">', '</div>'); ?>

                        <label for="address2"> Address line 2 :  </label>
                        <input type="text" name="address_line_2" class="form-control" placeholder="Apartment, suite, unit, building, floor, etc." value="<?php echo set_value('address_line_2'); ?>">
						<?php echo form_error('address_line_2', '<div class="error">', '</div>'); ?>

                        <label for="state"> State/Province/Region :  </label>
                        <select name="state" class="form-control">
                            <option value="">Select State Name</option>
							<?php if($stateList){ ?>
								<?php foreach($stateList as $cList){ ?>
									<option value="<?php echo $cList['id']; ?>"><?php echo $cList['name']; ?></option>
								<?php } ?>
							<?php } ?>
                           
                        </select>
						<?php echo form_error('state', '<div class="error">', '</div>'); ?>

                        <label for="country"> Country/Region : </label>
                        <select name="country" class="form-control">
                            <option value="">Select Country Name</option>
							<?php if($countryList){ ?>
								<?php foreach($countryList as $cList){ ?>
									<option value="<?php echo $cList['id']; ?>" <?php if($cList['id'] == 101){ ?> selected="selected" <?php } ?>><?php echo $cList['name']; ?></option>
								<?php } ?>
							<?php } ?>
                           
                        </select>
						<?php echo form_error('country', '<div class="error">', '</div>'); ?>

	                
                    </div>
					</div>
					<div class="row">
						<div class="col-sm-4 pull-right">
							<br />
							<button type="submit" class="btn btn-success btn-block checkout-btn" value="deliver">Deliver to this address</button>
						</div>
					</div>
                </div>
				
            </div>
			<?php echo form_close(); ?>
        </div>
      </div>
<!-- Modal -->
<div id="checkoutAddModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	  <?php echo form_open('#',array('id'=>'checkout-add-form')); ?>
	  <input type="hidden" name="recordID" id="recordID" value="0" />
      <div class="modal-header">
		<div class="col-sm-6">
			<h4 class="modal-title">Update Address</h4>
			</div>
		  <div class="col-sm-6 text-right">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>
        
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Full Name :</label>                                    
						<input type="text" name="name" class="form-control" id="checkout-add-name-input" value="" />
					</div>
					<div class="form-group">
						<label>Address line 1 :</label>                                    
						<input type="text" name="address_line_1" class="form-control" id="checkout-add-address-1-input" value="" />
					</div>
					<div class="form-group">
						<label>City :</label>                                    
						<input type="text" name="city" class="form-control" id="checkout-add-city-input" value="" />
					</div>
					<div class="form-group">
						<label>ZIP/Postal Code :</label>                                    
						<input type="text" name="postal_code" class="form-control" id="checkout-add-postal-code-input" value="" />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Phone Number :</label>                                    
						<input type="text" name="phone_number" class="form-control" id="checkout-add-phone-input" value="" />
					</div>
					<div class="form-group">
						<label>Address line 2 :</label>                                    
						<input type="text" name="address_line_2" class="form-control" id="checkout-add-address-2-input" value="" />
					</div>
					<div class="form-group">
						<label>State/Province/Region :</label>                                    
						<select name="state" class="form-control" id="checkout-add-state-input">
                            <option value="">Select State Name</option>
							<?php if($stateList){ ?>
								<?php foreach($stateList as $cList){ ?>
									<option value="<?php echo $cList['id']; ?>"><?php echo $cList['name']; ?></option>
								<?php } ?>
							<?php } ?>
                           
                        </select>
					</div>
					<div class="form-group">
						<label>Country/Region :</label>                                    
						<select name="country" class="form-control">
                            <option value="">Select Country Name</option>
							<?php if($countryList){ ?>
								<?php foreach($countryList as $cList){ ?>
									<option value="<?php echo $cList['id']; ?>" <?php if($cList['id'] == 101){ ?> selected="selected" <?php } ?>><?php echo $cList['name']; ?></option>
								<?php } ?>
							<?php } ?>
                           
                        </select>
					</div>
				</div>
				<div class="col-sm-12" id="checkout-update-add-loader">
				</div>
			</div>
			</div>
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" id="checkout-update-add-btn" class="btn btn-warning">Update</button>
      </div>
	  <?php echo form_close(); ?>
    </div>

  </div>
</div>	 	  