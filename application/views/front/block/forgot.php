    <div class="page-header page-header-text-light bg-secondary">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h1>Forgot Password</h1>
          </div>
          <div class="col-md-4">
            <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
              <li><a href="{site_url}home">Home</a> / Forgot Password</li>
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
            <h2 class="text-6">Forgot Password</h2>
            <?php echo form_open('forgot/userAuth'); ?>
			<input type="hidden" value="{redirect}" name="redirect" />
              <div class="form-group">
                <input type="text" class="form-control" name="username" id="username" placeholder="UserID / Mobile / EmailID">
				<?php echo form_error('username', '<div class="error">', '</div>'); ?>  
              </div>
			  
            <button class="btn btn-primary">Submit</button>
			<div class="row mb-4">
                
				<div class="col-sm text-right"> <a class="justify-content-end" href="{site_url}login">Already Member ?</a> </div>
              </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div><!-- Content end -->
