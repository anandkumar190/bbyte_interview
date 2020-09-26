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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Stylesheet
============================================= -->
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/font-awesome/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/owl.carousel/assets/owl.carousel.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/vendor/owl.carousel/assets/owl.theme.default.min.css" />
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/css/home.css" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<style>
.error{color: red;}
</style>  
<!-- Preloader -->
<div id="preloader">
  <div data-loader="dual-ring"></div>
</div>
<input type="hidden" id="siteUrl" value="<?php echo base_url(); ?>">
<input type="hidden" id="variationStatus" value="<?php echo isset($variation_status) ? $variation_status : 0 ; ?>">
<input type="hidden" id="variationProID" value="<?php echo isset($variant_pro_id) ? $variant_pro_id : 0 ; ?>">
<div class="cart-msg-block fadeInDown wow animated">
</div>
<div class="large-loader">
	<img src="{site_url}skin/front/images/loading.gif" />
</div>
<!-- Preloader End --> 

<!-- Document Wrapper   
============================================= -->

  
  <!-- Header
  ============================================= -->
  <header id="header">
    <div class="container">
      <div class="header-row">
        <div class="header-column justify-content-start"> 
          
          <!-- Logo
          ============================================= -->
          <div class="logo"> <a href="{site_url}" title="Cranes Mart"><img src="{site_url}skin/images/logo.png" class="logo-img" alt="Quickai" width="100%"/></a> </div>
          <!-- Logo end --> 
          
        </div>
		<?php $cartTempData = $this->User->get_cart_qty_temp_data(); ?>
        <div class="header-column justify-content-end"> 
          
          <!-- Primary Navigation
          ============================================= -->
          <nav class="primary-menu navbar navbar-expand-lg">
               <ul class="navbar-nav">
                <li class="dropdown search-box">               
                  <div class="search-container">
                    <?php echo form_open('product/search',array('method'=>'get')); ?>
                      <input type="text" placeholder="Search for product, brands & more" class="form-control" name="keyword">
                      <button type="submit" class="search-icon-btn"><i class="fa fa-search"></i></button>
                    <?php echo form_close(); ?>
                  </div>
                </li>
				<li class="dropdown-user cart-icon">
				<a href="{site_url}cart" class="cart-icon-btn dropdown-toggle" title="Cart">
					<i class="fa" style="font-size:24px">&#xf07a;</i>
					<span class='badge badge-warning' id='lblCartCount'><?php echo $cartTempData; ?></span>
				</a>
				</li>
				<?php
              $loggedUser = $this->session->userdata('cranesmart_member_session');
			  $wallet_balance = 0;
			  if($loggedUser){
				
			  ?>
              <li class="dropdown-user wallet login-signup ml-lg-2"><a class="dropdown-toggle" href="#">Wallet<span class="d-none d-lg-inline-block" style="background: #8f9dac;color: #fff;border-radius: 100%;width: 34px;height: 34px;vertical-align: middle;line-height: 34px;font-size: 14px;text-align: center;display: inline-block;-webkit-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.15);box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.15);margin-left: 0.4rem;"><i class="fa fa-money"></i></span></a>
				  <div class="dropdown-content-user">
					<a class="dropdown-item" href="{site_url}member/wallet/pointsHistory">CM Points</a>
					<a class="dropdown-item" href="{site_url}member/wallet/premiumWalletHistory">Premium Points</a>
					<a class="dropdown-item" href="{site_url}member/wallet/topup">Topup</a>
					
				  </div>
				</li>
			  <?php } ?>
                 <?php if($this->session->userdata('cranesmart_member_session')){ ?>
				<li class="dropdown-user login-signup ml-lg-2"><a class="dropdown-toggle" href="#"><?php $loggedUser = $this->session->userdata('cranesmart_member_session');

                echo $loggedUser['name'];

                ?> <span class="d-none d-lg-inline-block" style="background: #8f9dac;color: #fff;border-radius: 100%;width: 34px;height: 34px;vertical-align: middle;line-height: 34px;font-size: 14px;text-align: center;display: inline-block;-webkit-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.15);box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.15);margin-left: 0.4rem;"><i class="fa fa-user"></i></span></a>
				  <div class="dropdown-content-user">
					<a class="dropdown-item" href="{site_url}member/profile">My Profile</a>
					<a class="dropdown-item" href="{site_url}member/wallet/topup">Topup</a>
					<?php $member_current_package = $this->User->get_member_current_package(); ?>
          <?php if($member_current_package != 3){ ?>
          <a class="dropdown-item" href="{site_url}member/profile/upgrade">Upgrade</a>
          <?php } ?>
					
					<?php if($member_current_package > 1){ ?>
					<a class="dropdown-item" href="{site_url}member/profile/myTeam">My Team</a>
					<?php } ?>
					<a class="dropdown-item" href="{site_url}member/profile/logout">Logout</a>
				  </div>
				</li>
				<?php } ?>

                
                <?php if(!$this->session->userdata('cranesmart_member_session')){ ?>
                <li class="login-signup ml-lg-2"><a class="pl-lg-4 pr-0" href="{site_url}login" title="Login / Sign up">Login / Sign up <span class="d-none d-lg-inline-block"><i class="fa fa-user"></i></span></a></li><?php } ?>
              </ul>
           </nav>
    
        </div>
        
        <!-- Collapse Button
        ============================================= -->
      </div>
    </div>
    
       <div class="topnav" id="myTopnav">
	<div class="container">
		<div class="dropdown-second-navbar">
				<?php $categoryList = $this->User->get_category_menu_list(); ?>
				<?php if($categoryList){ ?>
				<?php foreach($categoryList as $list){ ?>
				<div class="shop-menu">
				<a class="dropbtn" href="#"><?php echo $list['title']; ?></a>
					<?php if(isset($list['subCat']) && $list['subCat']){ ?>
					<div class="dropdown-content">
						<div class="col-sm-12">
							<div class="row">
								<?php foreach($list['subCat'] as $listt){ ?>
								<div class="col-sm-3">
									<a href="{site_url}product/index/<?php echo $listt['slug']; ?>"><span class="sub-title"><?php echo $listt['title']; ?></span></a>
									<?php if(isset($listt['subCat']) && $listt['subCat']){ ?>
										<?php foreach($listt['subCat'] as $listtt){ ?>
											<a href="{site_url}product/index/<?php echo $listtt['slug']; ?>"><?php echo $listtt['title']; ?></a>
										<?php } ?>
									<?php } ?>
									
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
          <a href="{site_url}mobile">Recharge</a>
          
    </div>
    </div>
        <?php if(isset($content_block) && $content_block == 'home'){ ?>
    <div class="scroller">
    	<!--<marquee><font color="red">Dear Customer, this is to inform you that our CranesMart application is under maintenance today. Between this time all application features will be impacted. We regret the inconvenience caused.</font></marquee>-->
    </div>
    <div class="scroller">
    	<img src="{site_url}skin/front/images/online.jpg" />
    </div>
<?php } ?>
  </header>
  <!-- Header end --> 
  
  <!-- Content
  ============================================= -->
  
  <div id="main-wrapper"> 
  <div id="content"> 
    
    <!-- Secondary Navigation
    ============================================= -->
    
 
    <div class="menu-icon">
          <a href="javascript:void(0);" style="font-size:20px; color:#fff;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
 <script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
