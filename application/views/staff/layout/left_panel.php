<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{site_url}staff/dashboard">
            <div class="sidebar-brand-icon">
                <img src="{site_url}skin/images/logo_white.png" class="img-responsive" style="width: 100%;">
            </div>
        </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{site_url}staff/dashboard">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <div class="sidebar-heading">
            Cranes Mart
        </div>

        <hr class="sidebar-divider">
        <?php if(isset($_SESSION['cranesmart_staff']) && !empty($_SESSION['cranesmart_staff']['role_id']) && $_SESSION['cranesmart_staff']['role_id'] == 6 && !empty($_SESSION['cranesmart_staff']['for_view'])){ ?>
            <?php if($_SESSION['cranesmart_staff']['for_view']==1){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse5" aria-expanded="true"
                       aria-controls="collapse5">
                        <i class="fa fa-file"></i>
                        <span>KYC Management</span>
                    </a>
                    <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">KYC Management:</h6>
                            <a class="collapse-item" href="{site_url}staff/kyc/kycList">KYC Request</a>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php if($_SESSION['cranesmart_staff']['for_view']==2){ ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse5" aria-expanded="true"
                       aria-controls="collapse5">
                        <i class="fa fa-hands-helping"></i>
                        <span>Help Desk</span>
                    </a>
                    <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Help Support:</h6>
                            <a class="collapse-item" href="{site_url}staff/help">Help Support List</a>
                        </div>
                    </div>
                </li>
            <?php } ?>
        <?php } ?>
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

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">

                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                             <?php
                             $data = $this->db->get_where('users', array('id' => $loggedUser['id']))->row_array();
                             echo $data['name'];
                             ?>

                            </span>
                            <img class="img-profile rounded-circle" src="{site_url}skin/admin/img/user.png">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->