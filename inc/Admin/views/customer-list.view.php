<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="?controller=product&action=add" class="btn btn-sm btn-success">Add new</a>
            <a href="?controller=product&action=import" class="btn btn-sm btn-info">Import</a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th><a href="?controller=product&sort=id">Id</a></th>
            <th><a href="?controller=product&sort=name">Full Name</a></th>
            <th><a href="?controller=product&sort=email">Email</a></th>
            <th><a href="?controller=product&sort=isadmin">Admin</a></th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($lstCustomers as $prod) { ?>
            <tr>
                <td><?= $prod->getId()?></td>
                <td><?= $prod->getName()?></td>
                <td><?= $prod->getEmail()?></td>
                <td><?= $prod->getIsAdmin() ? "Yes" : "Not"?></td>
                <td>
                    <a href="?controller=product&action=edit&id=<?= $prod->getId()?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="?controller=product&action=delete&id=<?= $prod->getId()?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="6">
                Paging will come in the next version
            </td>
        </tr>
        </tbody>
    </table>
</div>