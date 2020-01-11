<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">New Purchase Order</h1>
		</div>
	</div>

	<div class="row-pad"></div>

	<div class="row">
	    <div class="col-md-12">
			<form id="po_form" action="" method="post" accept-charset="utf-8">
				<div class="row">
					<div class="col-md-6">
						<label for='ordered_dt'>Order Date</label>
						<p><?= date('F j, Y'); ?></p>
					</div>
					<div class="col-md-6">
						<label for='ordered_by'>Order By</label>
						<p><?= $session_user ?></p>
					</div>
				</div>
				
				<div class="form-group">
					<label for='supplier_id'>Supplier</label>
					<select required="required" name="supplier_id" class="form-control">
						<option value=""></option>
						<?php foreach($suppliers->result_array() as $r) {
							if(set_value('supplier_id') === $r['ID']){
								echo '<option value="'.$r['ID'].'" selected="selected">'.$r['SUPPLIER_NAME'].'</option>';
							}else{
								echo '<option value="'.$r['ID'].'">'.$r['SUPPLIER_NAME'].'</option>';
							}
						} ?>
					</select>
					<?php echo form_error('supplier_id', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='expected_dt'>Expected Date</label>
					<input required="required" type="text" value="<?php echo set_value('expected_dt'); ?>" name="expected_dt" class="form-control datepicker">
					<?php echo form_error('expected_dt', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='notes'>Notes</label>
					<textarea name="notes" class="form-control"><?php echo set_value('notes'); ?></textarea>
					<?php echo form_error('notes', '<p class="help-block">','</p>'); ?>
				</div>

				<table id="po_items" class="table table-hover order-list">
				    <thead>
				        <tr>
				            <th>Item</th>
				            <th class="text-right">Unit Price &nbsp;&nbsp; &#8369;</th>
				            <th class="text-right">Quantity</th>
				            <th class="text-right">Price &nbsp;&nbsp; &#8369;</th>
				            <th></th>
				        </tr>
				    </thead>
				    <tbody>
				        <tr>
				            <td>
				                <select required="required" name="model_id0" class="form-control">
									<option value=""></option>
									<?php foreach($models->result_array() as $r) {
										if(set_value('model_id') === $r['ID']){
											echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRAND'].' - '.$r['MODEL'].'</option>';
										}else{
											echo '<option value="'.$r['ID'].'">'.$r['BRAND'].' - '.$r['MODEL'].'</option>';
										}
									} ?>
								</select>
				            </td>
				            <td>
				                <input type="text" required="required" name="unit_price0" class="form-control text-right" onchange="calculatePrice($(this).parent().parent())" />
				            </td>
				            <td>
				                <input type="text" required="required" name="quantity0" class="form-control text-right" size="5" onchange="calculatePrice($(this).parent().parent())" />
				            </td>
				            <td style="text-align: right; width: 20%">
				                <label name="price" class="currency-php"></label>
				            </td>
				            <td>
				            	<a class="deleteRow"></a>
				            </td>
				        </tr>
				    </tbody>
				    <tfoot>
				        <tr>
				            <td colspan="5" style="text-align: left;">
				                <input type="button" class="btn btn-md btn-block btn-secondary" id="addrow" value="Add Row" />
				            </td>
				        </tr>
				        <tr>
				        </tr>
				    </tfoot>
				</table>
				<?php echo form_error('items', '<p class="help-block">','</p>'); ?>
				
				<table class="table">
				    <thead>
				        <tr>
				            <th>Grand Total &nbsp;&nbsp; &#8369;</th>
				            <th class="text-right"><label id="grandtotal" name="grandtotal" class="currency-php"></label></th>
				            <th></th>
				        </tr>
				    </thead>
				</table>
				
				<?php
					if(!empty($success_msg)){
						echo '<p class="status-msg success">'.$success_msg.'</p>';
					}elseif(!empty($error_msg)){
						echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
					}
				?>
				<div class="form-group">
					<input type="hidden" name="input_hidden_po_items" id="input_hidden_po_items">
					<input type="submit" name="submit_purchase_order" id="save" class="btn btn-success btn-primary" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
	    var counter = 1;

	    $("#addrow").on("click", function () {
	        var newRow = $("<tr>");
	        var cols = "";

	        cols += '<td><select required="required" name="model_id' + counter + '" class="form-control">'+
						'<option value=""></option>'
							+ '<?php foreach($models->result_array() as $r) {
								if(set_value('model_id') === $r['ID']){
									echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRAND'].' - '.$r['MODEL'].'</option>';
								}else{
									echo '<option value="'.$r['ID'].'">'.$r['BRAND'].' - '.$r['MODEL'].'</option>';
								}
							} ?>' 
						+'</select></td>';

	        cols += '<td><input type="text" class="form-control text-right" name="unit_price' + counter + '" onchange="calculatePrice($(this).parent().parent())"/></td>';
	        cols += '<td><input type="text" class="form-control text-right" name="quantity' + counter + '" size="5" onchange="calculatePrice($(this).parent().parent())"/></td>';
			cols += '<td class="text-right"><label name="price" class="currency-php"></label></td>';
	        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="x"></td>';
	        newRow.append(cols);
	        $("table.order-list").append(newRow);
	        counter++;
	    });



	    $("table.order-list").on("click", ".ibtnDel", function (event) {
	        $(this).closest("tr").remove();       
	        counter -= 1
	    });


		$('#save').click(function(){
			var table_data = [];
			
			//we will use .each to get all the data
			$('#po_items tbody tr').each(function(row,tr){
				//new array to store all the data per row
				
				//get only the data with value
				if($(tr).find('td:eq(0)').find('select').val() == ""){
			
				}else{			
					var sub = {
						'model_id' : $(tr).find('td:eq(0)').find('select').val(),
						'unit_price' : $(tr).find('td:eq(1)').find('input').val(),
						'quantity' : $(tr).find('td:eq(2)').find('input').val()
					};
					
					table_data.push(sub);
				}
			});

			$('#input_hidden_po_items').val(JSON.stringify(table_data));
			
		});
	});



function calculatePrice(row) {
	var unit_price = $(row).find('input[name^="unit_price"]').val();
	var quantity = $(row).find('input[name^="quantity"]').val();
	if(unit_price != '' && quantity != ''){
		var price = unit_price*quantity;
		$(row).find('label[name^="price"]').text(price.toFixed(2));
		formatCurrency($(row).find('label[name^="price"]'));
		calculateGrandTotal();
	}
}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list tbody").find('tr').each(function () {
    	var unit_price = $(this).find('input[name^="unit_price"]').val();
		var quantity = $(this).find('input[name^="quantity"]').val();
		var price = unit_price*quantity;
        grandTotal += price;
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
	formatCurrency($("#grandtotal"));
}
</script>