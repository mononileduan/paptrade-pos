<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">Branch Supply Requests</h1>
		</div>
	</div>

	<div class="row-pad"></div>

	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Requesting Branch</th>
						<th>Item Count</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach($branches->result_array() as $r) {
							echo '<tr>';
							echo '	<td>'.$r['BRANCH_NAME'].'</td>';
							echo '	<td>'.$r['ITEM_COUNT'].'</td>';
							echo '	<td><input type="hidden" value="'.$r['BRANCH_ID'].'"><button type="button" class="btn btn-info btn-sm open-dialog" data-id="'.$r['BRANCH_ID'].'" data-toggle="modal" data-target="#request_modal">View Details</button></td>';
							echo '</tr>	';
						}
					?>
										
				</tbody>
			</table>
		</div>
	</div>

</div>






<!-- FOOTER -->
	        </div>
		</div>

		<div class="modal" tabindex="-1" role="dialog" id="request_modal">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Branch Requests</h5>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-7">
								<table class="table table-bordered table-striped table-hover" id="pending_table">
									<thead>
										<tr>
											<th width="80%">Item</th>
											<th width="10%">Stocks</th>
											<th width="10%">Request</th>
											<th width="5%"></th>
										</tr>
									</thead>
									<tbody id="dtl_container">
										<tr>
											<td colspan="4">
												<div >
													No data
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-5">
								<table class="table table-bordered table-striped table-hover" id="approved_table">
									<thead>
										<tr>
											<th width="80%">Item</th>
											<th width="10%">Quantity</th>
											<th width="10%"></th>
										</tr>
									</thead>
									<tbody id="approved_container">
										
															
									</tbody>
								</table>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="row">
							<div class="col-md-12">
								<form id="process_request_form">
									<div class="form-group">
										<input type="submit" class="btn btn-success form-control" name="" value="Approve" id="btn" >
									</div>
								</form>
							</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>

				</div>

			</div>
		</div>

		<div class="modal" tabindex="-1" role="dialog" id="quantity_modal">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Quantity</h5>
					</div>
					<div class="modal-body">
						
						<input type="text" name="quantity">
						<div class="clearfix"></div>

					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>

				</div>

			</div>
		</div>

	    <script src="assets/fontawesome/5.0.13/js/solid.js"></script>
	    <script src="assets/fontawesome/5.12.0/js/fontawesome.min.js"></script>

	    <!-- Popper.JS -->
	    <script src="assets/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	    <!-- Bootstrap JS -->
	    <script src="assets/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	    <script type="text/javascript">
	        $(document).ready(function () {
	            $('#sidebarCollapse').on('click', function () {
	                $('#sidebar').toggleClass('active');
	                $(this).toggleClass('active');
	            });
	        });
	    </script>


	    <script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/dataTables.buttons.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.bootstrap4.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="assets/datepicker/gijgo/js/gijgo.min.js"></script>

	    <script type="text/javascript">
			$(document).ready(function() {
				var base_url = $("meta[name='base_url']").attr('content');

				$('.open-dialog').click(function(){
					var branch_id = $(this).data('id');
					$.ajax({
	                    url : "<?php echo site_url('branch_supply_requests/get_dtls_by_branch_id');?>",
	                    method : "GET",
	                    data : {id: branch_id},
	                    async : true,
	                    dataType : 'json',
	                    success: function(data){
	                         
	                        var html = '';
	                        var i;
	                        
	                        for(i=0; i<data.length; i++){
	                        	html += '<tr>';
	                        	html += '<td>'+data[i].ITEM+'</td>';
	                        	html += '<td>'+data[i].STOCKS+'</td>';
	                        	html += '<td>'+data[i].QUANTITY+'</td>';
	                        	html += '<td><input type="hidden" name="id" value="'+data[i].ID+'"><i class="fas fa-angle-right"></i></td>';
	                       		html += '</tr>';
	                        }
	                        $('#dtl_container').html(html);
	 						$('#approved_container').html('');
	                    }
	                });
				});

				$("#pending_table").on('click', 'tbody tr', function(event) {
					var item = $(this).find('td').eq(0).text();
					var stockCol = $(this).find('td').eq(1);
					var stocks = stockCol.text();
					var requestCol = $(this).find('td').eq(2);
					var requests = requestCol.text();
					var id = $(this).find('[name="id"]').val();

				
				 	if ( parseInt(stocks.split(' ').join('')) > 0  && parseInt(stocks.split(' ').join('')) > parseInt(requests.split(' ').join(''))) {
				 		if (item && stocks && requests) {
				  	 		if (itemExist(id,stocks) == false) {
					  	 		var quantity = requests;
							 	
								$("#approved_table tbody").append(
									'<tr>' +
										'<input name="id" type="hidden" value="'+ id +'">' +
										'<td>'+ item +'</td>' +
										'<td><input data-stocks="'+stocks+'" data-remaining="'+stocks+'" data-id="'+id+'" name="qty" type="text" value="'+quantity+'" class="quantity-box" size="5" disabled></td>' +							 			
										'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
									'</tr>'
									);
								stockCol.text(parseFloat(stocks - requests));
					  	 	}
					  	 	
				  	 	}
				 	}else {
				 		alert("Not enough stocks remaining");
				 	}
			  	 	
					
				})

				function itemExist(itemID,stocks) {
					var table = $("#approved_table tbody tr");
				 	var exist = false;
					$.each(table, function(index) {
						id = ($(this).find('[name="id"]').val());
						if (id == itemID) {
							exist = true;
						}
					})

					return exist;
				}

				$("#approved_table").on('click', '.remove',function() {
					var row = $(this).parents('tr');
					var remainingStocks = row.find('.quantity-box').data('stocks');
					var itemID = row.find('.quantity-box').data('id');
					calculateRemainingStocks(remainingStocks, itemID);
					row.remove();
				})

				function calculateRemainingStocks(remaining, itemID) {
					var table = $("#pending_table > tbody > tr");
					$.each(table, function(key, value) {
						var val = $(value);
						var id = val.find('td').eq(3).find('[name="id"]').val();
						if (id == itemID) {
							return val.find('td').eq(1).text(remaining);
						} 
					});
				}

				$("#process_request_form").submit(function(e) {
					e.preventDefault();
					var row = $("#approved_table tbody tr").length;
					var requests = [];
			 	 
			 		if (row) {
			 			for (i = 0; i < row; i++) {
							var r = $("#approved_table tbody tr").eq(i).find('td');
							var quantity = r.eq(1).find('input').val();
							var arr = {
									id : $("#approved_table tbody tr").eq(i).find('input[name="id"]').val(), 
									item : r.eq(0).text(),
									quantity : quantity
								};
							requests.push(arr);
						}

						var data = {};
						data['process_approve_request'] = true;
						data['requests'] = requests;
						$.ajax({
							type : 'POST',
							data : data,
							url : base_url + '/branch_supply_requests/approve',

							success : function(data) { 
								if(data){
									location.reload();
								}	 	
							}
						})
						return;
						
			 		}
			 		
			 		return alert('Please approve some items');
			 		
					
				})


			});
		</script>
	</body>
</html>