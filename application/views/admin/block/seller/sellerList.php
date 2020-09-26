<div class="card shadow mb-4">
              {system_message}               
              {system_info}
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Sellers</b></h4>
                </div>

                <div class="col-sm-2">
                <?php echo form_open('',array('id'=>'leadFilterForm')); ?>
                <input type="text" class="form-control" placeholder="Keyword" name="keyword" id="keyword" />
                </div>

                <div class="col-sm-4">
                <button type="button" class="btn btn-success" id="employeSearchBtn">Search</button>
                <a href="{site_url}admin/seller/sellerList" class="btn btn-secondary">View All</a>
                </div>
               </div>  
              <?php echo form_close(); ?>
            </div>
			<?php echo form_open('#',array('id'=>'seller-list-form')); ?>
            <div class="card-body">
			  <div class="row" style="margin-left:0px; margin-right:0px;">
				  <div class="col-md-2" style="margin:0; padding:0;">
				<select class="form-control" name="actionID" id="selAction" style="width:100%; margin-top:10px;">
					<option value="0">Action</option>
					<option value="1">Active</option>
					<option value="2">Deactive</option>
					<option value="3">Verified</option>
					<option value="4">Rejected</option>
					<option value="5">Delete</option>
				</select>
				</div>
				<div class="col-md-2" style="margin-top:10px;">
				<button type="button" class="btn btn-primary" id="sellerApplyActionBtn">Apply Action</button>
				</div>
				<div class="col-md-6" style="margin-top:10px;">
					<div id="action-loader"></div>
				</div>
			
			</div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="sellerDataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="check_all" value="1" /></th>
                      <th>SellerID</th>
                      <th>Name</th>
                      <th>Personal Info</th>
                      <th>Account Info</th>
                      <th>Document</th>
                      <th>Created</th>
                      <th>Status</th>
                      <th>Verified</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
			<?php echo form_close(); ?>
          </div>
        </div>

