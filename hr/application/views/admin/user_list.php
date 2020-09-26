
	<div class="row">
		<div class="col-md-12">
			<div class="widget-wrap  material-table-widget">
				<div class="widget-container margin-top-0">
					<div class="widget-content">
						<div class="data-action-bar">
							<div class="row">
								<div class="col-md-6">
									<div class="widget-header">
										<h3>User List</h3>
									</div>
								</div>
								<div class="col-md-6">
									<div class="widget-header text-right">
										<button type="button" onclick="showAjaxModal('<?= base_url('modal/popup/add_user/save'); ?>');" class="btn add-row btn-primary"> <i class="fa fa-plus"></i> Add User </button>
									</div>
								</div>
							</div>
						</div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-list-data">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
