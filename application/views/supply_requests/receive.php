		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">View Supply Request</h1>
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

				<?php 
				if($req['STATUS'] == 'APPROVED' || $req['STATUS'] == 'RECEIVED'){

					echo '<dt class="col-sm-3">Approved Quantity</dt>';
					echo '<dd class="col-sm-9">'.$req['APPROVED_QTY'].'</dd>';
					
					echo '<dt class="col-sm-3">Processed By</dt>';
					echo '<dd class="col-sm-9">'.$req['PROCESSED_BY'].'</dd>';
					
					echo '<dt class="col-sm-3">Date Processed</dt>';
					echo '<dd class="col-sm-9">'.$req['PROCESSED_DT'].'</dd>';
				}

				if($req['STATUS'] == 'RECEIVED'){
					echo '<dt class="col-sm-3">Received By</dt>';
					echo '<dd class="col-sm-9">'.$req['RECEIVED_BY'].'</dd>';
					
					echo '<dt class="col-sm-3">Date Received</dt>';
					echo '<dd class="col-sm-9">'.$req['RECEIVED_DT'].'</dd>';
				}
				?>
			</dl>

		    <div class="row">
			    <div class="col-md-12">
					
					<form action="" method="post" accept-charset="utf-8">
						<div class="form-group">
							<input type="hidden" name="id" value="<?= $req['ID']; ?>">
							<input type="hidden" name="approved_qty" value="<?= $req['APPROVED_QTY']; ?>">
							<input type="button" class="btn btn-secondary back-btn" value="Back">
							<?php
							if($req['STATUS'] == 'APPROVED'){
								echo '<input type="submit" name="submit_receive_request" class="btn btn-success" value="Receive">';
							}
							?>
						</div>
					</form>
				</div>
			</div>
		</div>

    </div>
</div>