<nav class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="navbar-header">
		<?php
			if($this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
				echo '<a class="navbar-brand" href="'.site_url('/users/dashboard').'"><span><img id="logo" src="assets/images/paptrade-nav.png" height="40px"> <small>POS & Inventory System</small></span></a>';
			}else{
				echo '<a class="navbar-brand"><span><img src="assets/images/paptrade-nav.png" height="40px"> <small>POS & Inventory System</small></span></a>';
			}
		?>
	</div>
	<div style="margin-right: 50px;">
		<ul class="nav navbar-top-links navbar-right">
			<?php
				if($this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
					if(in_array('POS', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
						echo '<li class="nav-item">';
						echo '	<a class="nav-link" href="'.site_url('/pos').'">POS</a>';
						echo '</li>';
					}
				}
			?>
			<li class="nav-item">
				<a class="nav-link" href="<?= site_url('/users/logout') ?>">Logout</a>
			</li>
		</ul>
	</div>
</nav>