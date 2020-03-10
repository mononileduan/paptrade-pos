		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">Items</h1>
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
										<label for='brand_id'>Brand</label>
										<select required="required" name="brand_id" class="form-control">
											<option value=""></option>
											<?php foreach($brands->result_array() as $r) {
												if(set_value('brand_id') === $r['ID']){
													echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRAND'].'</option>';
												}else{
													echo '<option value="'.$r['ID'].'">'.$r['BRAND'].'</option>';
												}
											} ?>
										</select>
										<?php echo form_error('brand_id', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<label for='dscp'>Description</label>
										<input required="required" type="text" value="<?php echo set_value('dscp'); ?>" name="dscp" class="form-control">
										<?php echo form_error('dscp', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<label for='category_id'>Category</label>
										<select required="required" name="category_id" class="form-control">
											<option value=""></option>
											<?php foreach($categories->result_array() as $r) {
												if(set_value('category_id') === $r['ID']){
													echo '<option value="'.$r['ID'].'" selected="selected">'.$r['CATEGORY'].'</option>';
												}else{
													echo '<option value="'.$r['ID'].'">'.$r['CATEGORY'].'</option>';
												}
											} ?>
										</select>
										<?php echo form_error('category_id', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<label for='critical_qty'>Critical Quantity</label>
										<input required="required" type="text" value="<?php echo set_value('critical_qty'); ?>" name="critical_qty" class="form-control">
										<?php echo form_error('critical_qty', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<label for='stock_type_id'>Stock Type</label>
										<select required="required" name="stock_type_id" class="form-control">
											<option value=""></option>
											<?php foreach($stock_types->result_array() as $r) {
												if(set_value('stock_type_id') === $r['ID']){
													echo '<option value="'.$r['ID'].'" selected="selected">'.$r['STOCK_TYPE'].'</option>';
												}else{
													echo '<option value="'.$r['ID'].'">'.$r['STOCK_TYPE'].'</option>';
												}
											} ?>
										</select>
										<?php echo form_error('stock_type_id', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<label for='stock_type_content'>Stock Type Content</label>
										<input required="required" type="text" value="<?php echo set_value('stock_type_content'); ?>" name="stock_type_content" class="form-control">
										<?php echo form_error('stock_type_content', '<p class="help-block">','</p>'); ?>
									</div>
								
									<div class="form-group">
										<input type="submit" name="submit_item" class="btn btn-sm btn-success" value="Submit">
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
								<td width="15%">Brand</td>
								<td width="40%">Description</td>
								<td width="20%">Category</td>
								<td width="5%">Critical Quantity</td>
								<td width="10%">Stock Type</td>
								<td width="5%">Stock Type Content</td>
								<td width="5%"></td>
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

