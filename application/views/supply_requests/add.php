<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="base_url" content="<?= base_url();?><?= index_page();?>">
		<base href="<?= base_url();?><?= index_page();?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/paptrade-icon.png" />

	 	<link rel="stylesheet" type="text/css" href="assets/bootstrap/3.4.1/css/bootstrap.css">
	 	<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
	    <link rel="stylesheet" type="text/css" href="assets/materialicons/material-icons.css">
	 	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
		
    	<script src="assets/jquery/3.4.1/jquery.min.js"></script>
	</head>

	<body>
		<div>

			<?php $this->load->view('components/navbar'); ?>
			
			<div class="container-fluid">
				<div class="row">
			        
			        <?php $this->load->view('components/menu'); ?>

			        <div class="col-sm-10 col-md-10" id="page-content">
			            <h2 class="page-header">Add Supply Request</h2>

						<div class="row-pad"></div>

						<div class="row-pad"></div>

					    <div class="row">
						    <div class="col-md-12">
								<div id="add-req-item-container" class="container form-horizontal">
									<div class="form-group">
										<label class="control-label col-sm-2" for='item'>Item</label>
										<div class="col-sm-10">
											<select required="required" name="item" id="item_select" class="form-control">
												<option value=""></option>
												<?php foreach($items->result_array() as $r) {
													if(set_value('item_id') === $r['ITEM_ID']){
														echo '<option value="'.$r['ITEM_ID'].'" selected="selected">'.$r['ITEM'].'</option>';
													}else{
														echo '<option value="'.$r['ITEM_ID'].'">'.$r['ITEM'].'</option>';
													}
												} ?>
											</select>
											<?php echo form_error('item', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for='qty'>Quantity</label>
										<div class="col-sm-10">
											<input required="required" type="text" value="<?php echo set_value('qty'); ?>" name="qty" class="form-control">
											<?php echo form_error('qty', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
									    	<input type="button" id="add-req-item-btn" class="btn btn-primary btn-sm" value="Add to List">
									    </div>
									</div>
								</div>
							</div>
						</div>


						<div class="row-pad"></div>

						<div class="row-pad"></div>


						<div class="row">
						    <div class="col-md-12">
								<div id="request-container" class="container">
									<h4>Request Details</h4>
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
									<form id="process-submit-request" class="form-horizontal">
										<div class="form-group">
											<div class="col-sm-offset-5 col-sm-5">
												<input type="button" class="btn btn-secondary back-btn" value="Back">
										    	<input type="submit" name="submit_request" class="btn btn-sm btn-success" value="Submit">
										    </div>
										</div>
									</form>
								</div>
							</div>
						</div>
			        </div>
	    		</div>
	    	</div>
		</div>

		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var base_url = $("meta[name='base_url']").attr('content');

	    		$('#add-req-item-btn').on('click', function () {
				    var item_id = $('#add-req-item-container').find('select[name="item"]').val();
				    var item_dscp = $('#add-req-item-container').find('select[name="item"] option:selected').text();
					var qty = $('#add-req-item-container').find('input[name="qty"]').val();

					if(item_id == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text("Please select an item");
						$("#error_modal").modal('show');
					}else if(qty == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text("Please specify quantity");
						$("#error_modal").modal('show');
					}else{
						if (itemExist(item_id, qty) == false) {
							$("#requests-tbl tbody").append(
							'<tr>' +
								'<input name="id" type="hidden" value="'+ item_id +'">' +
								'<td>'+ item_dscp +'</td>' +
								'<td><input name="qty" type="text" value="'+qty+'" class="quantity-box" size="5"></td>' +
								'<td><span class="remove" style="font-size:12px;"><i class="glyphicon glyphicon-trash" title="Remove"></i></span></td>' +
							'</tr>'
							);
						}
						$('#add-req-item-container').find('select[name="item"]').val('');
						$('#add-req-item-container').find('select[name="item"] option:selected').text('');
						$('#add-req-item-container').find('input[name="qty"]').val('');
					}
				});


				$("#requests-tbl").on('click', '.remove',function() {
					var row = $(this).parents('tr');
					row.remove();
				})


				$("#process-submit-request").submit(function(e) {
					e.preventDefault();
					var row = $("#requests-tbl tbody tr").length;
					var requests = [];
					if (row) {
						for (i = 0; i < row; i++) {
							var r = $("#requests-tbl tbody tr").eq(i).find('td');
							var quantity = r.eq(1).find('input').val();
							var arr = {
									item_id : $("#requests-tbl tbody tr").eq(i).find('input[name="id"]').val(), 
									quantity : quantity
								};
							requests.push(arr);
						}

						var data = {};
						data['submit_requests'] = true;
						data['requests'] = requests;

						$.ajax({
							type : 'POST',
							data : data,
							url : base_url + '/supply_requests/add',
							success : function(data) { 
								if(data == 'OK'){
									$("#requests-tbl tbody").empty();
									$("#success_modal .modal-content .modal-body p.text-center").text("Successfully submitted request.");
									$("#success_modal").modal('show');
								}
							}
						})

						return;
					}
				})

				$('#success_modal').on('hide.bs.modal', function () {
					window.location.replace(base_url + '/supply_requests/branch');
				});


				function itemExist(itemID, qty) {
					var table = $("#requests-tbl tbody tr");
				 	var exist = false;
					$.each(table, function(index) {
						id = ($(this).find('[name="id"]').val());
						if (id == itemID) {
							qtyCol = $(this).find('[name="qty"]');
							qtyCol.val(parseInt(qtyCol.val()) + parseInt(qty));
							exist = true;
						}
					})

					return exist;
				}

				$('.back-btn').on('click', function () {
					<?php if(!isset($back_url)){ $back_url=''; } ?>
			       	var redirect = base_url + '/' + '<?= $back_url; ?>';
			        window.location.replace('<?= site_url('supply_requests/branch') ?>');
			    } );

			});
		</script>
	</body>
</html>