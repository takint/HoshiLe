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
            <th>Product</th>
            <th><a href="?controller=product&sort=id">Product Id</a></th>
            <th><a href="?controller=product&sort=name">Product Name</a></th>
            <th><a href="?controller=product&sort=brand">Brand</a></th>
            <th><a href="?controller=product&sort=price">Price</a></th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($lstProducts as $prod) { ?>
            <tr>
                <td><img width="100" height="100" src="<?= $prod->getImageUrl()?>"/></td>
                <td><?= $prod->getId()?></td>
                <td><?= $prod->getName()?></td>
                <td><?= $prod->getBrand()?></td>
                <td><?= $prod->getPrice()?></td>
                <td>
                    <a href="?controller=product&action=edit&id=<?= $prod->getId()?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="?controller=product&action=delete&id=<?= $prod->getId()?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="5">
                Paging will come in the next version
            </td>
            <td><?= "Total items: ".count($lstProducts)?></td>
        </tr>
        </tbody>
    </table>
</div>