<aside class="leftbar material-leftbar">
	<div class="left-aside-container">
		<div class="user-profile-container">
            <?php
                $userDeat = getUserDetails();
                $img = 'assets/images/user.jpg';
                if(!empty($userDeat['avatar']) && file_exists($userDeat['avatar'])){
                    $img = $userDeat['avatar'];
                }
            ?>
			<div class="user-profile clearfix">
				<div class="admin-user-thumb text-center">
					<img src="<?= base_url($img); ?>" alt="User Image">
				</div>
				<div class="admin-user-info">
					<ul>
						<li><a href="javascript:void(0);"><?= $userDeat['fullname'] ?></a></li>
						<li><a href="javascript:void(0);"><?= $userDeat['email'] ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<ul class="list-accordion">
			<li class="list-title">
				<a href="<?= base_url($this->session->userdata('type').'/dashboard'); ?>">
					<i class="fa fa-dashboard"></i><span class="list-label"> Dashboard </span>
				</a>
			</li>
            <?php if($this->session->userdata('role') != 3){  ?>
                <li>
                    <a href="<?= base_url($this->session->userdata('type').'/users') ?>">
                        <i class="fa fa-users"></i>
                        <span class="list-label">Users</span>
                    </a>
                </li>
            <?php } ?>
		</ul>
	</div>
</aside>
