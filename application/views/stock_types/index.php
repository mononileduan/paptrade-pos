		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">Stock Types</h1>
				</div>
			</div>

			<div class="row-pad"></div>

			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<a href="#add_container" class="btn btn-primary btn-sm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class='fas fa-plus'></i> Add New</a>
						</div>
					</div>

					<div class="row-pad"></div>

					<div class="row collapse <?php if(!empty($error_msg)){echo 'show';} ?> border border-primary rounded" id="add_container" style="padding-top: 10px;">
						<div class="col-md-12">
							<div class="col-md-12">
								<form action="" method="post" accept-charset="utf-8">
									<div class="form-group">
										<label for='stock_type'>Stock Type</label>
										<input required="required" type="text" value="<?php echo set_value('stock_type'); ?>" name="stock_type" class="form-control">
										<?php echo form_error('stock_type', '<p class="help-block">','</p>'); ?>
									</div>
									
									<div class="form-group">
										<input type="submit" name="submit_stock_type" class="btn btn-sm btn-success" value="Submit">
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="row-pad"></div>

			<div class="row-pad"></div>

		    <div class="row">
			    <div class="col-md-12">
					<table id="view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
						<thead>
							<tr>
								<td></td>
								<td>Stock Type</td>
								<td></td>
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

