<main>
  <div class="py-4">
    <div class="container">
      <div class="row">
        <?php foreach ($products as $product) { ?>
          <div class="col-md-4">
            <div class="card mb-3">
              <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="productId" value="<?php echo $product->getId(); ?>">
                <img src="<?php echo $product->getImageUrl(); ?>" alt="" class="img-fluid">
                <div class="card-body d-flex justify-content-between align-items-end">
                  <div>
                    <h6 class="card-subtitle"><?php echo htmlspecialchars($product->getBrand()); ?></h6>
                    <h4 class="card-title mb-0"><?php echo htmlspecialchars($product->getName()); ?></h4>
                  </div>
                  <button class="btn btn-secondary stretched-link" type="submit">Detail</button>
                </div>
              </form>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>
