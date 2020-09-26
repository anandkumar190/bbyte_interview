  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Upgrade</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / Upgrade</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Header end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <div class="container">
      <?php $this->load->view('front/layout/wallet-column' , true); ?>
      <div class="row pt-md-3 mt-md-5">
        <?php $this->load->view('front/layout/member-left-bar' , true); ?>
        <div class="col-lg-9">
          <div class="bg-light shadow-md rounded p-4"> 
            <!-- Personal Information
          ============================================= -->
            {system_message}    
            {system_info}
            <div class="row">
				<?php if($packageList){ ?>
				<?php foreach($packageList as $list){ ?>
				
				<div class="col-sm-6 mb-4">
					<?php echo form_open_multipart('member/profile/upgradeAuth',array('target'=>'_blank')); ?>
				<input type="hidden" name="package_id" value="<?php echo $list['id']; ?>" />
					<div class="card shadow-sm border-0">
					<div class="card-body">
						<h5 class="card-title text-4 text-center">
							<?php echo $list['package_name']; ?><br /><br />
							INR <?php echo $list['package_amount']; ?> /-
						</h5>
					</div>
				  <ul class="list-group list-group-flush">
					<a class="list-group-item list-group-item-action" href="#">CM Points - <b><?php echo $list['cm_points']; ?></b></a>
					<a class="list-group-item list-group-item-action" href="#">Refer CM Points - <b><?php echo $list['refer_cm_points']; ?></b></a>
					<a class="list-group-item list-group-item-action" href="#">Cashback - <b><?php echo $list['cashback']; ?>%</b> </a>
				  </ul>
				  <div class="card-body text-center">
					<button class="btn btn-primary" type="submit">Upgrade</button>
				  </div>
					</div>
					<?php echo form_close(); ?>
				</div>
				
				<?php } ?>
				<?php } ?>
				
            </div>
            <!-- Personal Information end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
