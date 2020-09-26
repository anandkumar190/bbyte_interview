<section class="page-header page-header-text-light bg-primary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Income Report</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{site_url}home">Home</a></li>
		  <li class="active">Income Report</li>
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
          <h4 class="mb-3">Income Report</h4>
		  <?php echo form_open('member/report/levelAuth'); ?>
		  <div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Level*</label>
					<select class="form-control" name="level_num">
						<option value="0">All</option>
						<?php for($i=1;$i<=21;$i++){ ?>
						<option value="<?php echo $i; ?>" <?php if($level_num == $i){ ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
					<?php echo form_error('level_num', '<div class="error">', '</div>'); ?>  
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<button type="submit" class="btn btn-primary" style="margin-top:28px;">Search</button> 
				</div>
			</div>
		  </div>
		  <?php echo form_close(); ?>
          <div class="tab-content my-3" id="myTabContent">
            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
              <div class="table-responsive-md">
                <table class="table table-hover border">
                  <thead class="thead-light">
                    <tr>
                      <th>#</th>
                      <th>By Member</th>
                      <th>Level</th>
                      <th>Level Amount</th>
                      <th>TDS Charge ({tds_percentage}%)</th>
                      <th>Net Amount</th>
                      <th>Status</th>
                      <th>Datetime</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($recharge){
						$i = 1;
						$total_level_amount = 0;
						$total_tds_amount = 0;
						$total_wallet_amount = 0;
                      foreach($recharge as $list){ 
					  if($list['is_paid'])
					  {
						$total_level_amount+=$list['level_amount'];
						$total_tds_amount+=$list['tds_amount'];
						$total_wallet_amount+=$list['wallet_settle_amount'];
					  }
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $i; ?></td>
                      <td class="align-middle"><?php echo $list['name'].' ('.$list['user_code'].')'; ?></td>
					  <td class="align-middle"><?php echo $list['level_num']; ?></td>
					  <td class="align-middle"><?php echo number_format($list['level_amount'],2); ?></td>
					  <td class="align-middle"><?php echo number_format($list['tds_amount'],2); ?></td>
					  <td class="align-middle"><?php echo number_format($list['wallet_settle_amount'],2); ?></td>
					  <td class="align-middle"><?php echo ($list['is_paid']) ? '<font color="green">Paid</font>' : '<font color="red">Unpaid</font>'; ?></td>
					  <td class="align-middle"><?php echo date('d-M-Y H:i:s a',strtotime($list['created'])); ?></td>
                      </tr>
                  <?php $i++; }}else{  ?>  
				  <tr>
					<td colspan="6" class="align-middle text-center">No Record Found</td>
				  </tr>
				  <?php } ?>
                  </tbody>
				  <tr>
                      <th></th>
                      <th></th>
                      <th>Total</th>
                      <th><?php echo number_format($total_level_amount,2); ?></th>
                      <th><?php echo number_format($total_tds_amount,2); ?></th>
                      <th><?php echo number_format($total_wallet_amount,2); ?></th>
                      <th></th>
                      <th></th>
                      
                    </tr>
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
