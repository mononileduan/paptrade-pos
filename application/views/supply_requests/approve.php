		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">Approve Supply Request</h1>
				</div>
			</div>

			<div class="row-pad"></div>

			<div class="row-pad"></div>

			<dl class="row">
				<dt class="col-sm-3">Item</dt>
				<dd class="col-sm-9"><?= $req['ITEM']; ?></dd>

				<dt class="col-sm-3">Quantity</dt>
				<dd class="col-sm-9"><?= $req['QTY']; ?></dd>

				<dt class="col-sm-3">Branch</dt>
				<dd class="col-sm-9"><?= $req['BRANCH']; ?></dd>
				
				<dt class="col-sm-3">Requested By</dt>
				<dd class="col-sm-9"><?= $req['REQUESTED_BY']; ?></dd>
				
				<dt class="col-sm-3">Request Date</dt>
				<dd class="col-sm-9"><?= $req['REQUESTED_DT']; ?></dd>
			</dl>

		    

		    <div class="row">
			    <div class="col-md-12">
					
					<form action="" method="post" accept-charset="utf-8">
						<dl class="row">
							<dt class="col-sm-3">Available Stocks</dt>
							<dd class="col-sm-9"><?php if(isset($wh_item['AVAILABLE_QTY'])){ echo $wh_item['AVAILABLE_QTY']; } else { echo '0'; } ?></dd>

							<dt class="col-sm-3"><label class="form-label">Approved Quantity</label></dt>
							<dd class="col-sm-9"><input required="required" type="text" value="<?php echo set_value('approved_qty'); ?>" name="approved_qty" class="form-control" maxlength="5" size="5"></dd>
						</dl>				
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