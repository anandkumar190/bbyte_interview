<section class="page-header page-header-text-light bg-primary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>CM Points History</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{site_url}home">Home</a></li>
		  <li class="active">CM Points History</li>
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
          <h4 class="mb-3">CM Points History</h4>
          <div class="tab-content my-3" id="myTabContent">
            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead class="thead-light">
                    <tr>
                      <th>Cr/Dr Before</th>
                      <th>Cr/Dr Amount</th>
                      <th>Cr/Dr After</th>
                      <th>Date Time</th>
                      <th>Type</th>
                      <th>Description</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($recharge){
                      foreach($recharge as $list){
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $list['before_balance'].' /-'; ?></td>
                      
                      
                      <td class="align-middle">
						<?php if($list['type'] == 1) {
							echo '<font color="green">'.$list['amount'].' /-</font>';
						}
						elseif($list['type'] == 2) {
							echo '<font color="red">'.$list['amount'].' /-</font>';
						}
							?>
					  </td>
					  <td class="align-middle"><?php echo $list['after_balance'].' /-'; ?></td>
					  <td class="align-middle"><?php echo date('d-M-Y H:i:s',strtotime($list['created'])); ?></td>
                       <td class="align-middle">
						<?php if($list['type'] == 1) {
							echo '<font color="green">Cr.</font>';
						}
						elseif($list['type'] == 2) {
							echo '<font color="red">Dr.</font>';
						}
							?>
					  </td>
					  <td class="align-middle"><?php echo $list['description']; ?></td>
					 
                      </tr>
                  <?php }}else{  ?>  
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
