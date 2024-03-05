<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Product Stocks</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="add_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Add New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="10%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Category</th>
						<th>Product</th>
						<th>Quantity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT p.*, c.name AS category 
					FROM `product_list` p 
					INNER JOIN category_list c ON p.category_id = c.id 
					WHERE p.delete_flag = 0 AND p.vendor_id = '{$_settings->userdata('id')}' 
					ORDER BY p.`name` ASC");
	    
						while($row = $qry->fetch_assoc()):
							$row['stocks'] = $conn->query("SELECT SUM(quantity) FROM stock_list where product_id = '{$row['id']}'")->fetch_array()[0];
							$row['out'] = $conn->query("SELECT SUM(quantity) FROM order_items where product_id = '{$row['id']}' and order_id in (SELECT id FROM payment_list where `status` != 5) ")->fetch_array()[0];
							$row['stocks'] = $row['stocks'] > 0 ? $row['stocks'] : 0;
        					$row['out'] = $row['out'] > 0 ? $row['out'] : 0;
							$row['available'] = $row['stocks'] -$row['out'];
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
						      <td><?php echo ucwords($row['category']) ?></td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td class="text-right"><?= number_format($row['available']) ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="?page=inventory/view_stock&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#add_new').click(function(){
			uni_modal("Add New Stock","inventory/manage_stock.php")
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this product permanently?","delete_product",[$(this).attr('data-id')])
		})
        $('.table th, .table td').addClass("align-middle px-2 py-1")
		$('.table').dataTable();
		$('.table').dataTable();
	})
	function delete_product($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_product",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>