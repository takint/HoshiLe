<main>
  <div class="py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <img src="<?php echo $product->getImageUrl(); ?>" alt="" class="img-fluid">
        </div>
        <div class="col-md-4 mt-4">
          <h6><?php echo htmlspecialchars($product->getBrand()); ?></h6>
          <h4><?php echo htmlspecialchars($product->getName()); ?></h4>
          <p>Price: $<?php echo number_format($product->getPrice(), 2); ?></p>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="action" value="addToCart">
            <input type="hidden" name="productId" value="<?php echo $product->getId(); ?>">
            <button class="btn btn-primary" type="submit">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
