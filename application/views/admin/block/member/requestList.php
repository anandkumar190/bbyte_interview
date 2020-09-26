<?php echo form_open_multipart('member/token/requestTokenAuth', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
<div class="card shadow ">
{system_message}               
              {system_info}
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Fund Request List</b></h4>
                </div>
                
                <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" type="button" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            
              
			<div class="table-responsive">
                <table class="table table-bordered table-striped" id="fundRequestDataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Member</th>
                      <th>Request ID</th>
                      <th>Amount</th>
                      <th>Service Amount ({service_tax_percentage}%)</th>
                      <th>Transfer Amount</th>
                      <th>Generation</th>
                      <th>Status</th>
                      <th>Action</th>
                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Member</th>
                      <th>Request ID</th>
                      <th>Amount</th>
                      <th>Service Amount ({service_tax_percentage}%)</th>
                      <th>Transfer Amount</th>
                      <th>Generation</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  </tbody>
                </table>
              </div>
              
          </div>
        </div>
           
 <?php echo form_close(); ?>     
    </div>




