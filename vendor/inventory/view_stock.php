<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT p.*, c.name 
                        FROM `product_list` p 
                        INNER JOIN category_list c ON p.category_id = c.id 
                        WHERE p.vendor_id = '{$_settings->userdata('id')}' and p.id = '{$_GET['id']}' ");

    if ($qry === false) {
        // Display or log the error message
        echo "Error executing the query: " . $conn->error;
        // or use a logger like error_log("Error executing the query: " . $conn->error);
    } else {
        if ($qry->num_rows > 0) {
            foreach ($qry->fetch_assoc() as $k => $v) {
                $$k = stripslashes($v);
            }
            $stocks = $conn->query("SELECT SUM(quantity) FROM stock_list WHERE product_id = '$id'")->fetch_array()[0];
            $out = $conn->query("SELECT SUM(quantity) FROM order_items WHERE product_id = '{$id}' AND order_id IN (SELECT id FROM payment_list WHERE `status` != 5) ")->fetch_array()[0];
            $stocks = $stocks > 0 ? $stocks : 0;
            $out = $out > 0 ? $out : 0;
            $available = $stocks - $out;
        }
    }
}
?>

<style>
    .product-img {
        width: 15em;
        height: 12em;
        object-fit: scale-down;
        object-position: center center;
    }
</style>
<div class="content py-3">
    <div class="card card-outline rounded-0 card-primary shadow">
        <div class="card-header">
            <h4 class="card-title">Product Stock List</h4>
            <div class="card-tools">
                <a href="javascript:void(0)" id="add_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Stock</a>
                <a class="btn btn-default border btn-sm btn-flat" href="./?page=inventory"><i class="fa fa-angle-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="Product Image <?= isset($name) ? $name : "" ?>" class="img-thumbnail product-img">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="mx-2 text-muted">Category</small>
                                <div class="pl-4"><?= isset($name) ? $name : '' ?></div>
                            </div>
                        </div>
                        <div class="row">
                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="mx-2 text-muted">Name</small>
                                <div class="pl-4"><?= isset($name) ? $name : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <small class="mx-2 text-muted">Price</small>
                                <div class="pl-4"><?= isset($price) ? number_format($price, 2) : '' ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <small class="mx-2 text-muted">Available Quantity</small>
                                <div class="pl-4"><?= isset($available) ? number_format($available) : '0' ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Stock-in History</h3>
                        <table class="table table-bordered table-stripped">
                            <colgroup>
                                <col width="50%">
                                <col width="30%">
                                <col width="20%">
                            </colgroup>
                            <thead>
                                <tr class="bg-light text-light">
                                    <th class="py-1 text-center">Date Added</th>
                                    <th class="py-1 text-center">Quantity</th>
                                    <th class="py-1 text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stocks = $conn->query("SELECT * FROM `stock_list` WHERE `product_id` = '{$id}'");
                                while ($row = $stocks->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td class="px-2 py-1 align-middle"><?= date('M d, Y H:i', strtotime($row['date_created'])) ?></td>
                                        <td class="px-2 py-1 text-right align-middle"><?= number_format($row['quantity']) ?></td>
                                        <td class="px-2 py-1 align-middle">
                                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                Action
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-dark"></span> Edit</a>
                                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#add_new').click(function () {
            uni_modal("Add New Stock", "inventory/manage_stock.php?pid=<?= isset($id) ? $id : "" ?>")
        })
        $('.edit_data').click(function () {
            uni_modal("Edit Stock", "inventory/manage_stock.php?id=" + $(this).attr('data-id'))
        })
        $('.delete_data').click(function () {
            _conf("Are you sure to delete this stock entry product permanently?", "delete_stock", [$(this).attr('data-id')])
        })
    })

    function delete_stock($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_stock",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>
