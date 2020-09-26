{system_message}    
{system_info}
<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>View Member Tree</b></h4>
                </div>
                
                <div class="col-sm-6  text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            <?php echo form_open_multipart('admin/member/memberTreeAuth', array('id' => 'admin_profile'),array('method'=>'post')); ?>
              <input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
              
              <div class="row">
              
              <div class="col-sm-4">
              <div class="form-group">
              <label><b>Member*</b></label>
              <select class="selectpicker form-control" name="member_id" data-live-search="true">

              <option value="">Select Member</option>
              <?php if($memberList){ ?>
                <?php foreach($memberList as $list){ ?>
                  <option value="<?php echo $list['id']; ?>" <?php if(isset($member_id) && $member_id == $list['id']){ ?> selected="selected" <?php } ?>><?php echo ucwords($list['name']).' ('.$list['user_code'].')'; ?></option>  
                <?php } ?>
              <?php } ?>
              </select>
              <?php echo form_error('member_id  ', '<div class="error">', '</div>'); ?>  
              </div>
              </div>
              
              <div class="col-sm-4">
              <label><b>&nbsp;</b></label> <br />
              <button type="submit" class="btn btn-success">Search</button>
              </div>
              </div>

<?php echo form_close(); ?>     
              <br /><br />
              <?php if($search_status){ ?>
  <div class="row">
              
              <div class="col-sm-12 member-tree">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home" class="active">My Team</a></li>
    <li><a data-toggle="tab" href="#menu1">Direct Downline</a></li>
    <li><a data-toggle="tab" href="#menu2">Direct Active</a></li>
    <li><a data-toggle="tab" href="#menu3">Direct Deactive</a></li>
    <li><a data-toggle="tab" href="#menu4">Total Downline</a></li>
    <li><a data-toggle="tab" href="#menu5">Total Active</a></li>
    <li><a data-toggle="tab" href="#menu6">Total Deactive</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active show">
      

      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          
          <?php if($memberTree){ ?>
          <?php foreach($memberTree as $list){ ?>
          <?php if($list['child']){ ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?php echo $list['memberID']; ?>">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $list['memberID']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $list['memberID']; ?>">
                  <i class="more-less fa fa-plus"></i>
                  <?php if($list['paid_status']){ ?>
                  <div class="col-md-12">
                    <font color="green"><?php echo $list['name'].' ('.$list['code'].')'; ?> </font>
                  </div>
                  <div class="row member-detail-block">
                    <div class="col-md-3">
                    Level - <?php echo $list['level']; ?>
                    </div>
                    <div class="col-md-3">
                    Total Downline - <?php echo $list['total_downline']; ?>
                    </div>
                    <div class="col-md-3">
                    Total Active - <?php echo $list['total_downline_paid']; ?>
                    </div>
                    <div class="col-md-3">
                    Total Deactive - <?php echo $list['total_downline_unpaid']; ?>
                    </div>
                  </div>
                  <div class="row member-detail-block">
                    <div class="col-md-3">
                    
                    </div>
                    <div class="col-md-3">
                    Total Direct - <?php echo count($list['child']); ?>
                    </div>
                    <div class="col-md-3">
                    Direct Active - <?php echo $list['total_paid']; ?>
                    </div>
                    <div class="col-md-3">
                    Direct Deactive - <?php echo $list['total_unpaid']; ?>
                    </div>
                  </div>
                  <?php } else { ?>
                  <div class="col-md-12">
                    <font color="red"><?php echo $list['name'].' ('.$list['code'].')'; ?> </font>
                  </div>
                  
                  <div class="row member-detail-block">
                    <div class="col-md-3">
                    Level - <?php echo $list['level']; ?>
                    </div>
                    <div class="col-md-3">
                    Total Downline - <?php echo $list['total_downline']; ?>
                    </div>
                    <div class="col-md-3">
                    Total Active - <?php echo $list['total_downline_paid']; ?>
                    </div>
                    <div class="col-md-3">
                    Total Deactive - <?php echo $list['total_downline_unpaid']; ?>
                    </div>
                  </div>
                  <div class="row member-detail-block">
                    <div class="col-md-3">
                    
                    </div>
                    <div class="col-md-3">
                    Total Direct - <?php echo count($list['child']); ?>
                    </div>
                    <div class="col-md-3">
                    Direct Active - <?php echo $list['total_paid']; ?>
                    </div>
                    <div class="col-md-3">
                    Direct Deactive - <?php echo $list['total_unpaid']; ?>
                    </div>
                  </div>
                  
                  <?php } ?>
                </a>
              </h4>
            </div>
            <div id="collapse<?php echo $list['memberID']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
              <div class="panel-body">
                  <div class="panel-group" id="accordion<?php echo $list['memberID']; ?>" role="tablist" aria-multiselectable="true">
                  <?php foreach($list['child'] as $listt){ ?>
                  <?php if($listt['child']){ ?>
                  <div class="panel panel-default level-1">
                    <div class="panel-heading" role="tab" id="headingOne<?php echo $list['memberID']; ?>">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $list['memberID']; ?>" href="#collapseOne<?php echo $listt['memberID']; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $listt['memberID']; ?>">
                          <i class="more-less fa fa-plus"></i>
                          <?php if($listt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listt['name'].' ('.$listt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listt['name'].' ('.$listt['code'].')'; ?> </font>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listt['total_unpaid']; ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                          
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne<?php echo $listt['memberID']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $listt['memberID']; ?>">
                      <div class="panel-body">
                          <div class="panel-group" id="accordion<?php echo $listt['memberID']; ?>" role="tablist" aria-multiselectable="true">
                          <?php foreach($listt['child'] as $listtt){ ?>
                          <?php if($listtt['child']){ ?>
                          <div class="panel panel-default level-1">
                            <div class="panel-heading" role="tab" id="headingOne<?php echo $listt['memberID']; ?>">
                              <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $listt['memberID']; ?>" href="#collapseOne<?php echo $listtt['memberID']; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $listtt['memberID']; ?>">
                                  <i class="more-less fa fa-plus"></i>
                                  <?php if($listtt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listtt['name'].' ('.$listtt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listtt['name'].' ('.$listtt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } ?>
                                  
                                </a>
                              </h4>
                            </div>
                            <div id="collapseOne<?php echo $listtt['memberID']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $listtt['memberID']; ?>">
                              <div class="panel-body">
                                  <div class="panel-group" id="accordion<?php echo $listtt['memberID']; ?>" role="tablist" aria-multiselectable="true">
                                  <?php foreach($listtt['child'] as $listttt){ ?>
                                  <?php if($listttt['child']){ ?>
                                  <div class="panel panel-default level-1">
                                    <div class="panel-heading" role="tab" id="headingOne<?php echo $listttt['memberID']; ?>">
                                      <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $listtt['memberID']; ?>" href="#collapseOne<?php echo $listttt['memberID']; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $listttt['memberID']; ?>">
                                          <i class="more-less fa fa-plus"></i>
                                          <?php if($listttt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listttt['name'].' ('.$listttt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listttt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listttt['name'].' ('.$listttt['code'].')'; ?> </font>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listttt['total_unpaid']; ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                                          
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="collapseOne<?php echo $listttt['memberID']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $listttt['memberID']; ?>">
                                      <div class="panel-body">
                                          <div class="panel-group" id="accordion<?php echo $listttt['memberID']; ?>" role="tablist" aria-multiselectable="true">
                                          <?php foreach($listttt['child'] as $listtttt){ ?>
                                          <?php if($listtttt['child']){ ?>
                                          <div class="panel panel-default level-1">
                                            <div class="panel-heading" role="tab" id="headingOne<?php echo $listtttt['memberID']; ?>">
                                              <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $listttt['memberID']; ?>" href="#collapseOne<?php echo $listtttt['memberID']; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $listtttt['memberID']; ?>">
                                                  <i class="more-less fa fa-plus"></i>
                                                  <?php if($listtttt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listtttt['name'].' ('.$listtttt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtttt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listtttt['name'].' ('.$listtttt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtttt['total_unpaid']; ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                                                  
                                                  
                                                </a>
                                              </h4>
                                            </div>
                                            <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                                              <div class="panel-body">
                                                
                                            </div>
                                            </div>
                                          </div>
                                          <?php } else { ?>
                                          <div class="panel panel-default level-1">
                                            <div class="panel-heading" role="tab" id="heading<?php echo $listtttt['memberID']; ?>">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion<?php echo $listtttt['memberID']; ?>" href="#collapse<?php echo $listtttt['memberID']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $listtttt['memberID']; ?>">
                                                <?php if($listtttt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listtttt['name'].' ('.$listtttt['code'].')'; ?> </font>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtttt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listtttt['name'].' ('.$listtttt['code'].')'; ?> </font>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtttt['total_unpaid']; ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                                                  
                                                </a>
                                              </h4>
                                            </div>
                                          </div>
                                          <?php } ?>
                                          <?php } ?>
                                        </div>  
                                      </div>
                                    </div>
                                  </div>
                                  <?php } else { ?>
                                  <div class="panel panel-default level-1">
                                    <div class="panel-heading" role="tab" id="heading<?php echo $listtt['memberID']; ?>">
                                      <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion<?php echo $listtt['memberID']; ?>" href="#collapse<?php echo $listttt['memberID']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $listttt['memberID']; ?>">
                                          
                                          <?php if($listttt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listttt['name'].' ('.$listttt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listttt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listttt['name'].' ('.$listttt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listttt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listttt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listttt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listttt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listttt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listttt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listttt['total_unpaid']; ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                                          
                                        </a>
                                      </h4>
                                    </div>
                                  </div>
                                  <?php } ?>
                                  <?php } ?>
                                </div>  
                              </div>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="panel panel-default level-1">
                            <div class="panel-heading" role="tab" id="heading<?php echo $listtt['memberID']; ?>">
                              <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion<?php echo $listt['memberID']; ?>" href="#collapse<?php echo $listtt['memberID']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $listtt['memberID']; ?>">
                                <?php if($listtt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listtt['name'].' ('.$listtt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listtt['name'].' ('.$listtt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listtt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listtt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listtt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listtt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listtt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listtt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listtt['total_unpaid']; ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                                  
                                </a>
                              </h4>
                            </div>
                          </div>
                          <?php } ?>
                          <?php } ?>
                        </div>  
                      </div>
                    </div>
                  </div>
                  <?php } else { ?>
                  <div class="panel panel-default level-1">
                    <div class="panel-heading" role="tab" id="heading<?php echo $listt['memberID']; ?>">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion<?php echo $list['memberID']; ?>" href="#collapse<?php echo $listt['memberID']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $listt['memberID']; ?>">
                          
                          <?php if($listt['paid_status']){ ?>
                          <div class="col-md-12">
                            <font color="green"><?php echo $listt['name'].' ('.$listt['code'].')'; ?> </font>
                          </div>
                          
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listt['total_unpaid']; ?>
                            </div>
                          </div>
                          <?php } else { ?>
                          <div class="col-md-12">
                            <font color="red"><?php echo $listt['name'].' ('.$listt['code'].')'; ?> </font>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            Level - <?php echo $listt['level']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Downline - <?php echo $listt['total_downline']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Active - <?php echo $listt['total_downline_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Total Deactive - <?php echo $listt['total_downline_unpaid']; ?>
                            </div>
                          </div>
                          <div class="row member-detail-block">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-3">
                            Total Direct - <?php echo count($listt['child']); ?>
                            </div>
                            <div class="col-md-3">
                            Direct Active - <?php echo $listt['total_paid']; ?>
                            </div>
                            <div class="col-md-3">
                            Direct Deactive - <?php echo $listt['total_unpaid']; ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                          
                        </a>
                      </h4>
                    </div>
                  </div>
                  <?php } ?>
                  <?php } ?>
                </div>  
              </div>
            </div>
          </div>
          <?php } else { ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?php echo $list['memberID']; ?>">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $list['memberID']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $list['memberID']; ?>">
                <?php if($list['paid_status']){ ?>
                <div class="col-md-12">
                  <font color="green"><?php echo $list['name'].' ('.$list['code'].')'; ?> </font>
                </div>
                
                <div class="row member-detail-block">
                  <div class="col-md-3">
                  Level - <?php echo $list['level']; ?>
                  </div>
                  <div class="col-md-3">
                  Total Downline - <?php echo $list['total_downline']; ?>
                  </div>
                  <div class="col-md-3">
                  Total Active - <?php echo $list['total_downline_paid']; ?>
                  </div>
                  <div class="col-md-3">
                  Total Deactive - <?php echo $list['total_downline_unpaid']; ?>
                  </div>
                </div>
                <div class="row member-detail-block">
                  <div class="col-md-3">
                  
                  </div>
                  <div class="col-md-3">
                  Total Direct - <?php echo count($list['child']); ?>
                  </div>
                  <div class="col-md-3">
                  Direct Active - <?php echo $list['total_paid']; ?>
                  </div>
                  <div class="col-md-3">
                  Direct Deactive - <?php echo $list['total_unpaid']; ?>
                  </div>
                </div>
                <?php } else { ?>
                <div class="col-md-12">
                  <font color="red"><?php echo $list['name'].' ('.$list['code'].')'; ?> </font>
                </div>
                
                <div class="row member-detail-block">
                  <div class="col-md-3">
                  Level - <?php echo $list['level']; ?>
                  </div>
                  <div class="col-md-3">
                  Total Downline - <?php echo $list['total_downline']; ?>
                  </div>
                  <div class="col-md-3">
                  Total Active - <?php echo $list['total_downline_paid']; ?>
                  </div>
                  <div class="col-md-3">
                  Total Deactive - <?php echo $list['total_downline_unpaid']; ?>
                  </div>
                </div>
                <div class="row member-detail-block">
                  <div class="col-md-3">
                  
                  </div>
                  <div class="col-md-3">
                  Total Direct - <?php echo count($list['child']); ?>
                  </div>
                  <div class="col-md-3">
                  Direct Active - <?php echo $list['total_paid']; ?>
                  </div>
                  <div class="col-md-3">
                  Direct Deactive - <?php echo $list['total_unpaid']; ?>
                  </div>
                </div>
                
                <?php } ?>
                  
                </a>
              </h4>
            </div>
            
          </div>
          <?php } ?>
          <?php } ?>
          <?php } ?>

          

        </div><!-- panel-group -->


    </div>
    <div id="menu1" class="tab-pane fade">
      <div class="table-responsive-md">
                <table class="table border">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Level</th>
                      <th>Member</th>
                      <th>Mobile</th>
                      <th>Email</th>
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
            <td class="align-middle"><?php echo $list['mobile']; ?></td>
            <td class="align-middle"><?php echo $list['email']; ?></td>
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
    <div id="menu2" class="tab-pane fade">
      <div class="table-responsive-md">
                <table class="table border">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Level</th>
                      <th>Member</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($directActiveList){
            $i = 1;
                      foreach($directActiveList as $list){ 
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $i; ?>.</td>
                      <td class="align-middle"><?php echo $list['level']; ?></td>
                      <td class="align-middle"><?php echo $list['name'].' ('.$list['user_code'].')'; ?></td>
            <td class="align-middle"><?php echo $list['mobile']; ?></td>
            <td class="align-middle"><?php echo $list['email']; ?></td>
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
    <div id="menu3" class="tab-pane fade">
      <div class="table-responsive-md">
                <table class="table border">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Level</th>
                      <th>Member</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($directDeactiveList){
            $i = 1;
                      foreach($directDeactiveList as $list){ 
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $i; ?>.</td>
                      <td class="align-middle"><?php echo $list['level']; ?></td>
                      <td class="align-middle"><?php echo $list['name'].' ('.$list['user_code'].')'; ?></td>
            <td class="align-middle"><?php echo $list['mobile']; ?></td>
            <td class="align-middle"><?php echo $list['email']; ?></td>
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
    <div id="menu4" class="tab-pane fade">
      <div class="table-responsive-md">
                <table class="table border">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Level</th>
                      <th>Member</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($totalDownlineList){
            $i = 1;
                      foreach($totalDownlineList as $list){ 
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $i; ?>.</td>
                      <td class="align-middle"><?php echo $list['level']; ?></td>
                      <td class="align-middle"><?php echo $list['name'].' ('.$list['user_code'].')'; ?></td>
            <td class="align-middle"><?php echo $list['mobile']; ?></td>
            <td class="align-middle"><?php echo $list['email']; ?></td>
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
    <div id="menu5" class="tab-pane fade">
      <div class="table-responsive-md">
                <table class="table border">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Level</th>
                      <th>Member</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($totalActiveList){
            $i = 1;
                      foreach($totalActiveList as $list){ 
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $i; ?>.</td>
                      <td class="align-middle"><?php echo $list['level']; ?></td>
                      <td class="align-middle"><?php echo $list['name'].' ('.$list['user_code'].')'; ?></td>
            <td class="align-middle"><?php echo $list['mobile']; ?></td>
            <td class="align-middle"><?php echo $list['email']; ?></td>
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
    <div id="menu6" class="tab-pane fade">
      <div class="table-responsive-md">
                <table class="table border">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Level</th>
                      <th>Member</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($totalDeactiveList){
            $i = 1;
                      foreach($totalDeactiveList as $list){ 
                     ?>
                    <tr>
                      <td class="align-middle"><?php echo $i; ?>.</td>
                      <td class="align-middle"><?php echo $list['level']; ?></td>
                      <td class="align-middle"><?php echo $list['name'].' ('.$list['user_code'].')'; ?></td>
            <td class="align-middle"><?php echo $list['mobile']; ?></td>
            <td class="align-middle"><?php echo $list['email']; ?></td>
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
</div>
</div>
<?php } ?>
              
          </div>
        </div>
       
 
    </div>




