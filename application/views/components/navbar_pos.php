<nav class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?= site_url('/users/dashboard') ?>"><span><img src="assets/images/paptrade-nav.png" height="40px"> <small>Centralized Sales & Inventory System</small></span></a>
	</div>
	<div style="margin-right: 50px;">
		<ul class="nav navbar-top-links navbar-right">
			<li class="nav-item">
				<label><dfn><?= $this->config->item('USER_ROLE_ASSOC')[$this->session->userdata('user_role')][1] ?>:&nbsp;
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span><?= $this->session->userdata('fullname') ?></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="<?= site_url('/users/chpass') ?>"><span>Change Password</span></a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?= site_url('/users/logout') ?>">Logout</a>
				</div>
			</li>
		</ul>
	</div>
</nav>