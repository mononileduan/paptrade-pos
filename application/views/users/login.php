<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="<?= site_url() ?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/paptrade-icon.png" />

	 	<link rel="stylesheet" type="text/css" href="assets/bootstrap/3.4.1/css/bootstrap.css">
	 	<link rel="stylesheet" type="text/css" href="assets/login/login.css">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-default panel-offset login-panel">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="logo-container">
										<img class="logo" src="assets/login/images/paptrade.png">
										<h2><strong>POS & Inventory System</strong></h2>
									</div>
								</div>

								<div class="col-md-6">
									<div class="login-box">
										<h3>Login to your account</h3>
										<form action="" method="post" id="loginform" class="form-horizontal" role="form" autocomplete="off">

											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
												<input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username">
											</div>
											<div style="margin-bottom: 15px; font-size: x-small;" class="has-error">
												<?php echo form_error('username', '<p class="help-block">','</p>'); ?>
											</div>


											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
												<input id="login-password" type="password" class="form-control" name="password" placeholder="password">
											</div>
											<div style="margin-bottom: 15px; font-size: x-small;" class="has-error">
												<?php echo form_error('password', '<p class="help-block">','</p>'); ?>
											</div>

											<div style="margin-top:10px" class="form-group">
												<div class="col-sm-12 controls">
													<input type="submit" name="loginSubmit" value="Login" class="btn btn-primary form-control">
												</div>
											</div>

											<?php
												if(!empty($success_msg)){
													echo '<p class="status-msg success">'.$success_msg.'</p>';
												}elseif(!empty($error_msg)){
													echo '<p class="alert alert-danger col-sm-12"><i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp; '.$error_msg.'</p>';
												}
											?>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>