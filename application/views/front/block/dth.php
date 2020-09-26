    <section class="container">
      <div class="bg-light shadow-md rounded p-4">
        <div class="row">
        
          <!-- DTH Recharge
          ============================================= -->
          <div class="col-lg-4 mb-4 mb-lg-0">
		  {system_message}    
            {system_info}
            <h2 class="text-4 mb-3">DTH Recharge</h2>
            <?php echo form_open_multipart('dth/proceedRecharge', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <div class="form-group">
                <select class="custom-select" name="operator" id="operator">
                  <option value="">Select Your Operator*</option>
                 <?php
                 if($operator){
                 	foreach($operator as $list){
                 ?>	 
                 <option value="<?php echo $list['operator_code']; ?>"><?php echo $list['operator_name']; ?></option>
             	<?php }} ?>
                  </select>

                <?php echo form_error('operator', '<div class="error">', '</div>'); ?>  
                
              </div>

              <div class="form-group">
                <select class="custom-select" name="circle" id="circle">
                  <option value="">Select Your Circle*</option>
                 <?php
                 if($circle){
                 	foreach($circle as $list){
                 ?>	 
                 <option value="<?php echo $list['circle_code']; ?>"><?php echo $list['circle_name']; ?></option>
             	<?php }} ?>
                  </select>

                <?php echo form_error('circle', '<div class="error">', '</div>'); ?>  
                
              </div>
              <div class="form-group">
                <input type="text" class="form-control" data-bv-field="number" id="cardNumber" name="cardNumber" placeholder="Enter Your Card Number">
				<?php echo form_error('cardNumber', '<div class="error">', '</div>'); ?> 
              </div>
			  
              <div class="form-group input-group">
                <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-inr"></i></span> </div>
                <input class="form-control" name="amount" id="amount" placeholder="Enter Amount*" type="text">
              </div>
              <?php echo form_error('amount', '<div class="error">', '</div>'); ?> 
              <?php if($this->session->userdata('cranesmart_member_session')) { ?>
              <button class="btn btn-primary btn-block" type="submit">Continue to Recharge</button>
          	  <?php echo form_close(); ?>
          	  <?php } else{ ?>
          	  <a href="{site_url}login"><button class="btn btn-primary btn-block" type="button">Continue to Recharge</button></a>
          	  <?php } ?>	
            <?php echo form_close(); ?>
          </div><!-- DTH Recharge end -->
          
          <!-- Slideshow
          ============================================= -->
           <div class="col-lg-8">
            <div class="owl-carousel owl-theme single-slider" data-animateout="fadeOut" data-animatein="fadeIn" data-autoplay="true" data-loop="true" data-autoheight="true" data-nav="true" data-items="1">
              <div class="item"><a href="#"><img class="img-fluid" src="{site_url}skin/front/images/slider/banner-1.jpg" alt="banner 1" /></a></div>
              <div class="item"><a href="#"><img class="img-fluid" src="{site_url}skin/front/images/slider/banner-2.jpg" alt="banner 2" /></a></div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    
   
    
    <!-- Refer & Earn
    ============================================= -->
    <div class="container">
      <section class="section bg-light shadow-md rounded px-5">
        <h2 class="text-9 font-weight-600 text-center">Refer & Earn</h2>
        <p class="lead text-center mb-5">Refer your friends and earn 500 CM Points.</p>
        <div class="row">
          <div class="col-md-4">
            <div class="featured-box style-4">
              <div class="featured-box-icon bg-light-4 text-primary rounded-circle"> <i class="fa fa-bullhorn"></i> </div>
              <h3>Refer Your Friends</h3>
              <p class="text-3">Share your referral link with friends.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="featured-box style-4">
              <div class="featured-box-icon bg-light-4 text-primary rounded-circle"> <i class="fa fa-send"></i> </div>
              <h3>Your Friend Register</h3>
              <p class="text-3">Your friends Register with using your referral link.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="featured-box style-4">
              <div class="featured-box-icon bg-light-4 text-primary rounded-circle" style="padding-left:32px;">
                <img src="{site_url}skin/front/images/cm-point-txt.png" />
              </div>
              <h3>You Earn</h3>
              <p class="text-3">You get 500CM points. You can use these credits for shopping.</p>
            </div>
          </div>
        </div>
        
      </section>
    </div><!-- Refer & Earn end -->
    
    <!-- Mobile App
    ============================================= -->
    <section class="section pb-0">
      <div class="container">
        <div class="row">
          <div class="col-md-5 col-lg-6 text-center"> <img class="img-fluid" alt="" src="{site_url}skin/front/images/app-mobile.png"> </div>
          <div class="col-md-7 col-lg-6">
            <h2 class="text-9 font-weight-600 my-4">Download Our Cranes Mart<br class="d-none d-lg-inline-block">
              Mobile App Now</h2>
            <p class="lead">Download our app for the fastest, most convenient way to send Recharge.</p>
            <ul>
              <li>Recharge</li>
              <li>Bill Payment</li>
              <li>Booking Online</li>
              <li>and much more.....</li>
            </ul>
            <div class="d-flex flex-wrap pt-2"><a href="#"><img alt="" src="{site_url}skin/front/images/google-play-store.png"></a> </div>
          </div>
        </div>
      </div>
    </section>
    
  </div><!-- Content end -->