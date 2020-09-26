<section class="login-container boxed-login">
	<div class="container">
		<?php echo $this->session->flashdata('message'); ?>
		<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
			<div class="login-form-container">
				<?= form_open('login/validateUser', array("class" => 'j-forms', "id" => 'forms-login')); ?>
					<div class="login-form-header">
						<div class="logo"> <a href="javascript:void(0);" title=""></a> </div>
					</div>
					<div class="login-form-content">
						<div class="unit">
							<div class="input login-input">
								<label class="icon-left" for="login"> <i class="zmdi zmdi-account"></i> </label>
								<input class="form-control login-frm-input" type="text" id="login" name="username" placeholder="Username / Email">
							</div>
						</div>
						<div class="unit">
							<div class="input login-input">
								<label class="icon-left" for="password"> <i class="zmdi zmdi-key"></i> </label>
								<input class="form-control login-frm-input" type="password" id="password" name="password" placeholder="Password">
							</div>
						</div>
                        <span class="hint"> <a href="javascript:void(0);" class="link text-info">Forgot password?</a></span>
					</div>
					<div class="login-form-footer text-center">
                        <span class="text-danger response"></span>
						<button type="button" class="btn-block btn btn-primary" id="sign-in">Sign in</button>
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
	<footer class="login-page-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
					<div class="footer-content"> </div>
				</div>
			</div>
		</div>
	</footer>
</section>
