<section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Topup Wallet</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}">Home</a></li>
            <li class="active">Topup Wallet</li>
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
          <!-- Change Password
          ============================================= -->
            
            <div class="row">
              <div class="col-lg-8">
                <h4 class="mb-4">Topup Wallet</h4>
                <?php echo form_open_multipart('member/wallet/topupAuth', array('id' => 'admin_profile','target'=>'_blank')); ?>
                <div class="form-group">
                    <label for="existingPassword">Amount</label>
                    <input type="text" autocomplete="off" class="form-control" name="amount" id="amount" placeholder="Enter Amount">
                    <?php echo form_error('amount', '<div class="error">', '</div>'); ?> 
                  </div>
                  <button class="btn btn-primary" type="submit">Proceed to Payment</button>
               <?php echo form_close(); ?>
              </div>
              <div class="col-lg-4 mt-4 mt-lg-0 ">
                <div class="bg-light-2 p-3">
                  <p class="mb-2">We value your Privacy.</p>
                  <p class="text-1 mb-0">We will not sell or distribute your contact information. Read our <a href="#">Privacy Policy</a>.</p>
                  <hr>
                  <p class="mb-2">Billing Enquiries</p>
                  <p class="text-1 mb-0">Do not hesitate to reach our <a href="#">support team</a> if you have any queries.</p>
                </div>
              </div>
            </div>
            <!-- Change Password end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end -->