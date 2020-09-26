    <div class="page-header page-header-text-light bg-secondary">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h1>Create Account</h1>
          </div>
          <div class="col-md-4">
            <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
              <li><a href="{site_url}home">Home</a> / Create Account</li>
            </ul>
          </div>
        </div>
      </div>
    </div><!-- Secondary Navigation end -->
    
  <!-- Content
  ============================================= -->
  <div id="content">
    <div class="container">
      <div class="row">
        
        <div class="col-md-3 mt-4 mt-md-0">
          
        </div>
		<div class="col-md-6 mt-4 mt-md-0">
		  {system_message}    
{system_info}
          <div class="bg-light shadow-md rounded p-4">
            <h2 class="text-6">Create New Account</h2>
            <?php echo form_open('register/userAuth'); ?>
            <input type="hidden" name="is_referal_link" value="<?php echo ($referral_id) ? 1 : 0; ?>">
              <div class="form-group">
                <input type="text" class="form-control" name="name" value="<?php echo set_value('name'); ?>" placeholder="Name">
				<?php echo form_error('name', '<div class="error">', '</div>'); ?>  
              </div>

              <div class="form-group">
                <input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email ID">
				<?php echo form_error('email', '<div class="error">', '</div>'); ?>  
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="mobile" value="<?php echo set_value('mobile'); ?>" placeholder="Mobile Number">
				<?php echo form_error('mobile', '<div class="error">', '</div>'); ?>  
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
				<?php echo form_error('password', '<div class="error">', '</div>'); ?>  
              </div>
			  <div class="form-group">
                <input type="text" class="form-control" maxlength="10" name="referral_id" value="<?php echo ($referral_id) ? $referral_id : set_value('referral_id'); ?>" placeholder="Referral ID">
                <?php echo form_error('referral_id', '<div class="error">', '</div>'); ?>  
				
              </div>
            
            <button class="btn btn-primary">Signup</button>
			<div class="row mb-4">
                <div class="col-sm text-right"> <a class="justify-content-end" href="{site_url}login">Already Member ?</a> </div>
              </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div><!-- Content end -->
