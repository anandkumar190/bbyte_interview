<div class="card shadow mb-4">
              {system_message}               
              {system_info}
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-4">
                <h4><b>Order History</b></h4>
                </div>

                <div class="col-sm-2">
                <?php echo form_open('',array('id'=>'orderFilterForm')); ?>
                <select class="form-control" name="customer_id" id="customer_id">
						<option value="0">Select Customer</option>
						<?php if($customerList){ ?>
							<?php foreach($customerList as $list){ ?>
								<option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option>
							<?php } ?>
						<?php } ?>
						
						
					</select>
                </div>


                <div class="col-sm-2">
                <select class="form-control" name="order_status" id="order_status">
						<option value="0">Select Status</option>
						<option value="1">Open</option>
						<option value="2">Processing</option>
						<option value="3">Dispatched</option>
						<option value="4">Cancelled</option>
						<option value="5">Delivered</option>
					</select>	
                </div>


                <div class="col-sm-2">
                <input type="textbox" class="form-control" placeholder="Keyword" name="keyword" id="keyword" />	
                </div>


                <div class="col-sm-2">
                <button type="button" class="btn btn-primary" id="orderFilterBtn">Search</button>
					<a href="{site_url}admin/order" class="btn btn-primary">View All</a>
                </div>
               

               </div>  
              <?php echo form_close(); ?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="adminOrderDataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>	
                  <th>ID</th>
				  <th>Customer</th>
                  <th>Address</th>
                  <th>Item Detail</th>
                  <th>Order Status</th>
                  <th>Created</th>
                  <th>Delete</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>	
                  <th>ID</th>
				  <th>Customer</th>
                  <th>Address</th>
                  <th>Item Detail</th>
                  <th>Order Status</th>
                  <th>Created</th>
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








