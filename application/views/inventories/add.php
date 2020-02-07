<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">Add Inventory Item</h1>
		</div>
	</div>

	<div class="row-pad"></div>

	<div class="row">
	    <div class="col-md-12">
			<form action="" method="post" accept-charset="utf-8">
				<div class="form-group">
					<label for='category_id'>Category</label>
					<select required="required" name="category_id" id="category_id" class="form-control">
						<option value="" selected="selected"></option>
						<?php foreach($categories->result_array() as $r) {
							if(set_value('category') === $r['ID']){
								echo '<option value="'.$r['ID'].'" selected="selected">'.$r['CATEGORY'].'</option>';
							}else{
								echo '<option value="'.$r['ID'].'">'.$r['CATEGORY'].'</option>';
							}
						} ?>
					</select>
					<?php echo form_error('category_id', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='item'>Item</label>
					<select required="required" name="item_id" id="item" class="form-control">
						<option value="" selected="selected"></option>
					</select>
					<?php echo form_error('item', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='dscp'>Description</label>
					<input required="required" type="text" name="dscp" value="<?php echo set_value('dscp'); ?>" class="form-control">
					<?php echo form_error('dscp', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='sku'>SKU</label>
					<input required="required" type="text" name="sku" value="<?php echo set_value('sku'); ?>" class="form-control">
					<?php echo form_error('sku', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='unit_type'>Unit Type</label>
					<select required="required" name="unit_type" class="form-control">
						<option value="" selected="selected"></option>
						<?php foreach($unit_types->result_array() as $r) {
							if(set_value('unit_type') === $r['UNIT_TYPE']){
								echo '<option value="'.$r['UNIT_TYPE'].'" selected="selected">'.$r['UNIT_TYPE'].'</option>';
							}else{
								echo '<option value="'.$r['UNIT_TYPE'].'">'.$r['UNIT_TYPE'].'</option>';
							}
						} ?>
					</select>
					<?php echo form_error('unit_type', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='quantity'>Quantity</label>
					<input required="required" type="text" name="quantity" value="<?php echo set_value('quantity'); ?>" class="form-control">
					<?php echo form_error('quantity', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='buying_price'>Buying Price</label>
					<input required="required" type="text" name="buying_price" value="<?php echo set_value('buying_price'); ?>" class="form-control">
					<?php echo form_error('buying_price', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='selling_price'>Selling Price</label>
					<input required="required" type="text" name="selling_price" value="<?php echo set_value('selling_price'); ?>" class="form-control">
					<?php echo form_error('selling_price', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='po_ref_no'>PO Ref No.</label>
					<input required="required" type="text" name="po_ref_no" value="<?php echo set_value('po_ref_no'); ?>" class="form-control">
					<?php echo form_error('po_ref_no', '<p class="help-block">','</p>'); ?>
				</div>

				<?php
					if(!empty($success_msg)){
						echo '<p class="status-msg success">'.$success_msg.'</p>';
					}elseif(!empty($error_msg)){
						echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
					}
				?>

				<div class="form-group">
					<input type="submit" name="submit_inventory" class="btn btn-success" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
        $(document).ready(function(){
 
            $('#category_id').change(function(){ 
                var id=$(this).val();
                
                $.ajax({
                    url : "<?php echo site_url('models/get_by_category_id');?>",
                    method : "GET",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                        var html = '';
                        var i;
                        html += '<option value="" selected="selected"></option>';
                        for(i=0; i<data.length; i++){
                        	if(item == data[i].ID){
	                            html += '<option value="'+data[i].ID+'" selected="selected">'+data[i].BRAND+' - '+data[i].MODEL+'</option>';
	                        }else{
	                        	html += '<option value="'+data[i].ID+'">'+data[i].BRAND+' - '+data[i].MODEL+'</option>';
	                        }
                        }
                        $('#item').html(html);
 
                    }
                });
                return false;
            }); 

            var item_id = "<?= set_value('item_id'); ?>";
            if(item_id != ""){
            	var category = "<?= set_value('category_id'); ?>";
            	$.ajax({
                    url : "<?php echo site_url('models/get_by_category_id');?>",
                    method : "GET",
                    data : {id: category},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                        var html = '';
                        var i;
                        html += '<option value="" selected="selected"></option>';
                        for(i=0; i<data.length; i++){
                        	if(item_id == data[i].ID){
	                            html += '<option value="'+data[i].ID+'" selected="selected">'+data[i].BRAND+' - '+data[i].MODEL+'</option>';
	                        }else{
	                        	html += '<option value="'+data[i].ID+'">'+data[i].BRAND+' - '+data[i].MODEL+'</option>';
	                        }
                        }
                        $('#item').html(html);
 
                    }
                });
            }
             
        });
    </script>