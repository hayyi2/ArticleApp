		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<?php get_message_flash() ?>
				<form class="panel panel-default" method="post" action="<?php url('user/login') ?>">
					<?php token() ?>
					<?php if (isset($go)): ?>
						<input type="hidden" name="go" value="<?php echo($go) ?>">
					<?php endif ?>
					<div class="panel-heading">
						<h4>Form Login</h4>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Username</label>
							<input type="text" class="form-control" name="username" placeholder="Username" autofocus="" required="">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" placeholder="Password" required="">
						</div>
						<!-- <div class="checkbox">
							<label>
								<input type="checkbox" name="remember"> Remember me
							</label>
						</div> -->
					</div>
					<div class="panel-footer">
						<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-sign-in"></i> Login</button>
						<a href="<?php url('member/register') ?>" class="btn btn-default"><i class="fa fa-fw fa-user-plus"></i> Register</a>
					</div>
				</form>
			</div>
		</div>