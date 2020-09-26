<?php $loggedUser = $this->session->userdata('cranesmart_member_session'); ?>
<div class="row pt-md-3 mt-md-5"style="
    padding: 0 !important;
    margin: 0 !important;
">
          <div class="col-lg-12">
            
                    <h5 class="text-3 text-body">Referral Link</h5>
                    <p class="text-muted mb-0">{site_url}register?referral_id=<?php echo $loggedUser['user_code']; ?>
					</p>
            
          </div>
         
        </div>
<div class="row pt-md-3 mt-md-5">
          <div class="col-lg-4">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-inr"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Premium Wallet</h5>
                    <p class="text-muted mb-0">INR <?php echo $this->User->get_user_wallet_balance(); ?>/- <br />
					<a class="btn-link" href="{site_url}member/wallet/premiumWalletHistory">View History</a>
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-archive"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">CM Points</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_cm_poits_balance(); ?> Points<br />
					<a class="btn-link" href="{site_url}member/wallet/pointsHistory">View History</a>
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-user-plus"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Membership</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_membership_type(); ?><br />
                    <?php $member_current_package = $this->User->get_member_current_package(); ?>
                    <?php if($member_current_package != 3){ ?>
					           <a class="btn-link" href="{site_url}member/profile/upgrade">Upgrade Now</a>
                   <?php } ?>
					           </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php if(isset($content_block) && $content_block == 'member/team'){ ?>
		<?php $member_current_package = $this->User->get_member_current_package(); ?>
		<?php if($member_current_package > 1){ ?>
<div class="row pt-md-3 mt-md-5">
          <div class="col-lg-4">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-user"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Total Direct</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_total_direct(); ?><br />
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-user" style="color:green;"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Direct Active Member</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_total_paid_member(); ?><br />
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-user" style="color:red;"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Direct Deactive Member</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_total_unpaid_member(); ?><br />
					
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<div class="row pt-md-3 mt-md-5">
          <div class="col-lg-4">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-user"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Total Downline</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_total_downline(); ?><br />
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-user" style="color:green;"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Downline Active Member</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_total_downline_paid(); ?><br />
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
              <div class="row no-gutters">
                <div class="col-12 col-sm-auto text-13 text-muted d-flex align-items-center justify-content-center"> <span class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="fa fa-user" style="color:red;"></i></span> </div>
                <div class="col text-center text-sm-left">
                  <div class="">
                    <h5 class="text-3 text-body">Downline Deactive Member</h5>
                    <p class="text-muted mb-0"><?php echo $this->User->get_user_total_downline_unpaid(); ?><br />
					
					</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<?php } ?>
		<?php } ?>