		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">Add Supply Request</h1>
				</div>
			</div>


			<div class="row-pad"></div>

			<div class="row-pad"></div>

		    <div class="row">
			    <div class="col-md-12" id="add-req-item-container">
			    	<div class="form-group">
						<label for='item'>Item</label>
						<select required="required" name="item" class="form-control">
							<option value=""></option>
							<?php foreach($items->result_array() as $r) {
								if(set_value('item_id') === $r['ITEM_ID']){
									echo '<option value="'.$r['ITEM_ID'].'" selected="selected">'.$r['ITEM'].'</option>';
								}else{
									echo '<option value="'.$r['ITEM_ID'].'">'.$r['ITEM'].'</option>';
								}
							} ?>
						</select>
						<?php echo form_error('item_id', '<p class="help-block">','</p>'); ?>
					</div>
					<div class="form-group">
						<label for='qty'>Quantity</label>
						<input required="required" type="text" value="<?php echo set_value('qty'); ?>" name="qty" class="form-control">
						<?php echo form_error('qty', '<p class="help-block">','</p>'); ?>
					</div>
					<div class="form-group">
						<input type="button" id="add-req-item-btn" class="btn btn-secondary btn-sm" value="Add to List">
					</div>
				</div>
			</div>

			<div class="row-pad"></div>

			<div class="row-pad"></div>

		    <div class="row">
			    <div class="col-md-12">
			    	<div id="request-container">
			    		<h4><small>Request Details</small></h4>
            			<table id="requests-tbl" class="table table-bordered table-striped table-hover" style="width:100%">
							<thead>
								<tr>
									<th width="70%">Item</th>
									<th width="20%">Quantity</th>
									<th width="10%"> </th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<form id="process-submit-request">
						<div class="form-group">
							<input type="submit" id="add-req-item-submit-btn" class="btn btn-success btn-sm" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>

    </div>
</div>