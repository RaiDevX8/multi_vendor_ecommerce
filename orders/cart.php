<style>
    .prod-img{
        width:calc(100%);
        height:auto;
        max-height: 10em;
        object-fit:scale-down;
        object-position:center center
    }
</style>
<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow-0">
        <div class="card-header">
            <h5 class="card-title">Cart List</h5>
        </div>
        <div class="card-body">
            <div id="cart-list">
                <div class="row">
                <?php 
                $gtotal = 0;
                $vendors = $conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list where id in (SELECT product_id FROM `cart_list` where client_id ='{$_settings->userdata('id')}')) order by `shop_name` asc");
                while($vrow=$vendors->fetch_assoc()):                
                ?>
                    <div class="col-12 border">
                        <span>Vendor: <b><?= $vrow['code']. " - " . $vrow['shop_name'] ?></b></span>
                    </div>
                    <div class="col-12 border p-0">
                        <?php 
                        $vtotal = 0;
                        $products = $conn->query("SELECT c.*, p.name as `name`, p.price,p.image_path FROM `cart_list` c inner join product_list p on c.product_id = p.id where c.client_id = '{$_settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}' order by p.name asc");
                        while($prow = $products->fetch_assoc()):
                            $total = $prow['price'] * $prow['quantity'];
                            $gtotal += $total;
                            $vtotal += $total;
                        ?>
                        <div class="d-flex align-items-center border p-2">
                            <div class="col-2 text-center">
                                <a href="./?page=products/view_product&id=<?= $prow['product_id'] ?>"><img src="<?= validate_image($prow['image_path']) ?>" alt="" class="img-center prod-img border bg-gradient-gray"></a>
                            </div>
                            <div class="col-auto flex-shrink-1 flex-grow-1">
                                <h4><b><?= $prow['name'] ?></b></h4>
                                <div class="d-flex">
                                    <div class="col-auto px-0"><small class="text-muted">Price: </small></div>
                                    <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0 pl-3"><small class="text-primary"><?= format_num($prow['price']) ?></small></p></div>
                                </div>
                                <div class="d-flex">
                                    <div class="col-auto px-0"><small class="text-muted">Qty: </small></div>
                                    <div class="col-auto">
                                        <div class="" style="width:10em">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><button class="btn btn-primary btn-minus" data-id="<?= $prow['id'] ?>" type="button"><i class="fa fa-minus"></i></button></div>
                                                <input type="text" value="<?= $prow['quantity'] ?>" class="form-control text-center" readonly="readonly">
                                                <div class="input-group-append"><button class="btn btn-primary btn-plus" data-id="<?= $prow['id'] ?>" type="button"><i class="fa fa-plus"></i></button></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto flex-shrink-1 flex-grow-1">
                                        <button class="btn btn-flat btn-outline-danger btn-sm btn-remove"  data-id="<?= $prow['id'] ?>"><i class="fa fa-times"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 text-right"><?= format_num($total) ?></div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="col-12 border">
                        <div class="d-flex">
                            <div class="col-9 text-right font-weight-bold text-muted">Total</div>
                            <div class="col-3 text-right font-weight-bold"><?= format_num($vtotal) ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
                    <div class="col-12 border">
                        <div class="d-flex">
                            <div class="col-9 h4 font-weight-bold text-right text-muted">Grand Total</div>
                            <div class="col-3 h4 font-weight-bold text-right"><?= format_num($gtotal) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear-fix mb-2"></div>
    <div class="text-right">
        <a href="./?page=orders/checkout" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-money-bill-wave"></i> Checkout</a>
    </div>
</div>
<script> 
window.update_quantity = function($cart_id = 0, $quantity = ""){
        start_loader();
            $.ajax({
            url:_base_url_+'classes/master.php?f=update_cart_quantity',
            data:{cart_id : $cart_id, quantity : $quantity},
            method:'POST',
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast('An error occurred.','error')
                end_loader()
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else if(!!resp.msg){
                    alert_toast(resp.msg,'error')
                }else{
                    alert_toast('An error occurred.','error')
                }
                end_loader();
            }
        })
    }
    $(function(){
        $('.btn-minus').click(function(){
            update_quantity($(this).attr('data-id'),"- 1")
        })
        $('.btn-plus').click(function(){
            update_quantity($(this).attr('data-id'),"+ 1")
        })
        $('.btn-remove').click(function(){
            _conf("Are you sure to remove this product from cart list?","delete_cart",[$(this).attr('data-id')])
        })
        $('#checkout').click(function(){
            if($('#cart-list .cart-item').length > 0){
                location.href="./?p=place_order"
            }else{
                alert_toast('Shopping cart is empty.','error')
            }
        })
    })
    function delete_cart($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_cart",
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