	        </div>
		</div>


	    <script src="assets/fontawesome/5.0.13/js/solid.js"></script>
	    <script src="assets/fontawesome/5.12.0/js/fontawesome.min.js"></script>

	    <!-- jQuery CDN - Slim version (=without AJAX) -->
    	<script src="assets/jquery/3.3.1/jquery-3.3.1.slim.min.js"></script>
	    <!-- Popper.JS -->
	    <script src="assets/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	    <!-- Bootstrap JS -->
	    <script src="assets/bootstrap/4.1.3/js/bootstrap.min.js"></script>

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

	    <script type="text/javascript">
			$(document).ready(function() {
			    var suppliertable = $('#supplier-table').DataTable({
			    	dom: 'Bfrtip',
			        lengthChange: false,
			        buttons: [ 'copy', 'excel', 'pdf' ],
			        "ajax": {
			            url : "<?php echo site_url("suppliers/suppliers_page") ?>",
			            type : 'GET'
			        }
			    });
			    suppliertable.buttons().container()
			        .appendTo( '#supplier-table_wrapper .col-md-6:eq(0)' );
			});
		</script>
	</body>
</html>