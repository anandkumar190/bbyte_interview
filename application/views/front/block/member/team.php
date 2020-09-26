  <section class="page-header page-header-text-light bg-primary">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1>My Team</h1>
        </div>
        <div class="col-md-4">
          <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
            <li><a href="{site_url}home">Home</a> / My Team</li>
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
			<div class="col-md-12">
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
			</div>
            <!-- Personal Information end --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
