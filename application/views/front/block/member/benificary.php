  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>Beneficiary</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / Beneficiary</li>
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
      {system_message}    
            {system_info}
      <?php $this->load->view('front/layout/wallet-column' , true); ?>
      <div class="row pt-md-3 mt-md-5">
        <?php $this->load->view('front/layout/member-left-bar' , true); ?>
        <div class="col-lg-9">
          <div class="bg-light shadow-md rounded p-4"> 
            <!-- Personal Information
          ============================================= -->
            <?php echo form_open_multipart('member/wallet/benificaryAuth', array('id' => 'admin_profile'),array('method'=>'post')); ?>
      
            <div class="row">
        
                <div class="col-sm-4">
                <h5>Beneficiary</h5>
                </div>
                <div class="col-sm-8 text-right"></div>

              <div class="col-sm-3">
          <div class="form-group">
          <label><b>Account Holder Name*</b></label>
          <input type="text" class="form-control" autocomplete="off" name="account_holder_name" id="account_holder_name" placeholder="Holder Name">
          <?php echo form_error('account_holder_name', '<div class="error">', '</div>'); ?>  
          </div>
          </div>
         <div class="col-sm-3">
          <div class="form-group">
          <label><b>Bank Name*</b></label>
          <input type="text" class="form-control" autocomplete="off" name="bank_name" id="bank_name" placeholder="Bank Name">
          <?php echo form_error('bank_name', '<div class="error">', '</div>'); ?>  
          
          </div>
          </div>
           <div class="col-sm-3">
          <div class="form-group">
          <label><b>Account No.*</b></label>
          <input type="text" class="form-control" autocomplete="off" name="account_number" id="account_number" placeholder="Account No.">
          <?php echo form_error('account_number', '<div class="error">', '</div>'); ?>  
          
          </div>
          </div>
           <div class="col-sm-3">
          <div class="form-group">
          <label><b>IFSC Code*</b></label>
          <input type="text" class="form-control" autocomplete="off" name="ifsc" id="ifsc" placeholder="IFSC Code">
          <?php echo form_error('ifsc', '<div class="error">', '</div>'); ?>  
          
          </div>
          </div>
         
        <div class="col-sm-12">
          <button class="btn btn-primary" type="submit">Save New Beneficiary</button>
          </div>
           <div class="col-sm-12">
           <br />
                <h5>Beneficiary List</h5>
                </div>
         
          
          <div class="col-sm-12">
          <div class="table-responsive-md">
          <table class="table table-hover border">
            <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Beneficiary Name</th>
              <th>Account No.</th>
              <th>Bank</th>
              <th>IFSC</th>
              <th>Added On</th>
              <th>Fund</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($benificaryList){
                $i=1;
              foreach($benificaryList as $list){
             ?>
            <tr>
              <td class="align-middle"><?php echo $i; ?></td>
              <td class="align-middle"><?php echo $list['account_holder_name']; ?></td>
              <td class="align-middle"><?php echo $list['account_no']; ?></td>
              <td class="align-middle"><?php echo $list['bank_name']; ?></td>
              <td class="align-middle"><?php echo $list['ifsc']; ?></td>
              <td class="align-middle"><?php echo date('d-m-Y',strtotime($list['created'])); ?></td>
              <td class="align-middle">
                <a href="{site_url}member/wallet/fundTransfer/<?php echo $list['encode_ban_id']; ?>"><button class="btn btn-primary" type="button">Transfer</button></a>
              </td>
              </tr>
            <?php $i++; }}else{  ?>  
            <tr>
            <td colspan="7" class="align-middle text-center">No Record Found</td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
          </div>
          </div>
        
              </div>
        
        <?php echo form_close(); ?>
            <!-- Personal Information end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
