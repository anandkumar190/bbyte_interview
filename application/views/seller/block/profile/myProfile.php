<!-- Begin Page Content -->
        <div class="container-fluid" style="padding: 0; margin: 0">
        {system_message}    
        {system_info}  
          <!-- Page Heading -->
          <div class="row" style="padding: 0; margin: 0; width: 100%;">
          <img src="{site_url}skin/admin/img/myprofile-banner.jpg" style="width:100%;">
          </div>
          
           <?php
          $data=$this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();
          ?>

          <div class="row" style="margin-top: 40px;" >
          <div class="col-sm-3 text-center" style="box-shadow: 0px 2px 3px; padding-top: 30px; margin-left: 30px; padding-bottom: 30px; height:330px;">
  <img src="{site_url}<?php echo $data['photo'];?>" class="rounded-circle responsive" width="250px" height="250px">
         
          <h4 style="color: black; margin-top: 15px;"><b><?php echo $data['name']; ?></b></h4>
          <h6 style="color: black; margin-top: 15px;"><?php echo $data['email']; ?></h6>
          </br><button type="button" class="btn btn-primary" style="font-size: 14px;" data-toggle="modal" data-target="#changePassword">Change Password</button>
          <button type="button" class="btn btn-primary" style="font-size: 14px;" data-toggle="modal" data-target="#editprofile">Edit Profile</button>
          </div>

          <div class="col-sm-5" style="position: relative; top: -100px; left: 20px;">
          <div class="card">
          <div class="card-header" style="padding-top: 25px; padding-bottom: 25px;">
            <div class="row">
            <div class="col-sm-6">
            <h5 style="color: black;"><b>User Info</b></h5>
          </div>
          <div class="col-sm-6 text-right"  id="editbtn">
            <button type="button" class="btn btn-info btn-sm" onclick="myFunction()" ><i class="fa fa-edit"></i> Edit</button>
          </div>
          </div>  
        </div>
          <div class="card-body">
           <div class="col-sm-12"  id="editbody"> 
           <?php
           $data=$this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();
           ?> 
          <span style="color: black;"><b><i class="fa fa-user"></i> Name</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  : <?php echo $data['name']; ?> 
      </br></br><span style="color: black;"><b><i class="fa fa-phone"></i> Phone No.</b></span>  : <?php echo $data['mobile']; ?>
      </br></br><span style="color: black;"><b><i class="fa fa-envelope"></i> Email</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  : <?php echo $data['email']; ?>
      </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Username</b></span>  : <?php echo $data['username']; ?>

      </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Firm Name</b></span>  : <?php echo $data['firm_name'];?>

      </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Address</b></span>  : <?php echo $data['address'];?>

      </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Zip Code</b></span>  : <?php echo $data['zip_code'];?>

      </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> state </b></span>  : 
         <?php $state_id= $data['state_id'];?>
         <?php if($stateList){ ?>
                <?php foreach($stateList as $list){ ?>
                  <?php $id=$list['id']; ?>
                  <?php if($state_id==$id){ echo $list['name'];} ?>                
                <?php } ?>
              <?php } ?>

      

      </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> country </b></span>  :
      <?php $country_id= $data['country_id'];?>
         <?php if($countryList){ ?>
                <?php foreach($countryList as $list){ ?>
                  <?php $id=$list['id']; ?>
                  <?php if($country_id==$id){ echo $list['name'];} ?>                
                <?php } ?>
              <?php } ?>
  
      </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Gst No</b></span>  : <?php echo $data['gst_no'];?>  

