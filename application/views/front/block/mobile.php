    <section class="container">
      <div class="bg-light shadow-md rounded p-4">
        <div class="row">
          
          <!-- Mobile Recharge
          ============================================= -->
          <div class="col-lg-4 mb-4 mb-lg-0">
          	{system_message}    
            {system_info}
            <h2 class="text-4 mb-3">Mobile Recharge or Bill Payment</h2>
            <?php echo form_open_multipart('mobile/proceedRecharge', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <div class="mb-3">
                <div class="custom-control custom-radio custom-control-inline">
                  <input id="prepaid" onchange="acc(this.value);" name="recharge_type" value="1" class="custom-control-input" checked="" type="radio">
                  <label class="custom-control-label" for="prepaid"><b>Prepaid</b></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input id="postpaid" onchange="acc(this.value);" name="recharge_type" value="2" class="custom-control-input" type="radio">
                  <label class="custom-control-label" for="postpaid"><b>Postpaid</b></label>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="mobile" data-bv-field="number" id="mobile" placeholder="Enter Mobile Number*">
              <?php echo form_error('mobile', '<div class="error">', '</div>'); ?>  
              
              </div>

              <div class="form-group" style="display: none;" id="acdiv">
                <input type="text" class="form-control" name="acnumber" data-bv-field="number" id="acnumber" placeholder="Enter Account Number*">
              <?php echo form_error('acnumber', '<div class="error">', '</div>'); ?>  
              
              </div>

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
            
          </div>
          <!-- Mobile Recharge end --> 
          
          <!-- Slideshow
          ============================================= -->
          <div class="col-lg-8">
            <div class="owl-carousel owl-theme single-slider" data-animateout="fadeOut" data-animatein="fadeIn" data-autoplay="true" data-loop="true" data-autoheight="true" data-nav="true" data-items="1">
              <div class="item"><a href="#"><img class="img-fluid" src="{site_url}skin/front/images/slider/banner-1.jpg" alt="banner 1" /></a></div>
              <div class="item"><a href="#"><img class="img-fluid" src="{site_url}skin/front/images/slider/banner-2.jpg" alt="banner 2" /></a></div>
            </div>
          </div>
          <!-- Slideshow end --> 
          
        </div>
      </div>
    </section>
    
    




    <!-- Refer & Earn
    ============================================= -->

    <!-- Refer & Earn end --> 
    
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
    <!-- Mobile App end --> 


    <!-- Refer & Earn
    ============================================= -->


    
  </div>
  <!-- Content end --> 
