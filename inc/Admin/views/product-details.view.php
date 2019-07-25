<h2>
 Editing - <?= $product->getName()?>
</h2>

<form method="post" action="<?= $_SERVER["PHP_SELF"]."?controller=product&action=".$mode?>">
  <input type="hidden" name="productId" value="<?= $product->getId()?>">
  <div class="form-group">
    <label for="txtProductName">Product Name</label>
    <input type="text" value="<?= $product->getName()?>" name="productName" class="form-control" id="txtProductName" placeholder="Product Name">
  </div>
  <div class="form-group">
    <label for="txtProductBrand">Product Brand</label>
    <input type="text" value="<?= $product->getBrand()?>" name="productBrand" class="form-control" id="txtProductBrand" placeholder="Brand">
  </div>
  <div class="form-group">
    <label for="txtProductPrice">Product Price</label>
    <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
            <div class="input-group-text">$</div>
        </div>
        <input type="number" value="<?= $product->getPrice()?>" name="productPrice" class="form-control" id="txtProductPrice" placeholder="Price">
    </div>
  </div>
  <div class="form-group">
    <label for="txtImageUrl">Image URL</label>
    <input type="text" value="<?= $product->getImageUrl()?>" name="productImageUrl" class="form-control" id="txtImageUrl" placeholder="Image Url">
    <img width="400" src=<?= $product->getImageUrl()?> />
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="?controller=product" class="btn btn-secondary">Back to list</a>
</form>