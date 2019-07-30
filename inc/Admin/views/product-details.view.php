<h2>
  <?= $product->getId() != 0 ? "Editing " . $product->getName() : "Adding"?>
</h2>
<?php if(count($errors) != 0) {?>
  <div class="alert alert-danger">
    <strong>Please fix these errrors below</strong>
    <ul>
      <?php foreach($errors as $msg){?>
        <li><?= $msg?></li>
      <?php } ?>
    </ul>
  </div>
<?php } ?>
<form method="post" action="<?= $_SERVER["PHP_SELF"]."?controller=product&action=".$mode?>">
  <input type="hidden" name="id" value="<?= $product->getId()?>">
  <div class="form-group">
    <label for="txtProductName">Product Name</label>
    <input type="text" value="<?= $product->getName()?>" name="name" class="form-control" id="txtProductName" placeholder="Product Name">
  </div>
  <div class="form-group">
    <label for="txtProductBrand">Product Brand</label>
    <input type="text" value="<?= $product->getBrand()?>" name="brand" class="form-control" id="txtProductBrand" placeholder="Brand">
  </div>
  <div class="form-group">
    <label for="txtProductPrice">Product Price</label>
    <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
            <div class="input-group-text">$</div>
        </div>
        <input type="number" value="<?= $product->getPrice()?>" name="price" class="form-control" id="txtProductPrice" placeholder="Price">
    </div>
  </div>
  <div class="form-group">
    <label for="txtImageUrl">Image URL</label>
    <input type="text" value="<?= $product->getImageUrl()?>" name="imageUrl" class="form-control" id="txtImageUrl" placeholder="Image Url">
    <img width="400" src=<?= $product->getImageUrl()?> />
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="?controller=product" class="btn btn-secondary">Back to list</a>
</form>