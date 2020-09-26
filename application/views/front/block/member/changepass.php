<section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Change Password</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}">Home</a></li>
            <li class="active">Change Password</li>
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
          <!-- Change Password
          ============================================= -->
            {system_message}    
            {system_info}
            <div class="row">
              <div class="col-lg-8">
                <h4 class="mb-4">Change Password</h4>
                <?php echo form_open_multipart('member/changepass/changePassword', array('id' => 'admin_profile')); ?>
                <div class="form-group">
                    <label for="existingPassword">Existing Password</label>
                    <input type="password" autocomplete="off" class="form-control" data-bv-field="existingpassword" name="opw" id="opw" placeholder="Existing Password">
                    <?php echo form_error('opw', '<div class="error">', '</div>'); ?> 
                  </div>
                  <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password"  autocomplete="off"  class="form-control" data-bv-field="newpassword" name="npw" id="npw" placeholder="New Password">
                    <?php echo form_error('npw', '<div class="error">', '</div>'); ?>   
                  </div>
                  <div class="form-group">
                    <label for="existingPassword">Confirm Password</label>
                    <input type="password"  autocomplete="off"  class="form-control" data-bv-field="confirmgpassword" name="cpw" id="cpw" placeholder="Confirm Password">
                    <?php echo form_error('cpw', '<div class="error">', '</div>'); ?>
                  </div>
                  <button class="btn btn-primary" type="submit">Update Password</button>
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