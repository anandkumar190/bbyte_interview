<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
<link href="images/favicon.png" rel="icon" />

<title>{meta_title}</title>
<meta name="description" content="{meta_description}">
<meta name="author" content="harnishdesign.net">

<!-- Web Fonts
============================================= -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

<!-- Stylesheet
============================================= -->
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/font-awesome/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/owl.carousel/assets/owl.carousel.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/owl.carousel/assets/owl.theme.default.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/css/stylesheet.css" />

</head>
<body>
<!-- Preloader -->
<div id="preloader"><div data-loader="dual-ring"></div></div><!-- Preloader End -->

<!-- Document Wrapper   
============================================= -->
<div id="main-wrapper">

  <!-- Header
  ============================================= -->
  
  <!-- Content
  ============================================= -->
  <div id="content">
    
    <!-- Page Header
    ============================================= -->
    <section class="page-header page-header-text-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-12 text-center">
          	<a href="{site_url}" title="Cranes Mart"><img src="{site_url}skin/images/logo.png" alt="Cranes Mart" width="25%" /></a>
          </div>
        </div>
      </div>
    </section><!-- Page Header end -->
    <div class="container">
      <div class="row">
        
        <div class="col-md-12 mt-4 mt-md-0">
          {system_message}    
{system_info}
        </div>
	</div>
	</div>
    <div class="container">
      <div id="login-signup-page" class="bg-light shadow-md rounded mx-auto p-4">
        <ul class="nav nav-tabs nav-justified" role="tablist">
          <li class="nav-item"> <a id="login-page-tab" class="nav-link <?php if(set_value('tab') != 2){ ?> active <?php } ?> text-4" data-toggle="tab" href="#loginPage" role="tab" aria-controls="login" aria-selected="true">Login</a> </li>
          <li class="nav-item"> <a id="signup-page-tab" class="nav-link <?php if(set_value('tab') == 2){ ?> active <?php } ?> text-4" data-toggle="tab" href="#signupPage" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a> </li>
        </ul>
        <div class="tab-content pt-4">
          <div class="tab-pane fade <?php if(set_value('tab') != 2){ ?> show active <?php } ?>" id="loginPage" role="tabpanel" aria-labelledby="login-page-tab">
            <?php echo form_open_multipart('seller/loginAuth'); ?>
			  <div class="row">
			  <div class="col-md-3"></div>
			  <div class="col-md-6">
				  <div class="form-group">
					<label for="loginMobile">Mobile or Email ID</label>
					<input type="text" class="form-control" name="username" id="signupEmail" value="<?php echo set_value('username'); ?>" placeholder="Mobile or Email ID">
					<?php echo form_error('username', '<div class="error">', '</div>'); ?>  
				  </div>
				  <div class="form-group">
					<label for="loginPassword">Password</label>
					<input type="password" class="form-control" name="password" id="signupEmail" placeholder="Password">
					<?php echo form_error('password', '<div class="error">', '</div>'); ?>  
				  </div>
				  <button class="btn btn-primary btn-block" type="submit">Login</button>
			  </div>
			  </div>
			  
            <?php echo form_close(); ?>
          </div>
          <div class="tab-pane fade <?php if(set_value('tab') == 2){ ?> show active <?php } ?>" id="signupPage" role="tabpanel" aria-labelledby="signup-page-tab">
            <?php echo form_open_multipart('seller/registerAuth'); ?>
			<input type="hidden" name="tab" value="2" />
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Name*</label>
						<input type="text" class="form-control" name="name" id="signupEmail" value="<?php echo set_value('name'); ?>" placeholder="Name">
						<?php echo form_error('name', '<div class="error">', '</div>'); ?>  
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Email*</label>
						<input type="text" class="form-control" name="email" id="signupEmail" value="<?php echo set_value('email'); ?>" placeholder="Email">
						<?php echo form_error('email', '<div class="error">', '</div>'); ?>  
						
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Mobile*</label>
						<input type="text" class="form-control" name="mobile" id="signupEmail" value="<?php echo set_value('mobile'); ?>" placeholder="Mobile">
						<?php echo form_error('mobile', '<div class="error">', '</div>'); ?>  
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Password*</label>
						<input type="password" class="form-control" name="password" id="signupEmail" placeholder="Password">
						<?php echo form_error('password', '<div class="error">', '</div>'); ?>  
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Firm Name</label>
						<input type="text" class="form-control" name="firm_name" id="signupEmail" value="<?php echo set_value('firm_name'); ?>" placeholder="Firm Name">
						<?php echo form_error('firm_name', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Address*</label>
						<input type="text" class="form-control" name="address" id="signupEmail" value="<?php echo set_value('address'); ?>" placeholder="Address">
						<?php echo form_error('address', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">State*</label>
						<select class="form-control" name="state">
							<option value="">Select State</option>
							<?php if($stateList){ ?>
								<?php foreach($stateList as $list){ ?>
									<option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('state', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Country*</label>
						<select class="form-control" name="country">
							<?php if($countryList){ ?>
								<?php foreach($countryList as $list){ ?>
									<option value="<?php echo $list['id']; ?>" <?php if($list['id'] == 101){ ?> selected="selected" <?php } ?>><?php echo $list['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php echo form_error('country', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Zip Code*</label>
						<input type="text" class="form-control" name="zip_code" id="signupEmail" value="<?php echo set_value('zip_code'); ?>" placeholder="Zip Code">
						<?php echo form_error('zip_code', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">GST No.</label>
						<input type="text" class="form-control" name="gst_no" id="signupEmail" value="<?php echo set_value('gst_no'); ?>" placeholder="GST No.">
						<?php echo form_error('gst_no', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h4>Document</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Address Proof (Aadhar Card/Driving Licence)*</label>
						<input type="file" class="form-control" name="address_proof">
						<?php echo form_error('address_proof', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">PAN Card*</label>
						<input type="file" class="form-control" name="pan_card">
						<?php echo form_error('pan_card', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h4>Account Details</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Account Holder Name*</label>
						<input type="text" class="form-control" name="account_holder_name" id="signupEmail" value="<?php echo set_value('account_holder_name'); ?>" placeholder="Account Holder Name">
						<?php echo form_error('account_holder_name', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Account No.*</label>
						<input type="text" class="form-control" name="account_no" id="signupEmail" value="<?php echo set_value('account_no'); ?>" placeholder="Account No.">
						<?php echo form_error('account_no', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">IFSC Code*</label>
						<input type="text" class="form-control" name="ifsc" id="signupEmail" value="<?php echo set_value('ifsc'); ?>" placeholder="IFSC Code">
						<?php echo form_error('ifsc', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
					<div class="col-sm-6">
					  <div class="form-group">
						<label for="signupEmail">Bank Name*</label>
						<input type="text" class="form-control" name="bank_name" id="signupEmail" value="<?php echo set_value('bank_name'); ?>" placeholder="Bank Name">
						<?php echo form_error('bank_name', '<div class="error">', '</div>'); ?>
					  </div>
					</div>
				</div>
              <button class="btn btn-primary btn-block" type="submit">Signup</button>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
    
  </div><!-- Content end -->
  
  
</div><!-- Document Wrapper end -->

<!-- Back to Top
============================================= -->
<a id="back-to-top" data-toggle="tooltip" title="Back to Top" href="javascript:void(0)"><i class="fa fa-chevron-up"></i></a>



<!-- Script -->
<script src="{site_url}skin/front/vendor/jquery/jquery.min.js"></script>
<script src="{site_url}skin/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{site_url}skin/front/vendor/owl.carousel/owl.carousel.min.js"></script> 
<script src="{site_url}skin/front/js/theme.js"></script> 

</body>
</html>