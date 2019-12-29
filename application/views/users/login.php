<!DOCTYPE html>
<html lang="en">
	<head>
		<title>PAPTRADE POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="http://localhost/paptrade-pos/">
		<link rel="shortcut icon" type="image/x-icon" href="http://localhost/paptrade-pos/assets/images/iconpap.png" />
		<script src="assets/jquery/1.11.1/jquery-1.11.1.min.js"></script>
		<link href="assets/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="assets/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<style type="text/css">
			img {
			    max-width:100%;
			    height:auto;
			}
		</style>
		<div class="container"> 
			<div style="margin-top:50px; text-align: center;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<img src="assets/images/paptrade.png">
				<h2>POS & Inventory System</h2>
			</div>

			<div id="loginbox" style="margin-top:40px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Sign In</div>
						<!--div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div-->
					</div>     

					<div style="padding-top:30px" class="panel-body" >

						<form action="" method="post" id="loginform" class="form-horizontal" role="form">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username">
							</div>
							<div style="margin-bottom: 25px; font-size: x-small;" class="has-error">
								<?php echo form_error('username', '<p class="help-block">','</p>'); ?>
							</div>


							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="login-password" type="password" class="form-control" name="password" placeholder="password">
							</div>
							<div style="margin-bottom: 25px; font-size: x-small;" class="has-error">
								<?php echo form_error('password', '<p class="help-block">','</p>'); ?>
							</div>

							<?php
								if(!empty($success_msg)){
									echo '<p class="status-msg success">'.$success_msg.'</p>';
								}elseif(!empty($error_msg)){
									echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
								}
							?>

							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<input type="submit" name="loginSubmit" value="Login" class="btn btn-success">
								</div>
							</div>
						</form>
					</div>                     
				</div>  
			</div>
		</div>
	</body>
</html>