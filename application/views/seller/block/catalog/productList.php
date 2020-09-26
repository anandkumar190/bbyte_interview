<div class="card shadow mb-4">
              {system_message}               
              {system_info}
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Product List</b></h4>
                </div>

                <div class="col-sm-2">
                <?php echo form_open('',array('id'=>'leadFilterForm')); ?>
                <input type="text" class="form-control" placeholder="Keyword" name="keyword" id="keyword" />
                </div>

                <div class="col-sm-4">
                <button type="button" class="btn btn-success" id="employeSearchBtn">Search</button>
                <a href="{site_url}seller-panel/catalog/productList" class="btn btn-secondary">View All</a>
                <a href="{site_url}seller-panel/catalog/addProduct" class="btn btn-primary">+Add New Product</a>
                </div>
               </div>  
              <?php echo form_close(); ?>
            </div>
			<?php echo form_open('#',array('id'=>'product-list-form')); ?>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="adminProductDataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="check_all" value="1" /></th>
					  <th>ID</th>
					  <th>Thumbnail</th>
					  <th>Name</th>
					  <th>SKU</th>
					  <th>Price</th>
					  <th>Attribute Set</th>
					  <th>Quantity</th>
					  <th>Stock Status</th>
					  <th>Stock</th>
					  <th>Status</th>
					  <th>Approve Status</th>
					  <th>Created</th>
					  <th>Edit</th>
					  <th>Delete</th>
                    </tr>
                  </thead>
				  
                </table>
              </div>
            </div>
			<?php echo form_close(); ?>
          </div>
        </div>

