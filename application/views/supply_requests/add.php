<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Centralized Sales & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="base_url" content="<?= base_url() ?>">
		<meta name="index_page" content="<?= index_page() ?>">
		<meta name="user" content="<?=$this->session->userdata('fullname')?>">
		<base href="<?= site_url() ?>">
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
			
			<div class="container-fluid with-color-accent">

				<div class="row">
			        
			        <?php $this->load->view('components/menu'); ?>

			        <div class="col-sm-10 col-md-10" id="page-content">
			            <h2 class="page-header">Supply Request</h2>
			            <div class="margin-left-20px">
				            <div class="row">
								<div class="col-md-5">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Select Item from Warehouse</span>
											</h4>
										</div>
										<div class="panel-body">
											<table id="item-table" class="table table-bordered table-striped table-hover" style="width:100%">
												<thead>
													<tr>
														<th>ID</th>
														<th>Item ID</th>
														<th>Item</th>
														<th>Category</th>
														<th>Warehouse Avail. Qty</th>
														<th>Warehouse Crit. Qty</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-list"></span>&nbsp; List</span>
											</h4>
										</div>
										<div class="panel-body">
											<div class="row">
											    <div class="col-md-12">
													<div id="request-container">
														<table id="requests-tbl" class="table table-bordered table-hover" style="width:100%">
															<thead>
																<tr>
																	<th width="70%">Item</th>
																	<th width="20%" class="text-right">Quantity</th>
																	<th width="10%"> </th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
														<form id="process-submit-request" class="form-horizontal">
															<input type="submit" name="submit_request" class="btn btn-sm btn-primary" value="Submit">
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<input type="button" class="btn btn-sm btn-secondary back-btn" value="Back">
			            </div>
			        </div>
	    		</div>
	    	</div>
		</div>

		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var base_url = $("meta[name='base_url']").attr('content');
				var index_page = $("meta[name='index_page']").attr('content');
				var user = $("meta[name='user']").attr('content');

				var item_table = $('#item-table').DataTable({
			        "ajax": {
			            url : index_page + '/supply_requests/wh_item_list',
			            type : 'GET'
			        },
					"order": [[ 2, "asc" ]],
			        "columnDefs": [
			        	{className: "dt-right", "targets": [-1, -2] },
			        	{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [-1] },
			        	{"targets": [ 0, 1 ], "visible": false, "searchable": false},
			        	{"targets": [ -1 ], "orderable": false}
			        ],
			        "createdRow": function( row, data, dataIndex){
		                if( parseInt(data[4]) <= parseInt(data[5]) ){
		                    $(row).addClass('critical');
		                    $(row).attr('title', "This item's warehouse stock count is in critical level.");
		                }
		            }
			    });


		        $("#item-table").on('click', 'tbody tr', function(event) {
			    	var data = $("#item-table").DataTable().row( $(this) ).data();
					var item_id = data[1];
					var item = data[2];
					var category = data[3];
					var avail = data[4];
					var crit = data[5];
					var stockCol = $(this).find('td').eq(2);
					var stocks = stockCol.text();
					var qty = 1;
					
				 	if ( parseInt(stocks.split(' ').join('')) > 0 ) {
				 		if (item_id && item && stocks) {
							if (itemExist(item_id, qty) == false) {
								if(parseInt(avail) <= parseInt(crit)){
									$("#requests-tbl tbody").append(
									'<tr class="critical" title="This item\'s warehouse stock count is in critical level.">' +
										'<input name="id" type="hidden" value="'+ item_id +'">' +
										'<td>'+ item +'</td>' +
										'<td class="text-right"><input name="qty" type="text" value="'+qty+'" class="quantity-box text-right" size="5"></td>' +
										'<td><a class="remove" style="font-size:12px;"><i class="glyphicon glyphicon-trash" title="Remove"></i></a></td>' +
									'</tr>'
									);
								}else{
									$("#requests-tbl tbody").append(
									'<tr>' +
										'<input name="id" type="hidden" value="'+ item_id +'">' +
										'<td>'+ item +'</td>' +
										'<td class="text-right"><input name="qty" type="text" value="'+qty+'" class="quantity-box text-right" size="5"></td>' +
										'<td><a class="remove" style="font-size:12px;"><i class="glyphicon glyphicon-trash" title="Remove"></i></a></td>' +
									'</tr>'
									);
								}
								
							}
				  	 	}
				 	}
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
							url : '<?= site_url('/supply_requests/add') ?>',
							success : function(data) { 
								if(data.startsWith('OK')){
									$("#requests-tbl tbody").empty();
									$("#success_modal .modal-content .modal-body p.text-center").text("Successfully submitted request. Ref. No.: " + data.substring(2));
									$("#success_modal").modal('show');
								}
							}
						})

						return;
					}
				})

				$('#success_modal').on('hide.bs.modal', function () {
					window.location.replace('<?= site_url('supply_requests/branch') ?>');
				});



				$('.back-btn').on('click', function () {
			        window.location.replace('<?= site_url('supply_requests/branch') ?>');
			    } );

			});
		</script>
	</body>
</html>