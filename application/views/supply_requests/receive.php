		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">View Supply Request</h1>
				</div>
			</div>

			<div class="row-pad"></div>

			<div class="row-pad"></div>

		    <div class="row">
			    <div class="col-md-12">
					<div class="form-group">
						<label>Item</label>
						<span><?= $req['ITEM']; ?></span>
					</div>
					<div class="form-group">
						<label>Quantity</label>
						<span><?= $req['QTY']; ?></span>
					</div>
					<div class="form-group">
						<label>Branch</label>
						<span><?= $req['BRANCH']; ?></span>
					</div>
					<div class="form-group">
						<label>Requested By</label>
						<span><?= $req['REQUESTED_BY']; ?></span>
					</div>
					<div class="form-group">
						<label>Request Date</label>
						<span><?= $req['REQUESTED_DT']; ?></span>
					</div>
					<?php 
					if($req['STATUS'] == 'APPROVED' || $req['STATUS'] == 'RECEIVED'){
						echo '<div class="form-group">';
						echo '	<label>Approved Quantity</label>';
						echo '	<span>'.$req['APPROVED_QTY'].'</span>';
						echo '</div>';
						echo '<div class="form-group">';
						echo '	<label>Processed By</label>';
						echo '	<span>'.$req['PROCESSED_BY'].'</span>';
						echo '</div>';
						echo '<div class="form-group">';
						echo '	<label>Date Processed</label>';
						echo '	<span>'.$req['PROCESSED_DT'].'</span>';
						echo '</div>';
					
					}

					if($req['STATUS'] == 'RECEIVED'){
						echo '<div class="form-group">';
						echo '	<label>Received By</label>';
						echo '	<span>'.$req['RECEIVED_BY'].'</span>';
						echo '</div>';
						echo '<div class="form-group">';
						echo '	<label>Date Received</label>';
						echo '	<span>'.$req['RECEIVED_DT'].'</span>';
						echo '</div>';
					}

					?>					
				</div>
			</div>

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