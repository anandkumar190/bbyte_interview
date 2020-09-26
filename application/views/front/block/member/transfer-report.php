<section class="page-header page-header-text-light bg-primary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Fund Transfer Report</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{site_url}home">Home</a></li>
		  <li class="active">Fund Transfer Report</li>
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
          <h4 class="mb-3">Fund Transfer Report</h4>
          <div class="tab-content my-3" id="myTabContent">
            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead class="thead-light">
                    <tr>
                      <th>Date</th>
                      <th>Benificary</th>
                      <th>Amount</th>
                      <th>Transaction ID</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($recharge){
                      foreach($recharge as $list){
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo date('d-m-Y',strtotime($list['created'])); ?></td>
                      <td class="align-middle"><?php echo $list['account_holder_name'].' ('.$list['account_no'].')'; ?></td>
                      <td class="align-middle"><?php echo $list['transfer_amount'].' /-'; ?></td>
                      <td class="align-middle"><?php echo $list['transaction_id']; ?></td>
                      
                      
                      <td class="align-middle">
						<?php if($list['status'] == 1) {
							echo '<font color="black">Processing</font>';
						}
						elseif($list['status'] == 2) {
							echo '<font color="orange">Pending</font>';
						}
            elseif($list['status'] == 3) {
              echo '<font color="green">Success</font>';
            }
            else{
              echo '<font color="red">Failed</font>';
            }
							?>
					  </td>
					  
					  
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
