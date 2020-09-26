    <div class="page-header page-header-text-light bg-secondary">
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
            <h2 class="text-6">OTP Verification</h2>
            <?php echo form_open('forgot/userOTPAuthenticate'); ?>
			<input type="hidden" name="encode_otp_code" value="{encode_otp_code}" />
              <div class="form-group">
                <input class="form-control" placeholder="OTP Code" type="text" autocomplete="off" name="otp_code">
				<?php echo form_error('otp_code', '<div class="error">', '</div>'); ?>  
              </div>

            <button class="btn btn-primary">Verify</button>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div><!-- Content end -->
