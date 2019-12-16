<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Add Inventory Item</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
		<form action="" method="post" accept-charset="utf-8">
			<div class="form-group">
				<label for='category'>Category</label>
				<select required="required" name="category" class="form-control">
					<option value="" selected="selected"></option>
					<?php foreach($categories->result_array() as $r) {
						echo '<option value="'.$r['CATEGORY'].'">'.$r['CATEGORY'].'</option>';
					} ?>
				</select>
				<?php echo form_error('category', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='brand'>Brand</label>
				<select required="required" name="brand" id="brand" class="form-control">
					<option value="" selected="selected"></option>
					<?php foreach($brands->result_array() as $r) {
						echo '<option value="'.$r['BRAND'].'">'.$r['BRAND'].'</option>';
					} ?>
				</select>
				<?php echo form_error('brand', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='item'>Item</label>
				<select required="required" name="item" id="item" class="form-control">
					<option value="" selected="selected"></option>
				</select>
				<?php echo form_error('item', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='sku'>SKU</label>
				<input required="required" type="text" name="sku" class="form-control">
				<?php echo form_error('sku', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='unit_type'>Unit Type</label>
				<select required="required" name="unit_type" class="form-control">
					<option value="" selected="selected"></option>
					<?php foreach($unit_types->result_array() as $r) {
						echo '<option value="'.$r['UNIT_TYPE'].'">'.$r['UNIT_TYPE'].'</option>';
					} ?>
				</select>
				<?php echo form_error('unit_type', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='quantity'>Quantity</label>
				<input required="required" type="text" name="quantity" class="form-control">
				<?php echo form_error('quantity', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='buying_price'>Buying Price</label>
				<input required="required" type="text" name="buying_price" class="form-control">
				<?php echo form_error('buying_price', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='selling_price'>Selling Price</label>
				<input required="required" type="text" name="selling_price" class="form-control">
				<?php echo form_error('selling_price', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='po_ref_no'>PO Ref No.</label>
				<input required="required" type="text" name="po_ref_no" class="form-control">
				<?php echo form_error('po_ref_no', '<p class="help-block">','</p>'); ?>
			</div>

			
			<div class="form-group">
				<input type="submit" name="submit_inventory" class="btn btn-success" value="Submit">
				<button class="btn btn-info" type="reset">Reset</button>
			</div>
		</form>
		<?php
			if(!empty($success_msg)){
				echo '<p class="status-msg success">'.$success_msg.'</p>';
			}elseif(!empty($error_msg)){
				echo '<p class="status-msg error">'.$error_msg.'</p>';
			}
		?>
	</div>
</div>

<script type="text/javascript" src="assets/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
 
            $('#brand').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('models/get_by_brand');?>",
                    method : "GET",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                        var html = '';
                        var i;
                        html += '<option value="" selected="selected"></option>';
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].MODEL+'>'+data[i].MODEL+'</option>';
                        }
                        $('#item').html(html);
 
                    }
                });
                return false;
            }); 
             
        });
    </script>