  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>KYC</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / KYC</li>
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
			<?php echo form_open_multipart('member/profile/kycAuth', array('id' => 'admin_profile'),array('method'=>'post')); ?>
            <div class="row">
			<div class="col-sm-12 text-right">
				<?php if($get_kyc_status['id'] == 1){ ?>
                <h4><b>KYC Status - </b><?php echo $get_kyc_status['title']; ?></h4>
				<?php } elseif($get_kyc_status['id'] == 2){ ?>
                <h4><b>KYC Status - </b><font color="orange"><?php echo $get_kyc_status['title']; ?></font></h4>
				<?php } elseif($get_kyc_status['id'] == 3){ ?>
                <h4><b>KYC Status - </b><font color="green"><?php echo $get_kyc_status['title']; ?></font></h4>
				<?php } elseif($get_kyc_status['id'] == 4){ ?>
                <h4><b>KYC Status - </b><font color="red"><?php echo $get_kyc_status['title']; ?></font></h4>
				<?php } ?>
                </div>
				<div class="col-sm-12">
				<h5>Account Detail</h5>
				</div>
              <div class="col-sm-6">
              <div class="form-group">
              <label><b>Account Holder Name*</b></label>
              <input type="text" class="form-control" name="account_name" value="<?php echo isset($get_kyc_detail['account_holder_name']) ? $get_kyc_detail['account_holder_name'] : set_value('account_name'); ?>" id="account_name" placeholder="Account Holder Name">
              <?php echo form_error('account_name', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
			  <div class="col-sm-6">
                <div class="form-group">
              <label><b>Account No.*</b></label>
              <input type="text" class="form-control" name="account_number" value="<?php echo isset($get_kyc_detail['account_number']) ? $get_kyc_detail['account_number'] : set_value('account_number'); ?>" id="account_number" placeholder="Account No.">
              <?php echo form_error('account_number', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
			  <div class="col-sm-12">
                <p><b>( Account Holder Name should be same as on PAN CARD. )</b></p>
              </div>
			  <div class="col-sm-6">
                <div class="form-group">
              <label><b>IFSC*</b></label>
              <input type="text" class="form-control" name="ifsc" value="<?php echo isset($get_kyc_detail['ifsc']) ? $get_kyc_detail['ifsc'] : set_value('ifsc'); ?>" id="ifsc" placeholder="IFSC">
              <?php echo form_error('ifsc', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
			  <div class="col-sm-6">
                <div class="form-group">
              <label><b>Bank Name*</b></label>
              <input type="text" class="form-control" name="bank_name" value="<?php echo isset($get_kyc_detail['bank_name']) ? $get_kyc_detail['bank_name'] : set_value('bank_name'); ?>" id="bank_name" placeholder="Bank Name">
              <?php echo form_error('bank_name', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
			  
              </div>
			  <hr />
			  <div class="row">
				<div class="col-sm-12">
				<h5>Document</h5>
				</div>
              
			  <div class="col-sm-6">
                <div class="form-group">
              <label><b>Aadhar Front Image*</b></label>
              <input type="file" name="kyc_front_image" />
              <?php echo form_error('kyc_front_image', '<div class="error">', '</div>'); ?>  <br />
			  <p><b>Note:</b> Image size should be 2MB and only .jpg,.png format allowed.</p>
			  <?php if(isset($get_kyc_detail['front_document']) && $get_kyc_detail['front_document']){ ?>
			  <img src="<?php echo base_url($get_kyc_detail['front_document']); ?>" width="100" /> <br />
			  <a href="<?php echo base_url($get_kyc_detail['front_document']); ?>" target="_blank">View Document</a>
			  <?php } ?>
              </div>
              </div>
			  <div class="col-sm-6">
                <div class="form-group">
              <label><b>Aadhar Back Image*</b></label>
              <input type="file" name="kyc_back_image" />
              <?php echo form_error('kyc_back_image', '<div class="error">', '</div>'); ?>    <br />
			  <p><b>Note:</b> Image size should be 2MB and only .jpg,.png format allowed.</p>
			  <?php if(isset($get_kyc_detail['back_document']) && $get_kyc_detail['back_document']){ ?>
			  <img src="<?php echo base_url($get_kyc_detail['back_document']); ?>" width="100" /> <br />
			  <a href="<?php echo base_url($get_kyc_detail['back_document']); ?>" target="_blank">View Document</a>
			  <?php } ?>
              </div>
              </div>
			   <div class="col-sm-6">
                <div class="form-group">
              <label><b>PAN CARD Image*</b></label>
              <input type="file" name="pancard_image" />
              <?php echo form_error('pancard_image', '<div class="error">', '</div>'); ?>  <br />
			  <p><b>Note:</b> Image size should be 2MB and only .jpg,.png format allowed.</p>
			  <?php if(isset($get_kyc_detail['pancard_document']) && $get_kyc_detail['pancard_document']){ ?>
			  <img src="<?php echo base_url($get_kyc_detail['pancard_document']); ?>" width="100" /> <br />
			  <a href="<?php echo base_url($get_kyc_detail['pancard_document']); ?>" target="_blank">View Document</a>
			  <?php } ?>
              </div>
              </div>
				  <?php if($get_kyc_status['id'] == 1 || $get_kyc_status['id'] == 4){ ?>
  				  <div class="col-sm-12">
  					<button class="btn btn-primary" type="submit">Submit</button>
  				  </div>
            <?php } ?>
              </div>
			  <?php echo form_close(); ?>
            <!-- Personal Information end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
