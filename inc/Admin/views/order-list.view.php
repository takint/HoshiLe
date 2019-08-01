<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Orders</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="?controller=order&action=add" class="btn btn-sm btn-success">Add new</a>
            <a href="?controller=order&action=import" class="btn btn-sm btn-info">Import</a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th><a href="?controller=order&sort=id">Order Id</a></th>
            <th><a href="?controller=order&sort=custName">Customer Name</a></th>
            <th><a href="?controller=order&sort=createDate">Ordered Date</a></th>
            <th><a href="?controller=order&sort=totalItem">Total Item</a></th>
            <th><a href="?controller=order&sort=totalBill">Total</a></th>
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
                        <a href="?controller=order&action=edit&id=<?= $order->getId()?>" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total revenue</td>
            <td colspan="2">
                <?= "$".$totalRev?>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                Paging will come in the next version
            </td>
        </tr>
        </tbody>
    </table>
</div>