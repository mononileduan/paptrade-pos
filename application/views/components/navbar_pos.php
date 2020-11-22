<nav class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?= site_url('/users/dashboard') ?>"><span><img src="assets/images/paptrade-nav.png" height="40px"> <small>Centralized Sales & Inventory System</small></span></a>
	</div>
	<div style="margin-right: 50px;">
		<ul class="nav navbar-top-links navbar-right">
			<li class="nav-item">
				<label><dfn><?= $this->config->item('USER_ROLE_ASSOC')[$this->session->userdata('user_role')][1] ?>:&nbsp;</dfn></label><span><?= $this->session->userdata('fullname') ?></span>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= site_url('/users/logout') ?>">Logout</a>
			</li>
		</ul>
	</div>
</nav>