  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>OTP Verification</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / OTP Verification</li>
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
            
			<?php echo form_open_multipart('member/wallet/transferOTPAuth', array('id' => 'admin_profile'),array('method'=>'post')); ?>
			<input type="hidden" class="form-control" autocomplete="off" name="encode_transaction_id" value="{encode_transaction_id}">
            <div class="row">
			
                <div class="col-sm-4">
                <h5>OTP Verification</h5>
                </div>

                <div class="col-sm-8 text-right">
                </div>
              
              	  
				  <div class="col-sm-6">
				  <div class="form-group">
				  <label><b>OTP*</b></label>
				  <input type="password" class="form-control" autocomplete="off" name="otp_code" id="otp_code" placeholder="OTP">
				  <?php echo form_error('otp_code', '<div class="error">', '</div>'); ?>  
				  </div>
				  </div>
				  <div class="col-sm-6"></div>
				  <div class="col-sm-12">
					<button class="btn btn-primary" type="submit">Verify</button>
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




