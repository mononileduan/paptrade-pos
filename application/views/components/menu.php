<div class="col-sm-3 col-md-2">
	<div id="left-menu-container">
		<div id="login-info-container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse-login-info"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Login Info</a>
					</h4>
				</div>
				<div id="collapse-login-info" class="panel-collapse collapse in">
					<div class="panel-body login-info-panel">
						<table class="table login-info-table">
							<tr>
								<td>
									<small><span class="glyphicon glyphicon-user"></span>&nbsp; <?=$this->session->userdata('fullname')?></small>
								</td>
							</tr>
							<tr>
								<td>
									<small><span class="glyphicon glyphicon-briefcase"></span>&nbsp; <?=$this->session->userdata('user_role_dscp')?></small>
								</td>
							</tr>
							<tr>
								<td>
									<small><span class="glyphicon glyphicon-map-marker"></span>&nbsp; <?=$this->session->userdata('branch')?></small>
								</td>
							</tr>
							<tr>
								<td>
									<small><span class="glyphicon glyphicon-calendar"></span>&nbsp; <?=date($this->session->userdata('last_login_dt'))?></small>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
			</div>
	    </div>


	    <div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="<?= site_url('/users/dashboard') ?>"><span class="glyphicon glyphicon-dashboard"></span>&nbsp; Dashboard</a>
					</h4>
				</div>
			</div>

			<?php
			if(in_array('MAINTENANCE', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				echo '	<div class="panel panel-default">';
				echo '		<div class="panel-heading">';
				echo '			<h4 class="panel-title">';
				echo '				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-wrench"></span>&nbsp; Maintenance</a>';
				echo '			</h4>';
				echo '		</div>';
				echo '		<div id="collapseOne" class="panel-collapse collapse">';
				echo '			<div class="panel-body">';
				echo '				<table class="table">';

				if(in_array('BRAND', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/brands') .'">Brand</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('CATEGORY', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/categories') .'">Category</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('STOCK_TYPE', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/stock_types') .'">Stock Type</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('ITEM', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/items') .'">Item</a>';
					echo '						</td>';
					echo '					</tr>';
				}
				
				echo '				</table>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';

			}
			


			if(in_array('WAREHOUSE_FXN', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				echo '	<div class="panel panel-default">';
				echo '		<div class="panel-heading">';
				echo '			<h4 class="panel-title">';
				echo '				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Warehouse</a>';
				echo '			</h4>';
				echo '		</div>';
				echo '		<div id="collapseTwo" class="panel-collapse collapse">';
				echo '			<div class="panel-body">';
				echo '				<table class="table">';

				if(in_array('WH_INVENTORY', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/warehouse_inventories') .'">Inventory</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('WH_INVENTORY_ARCHIVE', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/warehouse_inventories/archived') .'">Inventory Archive</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('WH_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/supply_requests/warehouse') .'">Supply Request</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				echo '				</table>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';
			}


	 


			if(in_array('BRANCH_FXN', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				echo '	<div class="panel panel-default">';
				echo '		<div class="panel-heading">';
				echo '			<h4 class="panel-title">';
				echo '				<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-map-marker"></span>&nbsp; Branch</a>';
				echo '			</h4>';
				echo '		</div>';
				echo '		<div id="collapseThree" class="panel-collapse collapse">';
				echo '			<div class="panel-body">';
				echo '				<table class="table">';

				if(in_array('BR_INVENTORY', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/branch_inventories') .'">Inventory</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('BR_INVENTORY_ARCHIVE', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/branch_inventories/archived') .'">Inventory Archive</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('BR_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/supply_requests/branch') .'">Supply Request</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				echo '				</table>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';

			}

			

			

			if(in_array('REPORTS', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				echo '	<div class="panel panel-default">';
				echo '		<div class="panel-heading">';
				echo '			<h4 class="panel-title">';
				echo '				<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file"></span>&nbsp; Reports</a>';
				echo '			</h4>';
				echo '		</div>';
				echo '		<div id="collapseFour" class="panel-collapse collapse">';
				echo '			<div class="panel-body">';
				echo '				<table class="table">';

				if(in_array('SALES', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'. site_url('/sales') .'">&nbsp; Sales</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				echo '				</table>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';

			}

			

			
			if(in_array('ADMIN', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				echo '	<div class="panel panel-default">';
				echo '		<div class="panel-heading">';
				echo '			<h4 class="panel-title">';
				echo '				<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-cog"></span>&nbsp; Administration</a>';
				echo '			</h4>';
				echo '		</div>';
				echo '		<div id="collapseFive" class="panel-collapse collapse">';
				echo '			<div class="panel-body">';
				echo '				<table class="table">';
				
				if(in_array('BRANCH', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'.site_url('/branches').'">Branch</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				if(in_array('USER', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					echo '					<tr>';
					echo '						<td>';
					echo '							<a href="'.site_url('/users').'">User</a>';
					echo '						</td>';
					echo '					</tr>';
				}

				echo '				</table>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';
			}

			?>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"><span class="glyphicon glyphicon-user"></span>&nbsp; Account</a>
					</h4>
				</div>
				<div id="collapseSix" class="panel-collapse collapse">
					<div class="panel-body">
						<table class="table">
							<tr>
								<td>
									<a href="<?= site_url('/users/chpass') ?>">Change Password</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="<?= site_url('/users/logout') ?>">Logout</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


