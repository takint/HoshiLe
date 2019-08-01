<main>
  <div class="py-4">
    <div class="container">
      <h3 class="mb-3">Order Detail</h3>
      <p class="mb-3">Date: <?php echo $order->getCreateDate(); ?></p>
      <table class="table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Brand</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $totalPrice = 0;
          foreach ($order->getDetails() as $detail) {
            $product = $detail->getProduct();
            $quantity = $detail->getQuantity();
            $unitPrice = $product->getPrice();
            $price = $quantity * $unitPrice;
            $totalPrice += $price;
          ?>
            <tr>
              <td class="w-25"><img class="img-fluid w-75" src="<?php echo $product->getImageUrl(); ?>" alt=""></td>
              <td><?php echo htmlspecialchars($product->getBrand()); ?></td>
              <td><?php echo htmlspecialchars($product->getName()); ?></td>
              <td><?php echo $quantity; ?></td>
              <td>$<?php echo number_format($unitPrice, 2); ?></td>
              <td>$<?php echo number_format($price, 2); ?></td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4"></td>
            <th>Total</th>
            <td>$<?php echo number_format($totalPrice, 2); ?></td>
          </tr>
        </tfoot>
      </table>
      <div class="text-center mt-2">
        <a class="btn btn-link" href="<?php echo $_SERVER['PHP_SELF']; ?>">Continue Shopping</a>
      </div>
    </div>
  </div>
</main>
