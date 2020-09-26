<section class="page-header page-header-text-light bg-primary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Recharge History</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{site_url}home">Home</a></li>
		  <li class="active">Recharge History</li>
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
          <h4 class="mb-3">Recharge History</h4>
          <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item"> <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">Recharge & Bill Payment</a> </li>
            </ul>
          <div class="tab-content my-3" id="myTabContent">
            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead class="thead-light">
                    <tr>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Order ID</th>
                      <th class="text-center">Status</th>
                      <th class="text-right">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($recharge){
                      foreach($recharge as $list){
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo date('d-M-Y H:i:s',strtotime($list['created'])); ?></td>
                      <td class="align-middle"><span class="text-1 d-inline-flex">
                      <?php
                      $operator = $this->db->get_where('operator',array('operator_code'=>$list['operator_code']))->row_array();
                      
                      $recharge_type = $this->db->get_where('recharge_type',array('id'=>$list['recharge_type']))->row_array();
                      ?>  

                      Recharge of <?php echo $operator['operator_name']; ?> <?php echo $recharge_type['type']; ?> <?php echo $list['mobile']; ?></span></td>
                      <td class="align-middle"><?php echo $list['recharge_display_id']; ?></td>
                    
                      <td class="align-middle text-center">
                        <?php
                        if($list['status']==1){
                         ?>
                        <i class="fa fa-ellipsis-h text-4 text-warning" data-toggle="tooltip" data-original-title="Your Recharge is Pending"></i>
                        <?php } ?>

                        <?php
                        if($list['status']==2){
                         ?>
                        <i class="fa fa-check-circle text-4 text-success" data-toggle="tooltip" data-original-title="Your Recharge is Successful"></i>
                        <?php } ?>

                        <?php
                        if($list['status']==3){
                         ?>
                        <i class="fa fa-times-circle text-4 text-danger" data-toggle="tooltip" data-original-title="Your Recharge is Failed"></i>
                        <?php } ?>


                      </td>
                      <td class="align-middle text-right"><?php echo $list['amount']; ?> /-</td>
                      </tr>
                  <?php }}?>  
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