</br></br><p style="color: black;"><b></i> Bank Detail</b></p>
      <span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Bank Name</b></span>  : <?php echo $bankdetails[0]['bank_name'];?>  

       </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Account Holder Name</b></span>  : <?php echo $bankdetails[0]['account_holder_name'];?>  

       </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> Account Number</b></span>  : <?php echo $bankdetails[0]['account_number'];?> 

       </br></br><span style="color: black;"><b><i class="fa fa-globe mr-1"></i> IFSC Code</b></span>  : <?php echo $bankdetails[0]['ifsc'];?> 
          </div>


          <div class="col-sm-12" id="editform" style="display: none;">
            <?php echo form_open_multipart('seller-panel/profile/updateProfile', array('id' =>'admin_profile')); ?>
           <?php
           $data=$this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();
           ?>

          <div class="form-group">
            <input type="hidden" name="accound_id" value="<?php echo $loggedUser['id']; ?>" >
            <input type="hidden" name="email" value="<?php echo $data['email']; ?>" >
            <input type="hidden" name="mobile" value="<?php echo $data['mobile']; ?>" >

          <label style=" color: black;"><b>Name*</b></label>      
          <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $data['name']; ?>">
          <?php echo form_error('name', '<div class="error">', '</div>'); ?>      
          </div>

          <div class="form-group">
            <label for="signupEmail">Address*</label>
            <input type="text" class="form-control" name="address" id="signupEmail" value="<?php echo $data['address'];?>" placeholder="Address">
            <?php echo form_error('address', '<div class="error">', '</div>'); ?>
            </div>



             <div class="form-group">
            <label for="signupEmail">State*</label>
            <select class="form-control" name="state">
              <option value="">Select State</option>
              <?php if($stateList){ ?>
                <?php foreach($stateList as $list){ ?>
                  <option value="<?php echo $list['id']; ?>" <?php if($list['id'] == $state_id){ ?> selected="selected" <?php } ?>><?php echo $list['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <?php echo form_error('state', '<div class="error">', '</div>'); ?>
            </div>

            <div class="form-group">
            <label for="signupEmail">Country*</label>
            <select class="form-control" name="country">
              <?php if($countryList){ ?>
                <?php foreach($countryList as $list){ ?>
                  <option value="<?php echo $list['id']; ?>" <?php if($list['id'] == $country_id){ ?> selected="selected" <?php } ?>><?php echo $list['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <?php echo form_error('country', '<div class="error">', '</div>'); ?>
            </div>

            <div class="form-group">
            <label for="signupEmail">Zip Code*</label>
            <input type="text" class="form-control" name="zip_code" id="signupEmail" value="<?php echo $data['zip_code'];?>" placeholder="Zip Code">
            <?php echo form_error('zip_code', '<div class="error">', '</div>'); ?>
            </div>
         <!--  <div class="form-group">
          <label style=" color: black;"><b>Phone No.*</b></label>      
          <input type="text" class="form-control" name="mobile" placeholder="Phone No." value="<?php echo $data['mobile']; ?>">
          <?php echo form_error('mobile', '<div class="error">', '</div>'); ?>      
          </div> -->
         <!--  <div class="form-group">
          <label style=" color: black;"><b>Email*</b></label>      
          <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $data['email']; ?>"> 
          <?php echo form_error('email', '<div class="error">', '</div>'); ?>     
          </div> -->
          <div class="form-group text-right">
          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
          <button type="button" class="btn btn-secondary btn-sm" id="cancelbtn">Cancel</button> <?php echo form_close(); ?>     
          </div>  
          </div>   
          </div>
          </div>
          </div>

          

        <div class="col-sm-2">
          </div>
  

      </div>

          <!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="changePassword" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="color: black; font-size: 20px;"><b>Change Password</b></h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('seller-panel/profile/update', array('id' => 'admin_profile')); ?>
        <div class="col-sm-12">
        <div class="form-group">
        <label style="color: black"><b>Old Password*</b></label>
        <input type="text" autocomplete="off" class="form-control" placeholder="Old Password" name="opw" id="opw">
        <?php echo form_error('opw', '<div class="error">', '</div>'); ?>    
        </div>

        <div class="form-group">
        <label style="color: black"><b>New Password*</b></label>
        <input type="password" autocomplete="off" class="form-control" placeholder="New Password" name="npw" id="npw">
        <?php echo form_error('npw', '<div class="error">', '</div>'); ?>    
        </div>

        <div class="form-group">
        <label style="color: black"><b>Confirm New Password*</b></label>
        <input type="password" autocomplete="off" class="form-control" placeholder="Confirm New Password" name="cpw" id="cpw">
        <?php echo form_error('cpw', '<div class="error">', '</div>'); ?>
        <span style="font-size: 13px;">Note:-Confirm New Password Field Will Be same to New Password Field.</span>    
        </div>    
      </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" style="">Submit</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
     </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>


<div id="editprofile" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="color: black; font-size: 20px;"><b>Change Profile</b></h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('seller-panel/profile/profile_imageupdate', array('id' => 'admin_profile')); ?>
        <div class="col-sm-12">
        
         <?php
           $data=$this->db->get_where('users',array('id'=>$loggedUser['id']))->row_array();
           ?>

          
            <input type="hidden" name="accound_id" value="<?php echo $loggedUser['id']; ?>" >
            <input type="hidden" name="photo" value="<?php echo $data['photo'];?>" >
        
        <div class="form-group">
        <label style="color: black"><b>Profile Upload *</b></label>

        <input type="file"  class="form-control" placeholder="Profile" name="Profileupload">
        <?php echo form_error('cpw', '<div class="error">', '</div>'); ?>
        <span style="font-size: 13px;"></span>    
        </div>    
      </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" style="">Submit</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
     </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

    
          

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


      <script>
function myFunction() {
  var x = document.getElementById("editform");
   var y = document.getElementById("editbody");
  if (x.style.display === "none") {
    x.style.display = "block";
     y.style.display = "none";
  } else {
    x.style.display = "none";
    y.style.display = "block";
  }
}
</script>
