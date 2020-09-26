  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Fund Request</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / Fund Request</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Header end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <div class="container">
      <?php $this->load->view('front/layout/wallet-column' , true); ?>
      <div class="row pt-md-3 mt-md-5">
        <?php $this->load->view('front/layout/member-left-bar' , true); ?>
        <div class="col-lg-9">
          <div class="bg-light shadow-md rounded p-4"> 
            <!-- Personal Information
          ============================================= -->
            {system_message}    
            {system_info}
			<?php echo form_open_multipart('member/profile/requestAuth', array('id' => 'admin_profile'),array('method'=>'post')); ?>
			<input type="hidden" class="form-control" autocomplete="off" id="service_tax_percentage" value="{service_tax_percentage}">
            <div class="row">
			<div class="col-sm-12">
				<?php if($kyc_status != 3){ ?>
			  <div class="alert alert-danger alert-dismissable">Sorry ! You cannot request fund, your KYC is not completed or approved. Please Update Your KYC <a href="{site_url}member/withdraw/kyc">Click Here</a></div>
			  <?php } ?>
			  <div class="alert alert-warning alert-dismissable">Minimum INR 500 Fund Request Required.</div>
                </div>
				
                <div class="col-sm-4">
                <h5>Fund Request</h5>
                </div>

                <div class="col-sm-8 text-right">
                <h5>Available Balance - INR <?php echo number_format($accountDetail['wallet_balance'],2); ?></h5>
                </div>
              
              <div class="col-sm-3">
				  <div class="form-group">
				  <label><b>Amount (INR)*</b></label>
				  <input type="text" class="form-control" autocomplete="off" name="amount" id="transfer_amount" placeholder="Amount">
				  <?php echo form_error('amount', '<div class="error">', '</div>'); ?>  
				  </div>
				  </div>
				 <div class="col-sm-3">
				  <div class="form-group">
				  <label><b>Service Tax ({service_tax_percentage}%)</b></label>
				  <input type="text" readonly="readonly" class="form-control" id="service_tax" value="0">
				  
				  </div>
				  </div>
				  <div class="col-sm-3">
				  <div class="form-group">
				  <label><b>Wallet Transfer Amount</b></label>
				  <input type="text" readonly="readonly" class="form-control" id="wallet_transfer_amount" value="0">
				  
				  </div>
				  </div>
				<div class="col-sm-12">
					<button class="btn btn-primary" type="submit">Submit</button>
				  </div>
				   <div class="col-sm-12">
				   <br />
                <h5>Fund Request List</h5>
                </div>
			   
				  
				  <div class="col-sm-12">
					<div class="table-responsive-md">
					<table class="table table-hover border">
					  <thead class="thead-light">
						<tr>
						  <th>#</th>
						  <th>Request ID</th>
						  <th>Request Amount</th>
						  <th>Service Amount({service_tax_percentage}%)</th>
						  <th>Transfer Amount</th>
						  <th>Generation</th>
						  <th>Status</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($requestList){
								$i=1;
						  foreach($requestList as $list){
						 ?>
						<tr>
						  <td class="align-middle"><?php echo $i; ?></td>
						  <td class="align-middle"><?php echo $list['request_id']; ?></td>
						  <td class="align-middle"><?php echo 'INR '.number_format($list['request_amount'],2); ?></td>
						  <td class="align-middle"><?php echo 'INR '.number_format($list['service_amount'],2); ?></td>
						  <td class="align-middle"><?php echo 'INR '.number_format($list['transfer_amount'],2); ?></td>
						  <td class="align-middle"><?php echo date('d-m-Y',strtotime($list['created'])); ?></td>
						  <td class="align-middle">
							<?php 
							if($list['status'] == 1) {
								echo '<font color="black">Pending</font>';
							}
							elseif($list['status'] == 2) {
								echo '<font color="green">Approved</font>';
							}
							else{
								echo '<font color="red">Rejected</font>';
							}
							
								?>
						  </td>
						  
						  </tr>
					  <?php $i++; }}else{  ?>  
					  <tr>
						<td colspan="6" class="align-middle text-center">No Record Found</td>
					  </tr>
					  <?php } ?>
					  </tbody>
					</table>
				  </div>
				  </div>
			  
              </div>
			  
			  <?php echo form_close(); ?>
            <!-- Personal Information end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 




