<div class="card shadow mb-4">
              {system_message}               
              {system_info}
            <div class="card-header py-3">
              <?php echo form_open('#',array('id'=>'leadFilterForm')); ?>
              <div class="row">
                <div class="col-sm-3">
                <h4><b>Member Investment</b></h4>
                </div>

                <div class="col-sm-2">
                
                <input type="text" class="form-control" placeholder="Keyword" name="keyword" id="keyword" />
                </div>
                <div class="col-sm-2">
                
                <select class="form-control" name="package_id" id="package_id">
                  <option value="0">Select Package</option>
                  <?php if($packageList){ ?>
                    <?php foreach($packageList as $list){ ?>
                      <option value="<?php echo $list['id']; ?>"><?php echo $list['package_name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>

                </div>

                <div class="col-sm-5">
                <button type="button" class="btn btn-success" id="investmentSearchBtn">Search</button>
                <a href="{site_url}admin/member/investmentList" class="btn btn-secondary">View All</a>
                <a href="{site_url}admin/member/addMemberPackage" class="btn btn-primary">+Add Member Package</a>
                </div>
               </div>  
              <?php echo form_close(); ?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="investmentDataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>MemberID</th>
                      <th>Name</th>
                      <th>Package</th>
                      <th>Amount</th>
                      <th>Purchase Date</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>MemberID</th>
                      <th>Name</th>
                      <th>Package</th>
                      <th>Amount</th>
                      <th>Purchase Date</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

