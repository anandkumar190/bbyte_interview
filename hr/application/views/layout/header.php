<header class="topbar clearfix">
	<div class="topbar-left pull-left">
		<div class="clearfix">
			<ul class="left-branding pull-left clickablemenu ttmenu dark-style menu-color-gradient">
				<li><span class="left-toggle-switch"><i class="zmdi zmdi-menu"></i></span></li>
				<li>
					<div class="logo">
						<a href="JavaScript:void(0);" title="Admin Template">
							<img src="<?php echo base_url('assets/'); ?>images/dummyLogo.png" alt="logo" style="height: 5rem; margin-top: 0.5rem;">
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>

	<div class="topbar-right pull-right">
		<div class="clearfix">
			<ul class="left-bar-switch pull-left">
				<li><span class="left-toggle-switch"><i class="zmdi zmdi-menu"></i></span></li>
			</ul>
			<ul class="pull-right top-right-icons">
				<li class="dropdown notifications-dropdown">
					<a href="#" class="btn-notification dropdown-toggle" data-toggle="dropdown"><span class="noty-bubble">0</span><i class="zmdi zmdi-globe"></i></a>
					<div class="dropdown-menu notifications-tabs">
						<div>
							<ul class="nav material-tabs nav-tabs" role="tablist">
								<li class="active"><a href="#message" aria-controls="message" role="tab" data-toggle="tab">Message</a></li>
								<li><a href="#notifications" aria-controls="notifications" role="tab" data-toggle="tab">Notifications</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="message">
									<h4>You have 0 new messages</h4>
								</div>
								<div role="tabpanel" class="tab-pane" id="notifications">
									<h4>You have 0 new notifications</h4>
								</div>
							</div>
						</div>
					</div>
				</li>
                <li class="dropdown apps-dropdown">
                    <a href="#" class="btn-apps dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-apps"></i></a>
                    <div class="dropdown-menu">
                        <ul class="apps-shortcut clearfix">
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="fa fa-user"></i>
                                    <span class="apps-label">Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('logout') ?>">
                                    <i class="zmdi zmdi-power"></i>
                                    <span class="apps-label">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
			</ul>
		</div>
	</div>
	<!--Topbar Right End-->
</header>
