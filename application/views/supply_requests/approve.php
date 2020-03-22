		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">Approve Supply Request</h1>
				</div>
			</div>

			<div class="row-pad"></div>

			<div class="row-pad"></div>

		    <div class="row">
			    <div class="col-md-12">
					<div class="form-group">
						<label>Branch</label>
						<span><?= $req['BRANCH']; ?></span>
					</div>
					<div class="form-group">
						<label>Item</label>
						<span><?= $req['ITEM']; ?></span>
					</div>
					<div class="form-group">
						<label>Quantity</label>
						<span><?= $req['QTY']; ?></span>
					</div>
					<div class="form-group">
						<label>Requested By</label>
						<span><?= $req['REQUESTED_BY']; ?></span>
					</div>
					<div class="form-group">
						<label>Request Date</label>
						<span><?= $req['REQUESTED_DT']; ?></span>
					</div>
				</div>
			</div>

		    <div class="row">
			    <div class="col-md-12">
					
					<form action="" method="post" accept-charset="utf-8">
						<div class="form-group">
							<label>Available Stocks</label>
							<span><?php if(isset($wh_item['AVAILABLE_QTY'])){ echo $wh_item['AVAILABLE_QTY']; } else { echo '0'; } ?></span>
						</div>
						<div class="form-group">
							<label>Approved Quantity</label>
							<input required="required" type="text" value="<?php echo set_value('approved_qty'); ?>" name="approved_qty" class="form-control">
							<?php echo form_error('approved_qty', '<p class="help-block">','</p>'); ?>
						</div>						
						<div class="form-group">
							<input type="hidden" name="id" value="<?= $req['ID']; ?>">
							<input type="button" class="btn btn-secondary back-btn" value="Back">
							<input type="submit" name="submit_approve_request" class="btn btn-success" value="Approve">
						</div>
					</form>
				</div>
			</div>
		</div>

    </div>
</div>