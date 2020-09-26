<section class="page-header page-header-text-light bg-primary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Direct Downline</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{site_url}home">Home</a></li>
		  <li class="active">Direct Downline</li>
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
          <!-- Orders History
          ============================================= -->
          <h4 class="mb-3">Direct Downline</h4>
          <div class="tab-content my-3" id="myTabContent">
            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead class="thead-light">
                    <tr>
                      <th>#</th>
                      <th>Level</th>
                      <th>Member</th>
                      <th>Membership</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($directDownlineList){
						$i = 1;
                      foreach($directDownlineList as $list){ 
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $i; ?>.</td>
                      <td class="align-middle"><?php echo $list['level']; ?></td>
                      <td class="align-middle"><?php echo $list['name'].' ('.$list['user_code'].')'; ?></td>
					  <td class="align-middle"><?php echo $this->User->get_user_membership_type($list['memberID']); ?></td>
					  <td class="align-middle"><?php echo $list['email']; ?></td>
                      <td class="align-middle"><?php echo $list['mobile']; ?></td>
					  <td class="align-middle"><?php echo ($list['paid_status']) ? '<font color="green">Active</font>' : '<font color="red">Deactive</font>'; ?></td>
					  
                      </tr>
                  <?php $i++; }}else{  ?>  
				  <tr>
					<td colspan="6" class="align-middle text-center">No Record Found</td>
				  </tr>
				  <?php } ?>
                  </tbody>
                </table>
              </div>
              
            </div>
            </div>
          <!-- Orders History end --> 
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
