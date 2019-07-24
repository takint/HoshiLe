<main>
  <div class="py-4">
    <div class="container">
      <div class="row">
        <?php foreach ($products as $product) { ?>
          <div class="col-md-4">
            <div class="card mb-3">
              <img src="<?php echo $product->getImageUrl(); ?>" alt="" class="img-fluid">
              <div class="card-body d-flex justify-content-between">
                <h4 class="card-title"><?php echo $product->getName(); ?></h4>
                <button type="button" class="btn btn-secondary">
                  Buy
                </button>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>
