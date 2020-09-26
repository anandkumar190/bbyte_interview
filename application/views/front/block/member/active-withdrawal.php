  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Active Withdrawal</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / Active Withdrawal</li>
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
            
            <div class="row">
              <div class="col-lg-8">
                <h4 class="mb-4"><a href="#" name="w1">Active Withdrawal</a></h4>
               <?php echo form_open_multipart('member/wallet/withdrawalAuth', array('id' =>'admin_profile')); ?>
                  <div class="mb-3">
                  </div>
                  <?php $name = explode(' ', $memberDetail['name']); ?>
                  <div class="form-group">
                    <label for="fullName">First Name*</label>
                    <input type="text" value="<?php echo isset($name[0]) ? $name[0] : ''; ?>" class="form-control" data-bv-field="fullName" name="first_name" id="first_name" placeholder="First Name">
                    <?php echo form_error('first_name', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="form-group">
                    <label for="fullName">Last Name*</label>
                    <input type="text" value="<?php echo isset($name[1]) ? $name[1] : ''; ?>" class="form-control" data-bv-field="fullName" name="last_name" id="last_name" placeholder="First Name">
                    <?php echo form_error('last_name', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="form-group">
                    <label for="emailID">Email ID*</label>
                    <input type="text" value="<?php echo $memberDetail['email']; ?>" class="form-control" data-bv-field="emailid" id="email" name="email" placeholder="Email ID">
                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="form-group">
                    <label for="mobileNumber">Mobile Number*</label>
                    <input type="text" value="<?php echo $memberDetail['mobile']; ?>" class="form-control" data-bv-field="mobilenumber" name="mobile" id="mobile" placeholder="Mobile Number">
                    <?php echo form_error('mobile', '<div class="error">', '</div>'); ?>
                  </div>
                  <div class="form-group">
                    <label for="zipcode">PIN Code/Zip Code*</label>
                    <input type="text" value="<?php echo $memberDetail['zip_code']; ?>" class="form-control" data-bv-field="zipcode" name="zipcode" id="zipcode" placeholder="PIN Code/Zip Code">
                    <?php echo form_error('zipcode', '<div class="error">', '</div>'); ?>
                  </div>
                  
                  <button class="btn btn-primary" type="submit">Activate Now</button>
                <?php echo form_close(); ?>
              </div>
              
            </div>
            <!-- Personal Information end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
