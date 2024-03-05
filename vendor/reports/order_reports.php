<?php $month = isset($_GET['month']) ? $_GET['month'] : date("Y-m"); ?>
<div class="content py-3">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Monthly Order Reports</h5>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="callout callout-primary shadow rounded-0">
                    <form action="" id="filter">
                        <div class="row align-items-end">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="month" class="control-label">Month</label>
                                    <input type="month" name="month" id="month" value="<?= $month ?>" class="form-control rounded-0" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-flat btn-sm"><i class="fa fa-filter"></i> Filter</button>
                                    <button class="btn btn-light border btn-flat btn-sm" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clear-fix mb-3"></div>
                    <div id="outprint">
                    <table class="table table-bordered table-stripped">
                        <colgroup>
                            <col width="5%">
                            <col width="15%">
                            <col width="20%">
                            <col width="25%">
                            <col width="20%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="">
                                <th class="text-center align-middle py-1">#</th>
                                <th class="text-center align-middle py-1">Date Created</th>
                                <th class="text-center align-middle py-1">Ref. Code</th>
                                <th class="text-center align-middle py-1">Client</th>
                                <th class="text-center align-middle py-1">Total Amount</th>
                                <th class="text-center align-middle py-1">Amount Recieved</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $total = 0;
                            $orders = $conn->query("SELECT o.*,c.code as ccode, CONCAT(c.lastname, ', ',c.firstname,' ',COALESCE(c.middlename,'')) as client from `payment_list` o inner join client_list c on o.client_id = c.id where o.vendor_id = '{$_settings->userdata('id')}' and date_format(o.date_created,'%Y-%m') = '{$month}' order by unix_timestamp(o.date_created) desc ");
                            while($row = $orders->fetch_assoc()):
                                $total += $row['total_amount'];
                            ?>
                                <tr>
                                    <td class="text-center align-middle px-2 py-1"><?php echo $i++; ?></td>
                                    <td class="align-middle px-2 py-1"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                                    <td class="align-middle px-2 py-1"><?= $row['code'] ?></td>
                                    <td class="align-middle px-2 py-1"><?php echo ucwords($row['ccode'].' - '.$row['client']) ?></td>
                                   
                                    <td class="text-right align-middle px-2 py-1"><?php echo format_num($row['total_amount']) ?></td>
                                    <td class="text-right align-middle px-2 py-1"><?php echo format_num($row['total_amount']*0.85) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center px-1 py-1 align-middel" colspan="5">Total</th>
                                <th class="text-right px-1 py-1 align-middel"><?= format_num($total * 0.85) ?></th>

                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
<style>
    #sys_logo{
        width:5em !important;
        height:5em !important;
        object-fit:scale-down !important;
        object-position:center center !important;
    }
</style>
<div class="d-flex align-items-center">
    
    <div class="col-auto flex-shrink-1 flex-grow-1 px-4">
        <h4 class="text-center m-0"><?= $_settings->info('name') ?></h4>
        <h3 class="text-center m-0"><b>Order Report</b></h3>
        <h5 class="text-center m-0">For the Month of</h5>
        <h5 class="text-center m-0"><?= date("F Y", strtotime($month)) ?></h5>
    </div>
</div>
<hr>
</noscript>
<script>
    $(function(){
        $('#filter').submit(function(e){
            e.preventDefault()
            location.href = "./?page=reports/order_reports&"+$(this).serialize();
        })
        $('#print').click(function(){
            start_loader();
            var head = $('head').clone()
            var p = $('#outprint').clone()
            var el = $('<div>')
            var header =  $($('noscript#print-header').html()).clone()
            head.find('title').text("Orders Montly Report - Print View")
            el.append(head)
            el.append(header)
            el.append(p)
            var nw = window.open("","_blank","width=1000,height=900,top=50,left=75")
                    nw.document.write(el.html())
                    nw.document.close()
                    setTimeout(() => {
                        nw.print()
                        setTimeout(() => {
                            nw.close()
                            end_loader()
                        }, 200);
                    }, 500);
        })
    })
</script>