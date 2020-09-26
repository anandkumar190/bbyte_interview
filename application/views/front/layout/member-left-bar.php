<div class="col-lg-3"> 
        <!-- Nav Link
        ============================================= -->
        <ul class="nav nav-pills alternate flex-lg-column sticky-top">
          <li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/profile'){ ?>active <?php } ?>" href="{site_url}member/profile"><i class="fa fa-user"></i>Personal Information</a></li>
          <li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/changepass'){ ?>active <?php } ?>" href="{site_url}member/changepass"><i class="fa fa-key"></i>Change Password</a></li>
          <li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/orderhistory'){ ?>active <?php } ?>" href="{site_url}member/orderhistory"><i class="fa fa-history"></i>Recharge History</a></li>

          <li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/orders'){ ?>active <?php } ?>" href="{site_url}member/orders"><i class="fa fa-history"></i>Order History</a></li>

		  <li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/premiumWalletHistory'){ ?>active <?php } ?>" href="{site_url}member/wallet/premiumWalletHistory"><i class="fa fa-history"></i>Premium Wallet</a></li>
		  <li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/pointsHistory'){ ?>active <?php } ?>" href="{site_url}member/wallet/pointsHistory"><i class="fa fa-history"></i>CM Points History</a></li>
		  <?php $member_current_package = $this->User->get_member_current_package(); ?>
		  <?php $user_dmr_cusomer_id = $this->User->get_user_dmr_customer_id(); ?>
		  <?php $user_kyc_status = $this->User->get_user_kyc_status(); ?>
          <?php if($member_current_package > 1 && $user_kyc_status == 3){ ?>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle <?php if(isset($content_block) && ($content_block == 'member/active-withdrawal' || $content_block == 'member/benificary' || $content_block == 'member/fund-transfer' || $content_block == 'member/fund-transfer-otp' || $content_block == 'member/transfer-report')){ ?>active <?php } ?>" href="#withdrawalSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-inr"></i>Withdrawal</a>
                <ul class="collapse list-unstyled <?php if(isset($content_block) && ($content_block == 'member/active-withdrawal' || $content_block == 'member/benificary' || $content_block == 'member/fund-transfer' || $content_block == 'member/fund-transfer-otp' || $content_block == 'member/transfer-report')){ ?>show <?php } ?>" id="withdrawalSubmenu">
                    <?php if($user_dmr_cusomer_id == ''){ ?>
                    <li class="nav-item">
                        <a href="{site_url}member/wallet/active-withdrawal" class="nav-link <?php if(isset($content_block) && $content_block == 'member/active-withdrawal'){ ?>active <?php } ?>">Activate Withdrawal</a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a href="{site_url}member/wallet/benificary" class="nav-link <?php if(isset($content_block) && $content_block == 'member/benificary'){ ?>active <?php } ?>">Beneficiary</a>
                    </li>
                    <li class="nav-item">
                        <a href="{site_url}member/wallet/fundTransfer" class="nav-link <?php if(isset($content_block) && $content_block == 'member/fund-transfer' || $content_block == 'member/fund-transfer-otp'){ ?>active <?php } ?>">Fund Transfer</a>
                    </li>
                    <li class="nav-item">
                        <a href="{site_url}member/wallet/transferReport" class="nav-link <?php if(isset($content_block) && $content_block == 'member/transfer-report'){ ?>active <?php } ?>">Transfer Report</a>
                    </li>
                    
                </ul>
            </li>
          <?php } ?>
          <?php if($member_current_package != 3){ ?>  
		  <li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/upgrade'){ ?>active <?php } ?>" href="{site_url}member/profile/upgrade"><i class="fa fa-inr"></i>Upgrade</a></li>
		  <?php } ?>
		<?php if($member_current_package > 1){ ?>
		<li class="nav-item">
				<a class="nav-link dropdown-toggle <?php if(isset($content_block) && ($content_block == 'member/team' || $content_block == 'member/direct-downline' || $content_block == 'member/direct-active' || $content_block == 'member/direct-deactive' || $content_block == 'member/total-downline' || $content_block == 'member/total-active' || $content_block == 'member/total-deactive')){ ?>active <?php } ?>" href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fa fa-users"></i>Genealogy</a>
                <ul class="collapse list-unstyled <?php if(isset($content_block) && ($content_block == 'member/team' || $content_block == 'member/direct-downline' || $content_block == 'member/direct-active' || $content_block == 'member/direct-deactive' || $content_block == 'member/total-downline' || $content_block == 'member/total-active' || $content_block == 'member/total-deactive')){ ?>show <?php } ?>" id="homeSubmenu">
                    <li class="nav-item">
                        <a href="{site_url}member/profile/myTeam" class="nav-link <?php if(isset($content_block) && $content_block == 'member/team'){ ?>active <?php } ?>">My Team</a>
                    </li>
                    <li class="nav-item">
                        <a href="{site_url}member/profile/directDownline" class="nav-link <?php if(isset($content_block) && $content_block == 'member/direct-downline'){ ?>active <?php } ?>">Direct Downline</a>
                    </li>
					<li class="nav-item">
                        <a href="{site_url}member/profile/directActive" class="nav-link <?php if(isset($content_block) && $content_block == 'member/direct-active'){ ?>active <?php } ?>">Direct Active</a>
                    </li>
					<li class="nav-item">
                        <a href="{site_url}member/profile/directDeactive" class="nav-link <?php if(isset($content_block) && $content_block == 'member/direct-deactive'){ ?>active <?php } ?>">Direct Deactive</a>
                    </li>
                    <li class="nav-item">
                        <a href="{site_url}member/profile/totalDownline" class="nav-link <?php if(isset($content_block) && $content_block == 'member/total-downline'){ ?>active <?php } ?>">Total Downline</a>
                    </li>
					<li class="nav-item">
                        <a href="{site_url}member/profile/totalActive" class="nav-link <?php if(isset($content_block) && $content_block == 'member/total-active'){ ?>active <?php } ?>">Total Active</a>
                    </li>
					<li class="nav-item">
                        <a href="{site_url}member/profile/totalDeactive" class="nav-link <?php if(isset($content_block) && $content_block == 'member/total-deactive'){ ?>active <?php } ?>">Total Deactive</a>
                    </li>
					
                </ul>
            </li>
		<li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/level-income-report'){ ?>active <?php } ?>" href="{site_url}member/report"><i class="fa fa-inr"></i>Income Report</a></li>
		<li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/kyc'){ ?>active <?php } ?>" href="{site_url}member/profile/kyc"><i class="fa fa-file"></i>KYC</a></li>
		<li class="nav-item"><a class="nav-link <?php if(isset($content_block) && $content_block == 'member/fundRequest'){ ?>active <?php } ?>" href="{site_url}member/profile/fundRequest"><i class="fa fa-inr"></i>Fund Request</a></li>
		<?php } ?>
		  
        </ul>
        <!-- Nav Link end --> 
      </div>