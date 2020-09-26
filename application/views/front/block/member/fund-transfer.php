  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Fund Transfer</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / Fund Transfer</li>
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
    	{system_message}    
            {system_info}
      <?php $this->load->view('front/layout/wallet-column' , true); ?>
      <div class="row pt-md-3 mt-md-5">
        <?php $this->load->view('front/layout/member-left-bar' , true); ?>
        <div class="col-lg-9">
          <div class="bg-light shadow-md rounded p-4"> 
            <!-- Personal Information
          ============================================= -->
            
			<?php echo form_open_multipart('member/wallet/fundTransferAuth', array('id' => 'admin_profile'),array('method'=>'post')); ?>
			<input type="hidden" id="user-wallet-balance" vlaue="<?php echo $accountDetail['wallet_balance']; ?>" />
      <input type="hidden" id="fund-charge" value="{fund_transfer_charge}" />
			<div class="row">
			<div class="col-sm-12">
			
			  <div class="alert alert-warning alert-dismissable">You can transfer maximum INR 5000 per day.</div>
			  <div class="alert alert-warning alert-dismissable">Admin Charge will be {fund_transfer_charge}% for each transaction.</div>
                </div>
                
				
                <div class="col-sm-4">
                <h5>Fund Transfer</h5>
                </div>

                <div class="col-sm-8 text-right">
                <h5>Available Balance - INR <?php echo number_format($accountDetail['wallet_balance'],2); ?></h5>
                </div>
              
              	  <div class="col-sm-6">
				  <div class="form-group">
				  <label><b>Transfer To*</b></label>
				  <select class="form-control" name="transfer_to">
				  	<option value="">Select Benificary</option>
				  	<?php if($benificaryList){ ?>
				  		<?php foreach($benificaryList as $list){ ?>
				  			<option value="<?php echo $list['encode_ban_id']; ?>"><?php echo $list['account_holder_name'].' ('.$list['account_no'].')'; ?></option>
				  		<?php } ?>
				  	<?php } ?>
				  </select>
				  <?php echo form_error('transfer_to', '<div class="error">', '</div>'); ?>  
				  </div>
				  </div>
				  <div class="col-sm-6"></div>
				  <div class="col-sm-6">
				  <div class="form-group">
				  <label><b>Amount (INR)*</b></label>
				  <input type="text" class="form-control" autocomplete="off" name="amount" id="fund-transfer-amount" placeholder="Amount">
				  <?php echo form_error('amount', '<div class="error">', '</div>'); ?>  
				  </div>
				  </div>
				  <div class="col-sm-6"></div>
				  <div class="col-sm-6">
          <div class="form-group">
          <label><b>Total Wallet Deducation</b></label>
          <input type="text" readonly="readonly" class="form-control" autocomplete="off" id="total_wallet_deducation" placeholder="0">
          </div>
          </div>
          <div class="col-sm-6"></div>
				  <div class="col-sm-12">
					<button class="btn btn-primary" type="submit">Transfer</button>
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




