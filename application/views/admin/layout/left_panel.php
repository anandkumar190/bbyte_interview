 <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{site_url}admin/dashboard">
        <div class="sidebar-brand-icon">
        <img src="{site_url}skin/images/logo_white.png" class="img-responsive" style="width: 100%;">
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{site_url}admin/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

  
      <div class="sidebar-heading">
        Cranes Mart
      </div>

       
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
          <i class="fa fa-users"></i>
          <span>Member Management</span>
        </a>
        <div id="collapseThree" <?php if($content_block == 'member/memberList' || $content_block == 'member/addMember'  || $content_block == 'member/editMember'  || $content_block == 'member/memberTree' || $content_block == 'wallet/walletList' || $content_block == 'wallet/addWallet' || $content_block == 'member/benificaryList' || $content_block == 'member/fundTransferList' || $content_block == 'member/requestList') { ?> class="collapse show" <?php } else { ?> class="collapse"<?php } ?> aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Member Management:</h6>
            <a class="collapse-item" href="{site_url}admin/member/memberList">Member</a>
            <a class="collapse-item" href="{site_url}admin/wallet/walletList">Wallet</a>
			<a class="collapse-item" href="{site_url}admin/member/investmentList">Investment</a>
			<a class="collapse-item" href="{site_url}admin/member/memberTree">Tree</a>
            <h6 class="collapse-header">Withdrawal:</h6>
            <a class="collapse-item" href="{site_url}admin/member/benificaryList">Beneficiary List</a>
            <a class="collapse-item" href="{site_url}admin/member/fundTransferList">Fund Transfer Report</a>
            <h6 class="collapse-header">Fund Request:</h6>
            <a class="collapse-item" href="{site_url}admin/member/requestList">Request List</a>
            </div>
        </div>
      </li>

      <hr class="sidebar-divider">
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
          <i class="fa fa-users"></i>
          <span>User Management</span>
        </a>
        <div id="collapseSeven" <?php if($content_block == 'user/userList' || $content_block == 'user/addUser'  || $content_block == 'user/editUser') { ?> class="collapse show" <?php } else { ?> class="collapse"<?php } ?> aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">User Management:</h6>
            <a class="collapse-item" href="{site_url}admin/users/userList">Users</a>
            
            </div>
        </div>
      </li>

      <hr class="sidebar-divider">
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
          <i class="fa fa-users"></i>
          <span>Seller Management</span>
        </a>
        <div id="collapseSix" <?php if($content_block == 'seller/sellerList') { ?> class="collapse show" <?php } else { ?> class="collapse"<?php } ?> aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{site_url}admin/seller/sellerList">Seller</a>
            </div>
        </div>
      </li>
      
      <hr class="sidebar-divider">


      <li class="nav-item">
        <a class="nav-link" href="{site_url}admin/payment">
          <i class="fas fa-fw fa-list-alt"></i>
          <span>Payment Transaction</span></a>
      </li>

      <hr class="sidebar-divider">


      <li class="nav-item">
        <a class="nav-link" href="{site_url}admin/recharge">
          <i class="fas fa-fw fa-list-alt"></i>
          <span>Recharge History</span></a>
      </li>
      
      <hr class="sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="{site_url}admin/order">
          <i class="fas fa-fw fa-list-alt"></i>
          <span>Order History</span></a>
      </li>

      <hr class="sidebar-divider">
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
          <i class="fa fa-file"></i>
          <span>KYC Management</span>
        </a>
        <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">KYC Management:</h6>
                         <a class="collapse-item" href="{site_url}admin/kyc/kycList">KYC Request</a>
                        </div>
        </div>
      </li>
	  <hr class="sidebar-divider">
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
          <i class="fas fa-shopping-cart"></i>
		  <!--<i class="fas fa-file"></i>-->
		  <span>Shop</span>
        </a>
        <div id="collapseFour" <?php if($content_block == 'catalog/categoryList' || $content_block == 'catalog/addCategory'  || $content_block == 'catalog/editCategory'  || $content_block == 'store/attributeSetList' || $content_block == 'store/addAttributeSet' || $content_block == 'store/attributeList' || $content_block == 'store/setAttributeList' || $content_block == 'store/addAttribute' || $content_block == 'store/editAttribute' || $content_block == 'catalog/productList' || $content_block == 'catalog/addProduct' || $content_block == 'catalog/editProduct') { ?> class="collapse show" <?php } else { ?> class="collapse"<?php } ?> aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Category Management:</h6>
            <a class="collapse-item" href="{site_url}admin/catalog/addCategory">Add Category</a>
            <a class="collapse-item" href="{site_url}admin/catalog/categoryList">View Category</a>
			<h6 class="collapse-header">Attribute Management:</h6>
            <a class="collapse-item" href="{site_url}admin/store/attributeSetList">Attribute Set</a>
            <a class="collapse-item" href="{site_url}admin/store/attributeList">Attribute</a>
			<h6 class="collapse-header">Product Management:</h6>
            <a class="collapse-item" href="{site_url}admin/catalog/addProduct">Add Product</a>
            <a class="collapse-item" href="{site_url}admin/catalog/productList">View Product</a>
            </div>
        </div>
      </li>

      <hr class="sidebar-divider">
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
          <i class="fas fa-file"></i>
		  <span>Page Management</span>
        </a>
        <div id="collapseFive" <?php if($content_block == 'section/sectionList' || $content_block == 'section/addSection' || $content_block == 'section/editSection' || $content_block == 'banners/bannerList' || $content_block == 'banners/addBanner' || $content_block == 'banners/editBanner') { ?> class="collapse show" <?php } else { ?> class="collapse"<?php } ?> aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Page Management:</h6>
            <a class="collapse-item" href="{site_url}admin/section">Home Section</a>
			<h6 class="collapse-header">Banner Management:</h6>
            <a class="collapse-item" href="{site_url}admin/banners">Banners</a>
            
            </div>
        </div>
      </li>
	  
	  <hr class="sidebar-divider">
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
          <i class="fa fa-gift"></i>
          <span>Package Management</span>
        </a>
        <div id="collapse2" <?php if($content_block == 'package/packageList' || $content_block == 'package/addPackage' || $content_block == 'package/editPackage') { ?> class="collapse show" <?php } else { ?> class="collapse"<?php } ?>  aria-labelledby="heading2" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Package Management:</h6>
            <a class="collapse-item" href="{site_url}admin/package/addPackage">Add New Package</a>
            <a class="collapse-item" href="{site_url}admin/package/packageList">View All Package</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider">

      
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>

      <!-- End of Sidebar -->

          <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <li class="nav-item dropdown" style="padding-top: 20px;">
            <h6>
            <b>API Balance - <?php echo $this->User->getRechargeAPIBalance(); ?></b>/-
            </h6>  
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">0</span>
              </a>
              <!-- Dropdown - Alerts -->
              
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">0</span>
              </a>
              <!-- Dropdown - Messages -->
              
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  <?php
                $data=$this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();
                echo $data['name'];
                ?> 

                </span>
                <img class="img-profile rounded-circle" src="{site_url}skin/admin/img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{site_url}admin/profile/profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                               
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->