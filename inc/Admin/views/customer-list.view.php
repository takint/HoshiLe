<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Customers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="?controller=user&action=import" class="btn btn-sm btn-info">Import</a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th><a href="?controller=user&sort=id">Id</a></th>
            <th><a href="?controller=user&sort=name">Full Name</a></th>
            <th><a href="?controller=user&sort=email">Email</a></th>
            <th>Admin</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($lstCustomers as $cust) { ?>
            <tr>
                <td><?= $cust->getId()?></td>
                <td><?= $cust->getName()?></td>
                <td><?= $cust->getEmail()?></td>
                <td><?= $cust->getIsAdmin() ? "Yes" : "Not"?></td>
                <td>
                    <?php if($cust->getIsAdmin()) {?>
                        <span>No action upon this user</span>
                    <?php } else { ?>
                        <a href="?controller=user&action=edit&id=<?= $cust->getId()?>" class="btn btn-sm btn-primary">Edit</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td><?= "Total users: ".count($lstCustomers)?></td>
            <td colspan="4">
                Paging will come in the next version
            </td>
        </tr>
        </tbody>
    </table>
</div>