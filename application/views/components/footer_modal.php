		<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Delete this entry</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
					</div>
					<div class="modal-footer ">
						<button type="button" class="btn btn-danger" ><span class="fas fa-check"></span> Yes</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fas fa-times"></span> No</button>
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
				<?php
					$btnlist = '';
					if(isset($action)){ 
						if(strpos($action, 'view') !== false){
							$btnlist = '<a class=\'action-view\'><i class=\'fas fa-eye\'></i></a>';
						}
						if(strpos($action, 'delete') !== false){
							$btnlist .= '<button class=\'btn btn-danger btn-sm\' title=\'Delete\' data-title=\'Delete\' data-toggle=\'modal\' data-target=\'#delete\' ><i class=\'fas fa-sm fa-trash-alt\'></i></button>';
						}
					}
				?>

				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url($site_url); ?>",
						    type : 'GET'
						},
						"columnDefs": [
							{className: "dt-right", "targets": <?= json_encode($right_align_cols); ?> },
							{"targets": -1, "data": null, "defaultContent": "<?= $btnlist; ?>"},
							{"targets": [ 0 ], "visible": false, "searchable": false}
						]
				});


				/***************************/
				$('.datepicker').datepicker({
					uiLibrary: 'bootstrap4'
				});

				$('.currency-php').each(function() { 
			        formatCurrency($(this));
			    });

			});

			function formatCurrency(ccy){
				var monetary_value = $(ccy).text();
		        var i = new Intl.NumberFormat('en-PH', { 
		            style: 'currency', 
		            currency: 'PHP' 
		        }).format(monetary_value); 
		        $(ccy).text(i); 
			}
		</script>
	</body>
</html>