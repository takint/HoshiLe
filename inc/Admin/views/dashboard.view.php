<h2>Product summary</h2>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Fields</th>
            <th>Value</th>
            <th>Report time</th>
            <th>User query</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Number of items</td>
            <td><?=count($lstProducts)?></td>
            <td><?= date("F j, Y, g:i a")?></td>
            <td><?=Session::$userName?></td>
        </tr>
        </tbody>
    </table>
</div>
<h2>Order summary</h2>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Order Id</th>
            <th>Customer Name</th>
            <th>Ordered Date</th>
            <th>Total Item</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php 
            $totalRev = 0;
            foreach($lstOrders as $order) { 
                $totalBill = $order->getTotal();
                $totalRev += $totalBill;
        ?>
                <tr>
                    <td><?= $order->getId()?></td>
                    <td><?= $order->getUser()->getName()?></td>
                    <td><?= $order->getCreateDate()?></td>
                    <td><?= $order->getTotalItems()?></td>
                    <td><?= "$".$totalBill?></td>
                    <td>
                        <a href="?controller=order&action=edit&id=<?= $order->getId()?>" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
        <?php } ?>
            <tr>
                <td colspan="4">Total revenue</td>
                <td colspan="2">
                    <?= "$".$totalRev?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<h2>User summary</h2>
<div class="table-responsive">
    <table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>Fields</th>
            <th>Value</th>
            <th>Report time</th>
            <th>User query</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Number of users</td>
            <td><?=count($lstUsers) - 1?></td>
            <td><?= date("F j, Y, g:i a")?></td>
            <td><?=Session::$userName?></td>
        </tr>
        </tbody>
    </table>
</div>