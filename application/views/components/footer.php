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
				var page_has_table = "<?php if(isset($page_has_table)){ echo $page_has_table; } else {echo 'no_table';} ?>";

				if(page_has_table == "has_table"){
					<?php if(!isset($site_url)){ $site_url = '';} ?>

					var has_export_buttons = "<?php if(isset($has_export_buttons)){ echo $has_export_buttons; } else {echo '';} ?>";
					
				    if(has_export_buttons!="" && has_export_buttons == "enabled"){
				    	var datatable = $('#view-data-table').DataTable({
					    	dom: 'Bfrtip',
					        lengthChange: false,
					        buttons: [ 'copy', 'excel', 'pdf' ],
					        "ajax": {
					            url : "<?php echo site_url($site_url) ?>",
					            type : 'GET'
					        },
					        "columnDefs": [
							    { 
							    	className: "dt-right",
							    	"targets": <?php if(isset($right_align_columns)){echo json_encode($right_align_columns);} else {echo '[]';} ?>
							    }
							  ]
					    });
					    datatable.buttons().container()
					        .appendTo( '#view-data-table_wrapper .col-md-6:eq(0)' );
					        
				    }else{
				    	var table = $('#view-data-table').DataTable({
					        "ajax": {
					            url : "<?php echo site_url($site_url) ?>",
					            type : 'GET'
					        }
					        <?php if(isset($view_dtl)){ 
						        	echo ','.
						         		'"columnDefs": [ {'.
								        '	"targets": -1,'.
								        '	"data": null,'.
								        '	"defaultContent": "<a class=\'action-view\'><i class=\'fas fa-eye\'></i></a>"'.
						        		'}';
						        		if(isset($right_align_columns)){
							        		echo ', {'.
											    '	className: "dt-right", '.
									        	'	"targets": '. json_encode($right_align_columns);
							        		echo '}';
						        		}
						        	echo ']';
					        	}else{
					        		if(isset($right_align_columns)){
						        		echo ','.
						         		'"columnDefs": [ {'.
										    '	className: "dt-right", '.
								        	'	"targets": '. json_encode($right_align_columns);
						        		echo '}]';
					        		}
					        	}
					        ?>
					        
					    });

						$('#view-data-table tbody').on( 'click', 'a', function (refno) {
					        var data = table.row( $(this).parents('tr') ).data();
					        var refno = data[0];
					        <?php if(!isset($view_dtl_url)){ $view_dtl_url = '';} ?>
					        window.location.replace('<?= base_url();?><?= index_page();?><?= $view_dtl_url;?>'+refno);
					    } );
				    }
			    }


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