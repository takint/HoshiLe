<main>
  <div class="py-4">
    <div class="container">
      <h3 class="mb-3">Shopping Cart</h3>
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
          foreach ($shoppingCart as $tuple) {
            $unitPrice = $tuple->product->getPrice();
            $price = $tuple->quantity * $unitPrice;
            $totalPrice += $price;
          ?>
            <tr>
              <td class="w-25"><img class="img-fluid w-75" src="<?php echo $tuple->product->getImageUrl(); ?>" alt=""></td>
              <td><?php echo htmlspecialchars($tuple->product->getBrand()); ?></td>
              <td><?php echo htmlspecialchars($tuple->product->getName()); ?></td>
              <td>
                <form class="d-inline" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="action" value="updateQuantity">
                  <input type="hidden" name="productId" value="<?php echo $tuple->product->getId(); ?>">
                  <input type="hidden" name="quantity" value="<?php echo $tuple->quantity - 1; ?>">
                  <button class="btn btn-sm btn-light" type="submit">-</button>
                </form>
                <span class="mx-2"><?php echo $tuple->quantity; ?></span>
                <form class="d-inline" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="action" value="updateQuantity">
                  <input type="hidden" name="productId" value="<?php echo $tuple->product->getId(); ?>">
                  <input type="hidden" name="quantity" value="<?php echo $tuple->quantity + 1; ?>">
                  <button class="btn btn-sm btn-light" type="submit">+</button>
                </form>
              </td>
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
      <div class="text-center">
        <button class="btn btn-lg btn-primary w-25" <?php if (empty($shoppingCart)) echo 'disabled' ?>>Purchase</button>
      </div>
      <div class="text-center mt-2">
        <a class="btn btn-link" href="<?php echo $_SERVER['PHP_SELF']; ?>">Continue Shopping</a>
      </div>
    </div>
  </div>
</main>
