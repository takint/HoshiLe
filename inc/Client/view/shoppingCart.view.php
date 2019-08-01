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
            $product = $tuple->product;
            $quantity = $tuple->quantity;
            $unitPrice = $product->getPrice();
            $price = $quantity * $unitPrice;
            $totalPrice += $price;
          ?>
            <tr>
              <td class="w-25"><img class="img-fluid w-75" src="<?php echo $product->getImageUrl(); ?>" alt=""></td>
              <td><?php echo htmlspecialchars($product->getBrand()); ?></td>
              <td><?php echo htmlspecialchars($product->getName()); ?></td>
              <td>
                <form class="d-inline" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="action" value="updateQuantity">
                  <input type="hidden" name="productId" value="<?php echo $product->getId(); ?>">
                  <input type="hidden" name="quantity" value="<?php echo $quantity - 1; ?>">
                  <button class="btn btn-sm btn-light" type="submit">-</button>
                </form>
                <span class="mx-2"><?php echo $quantity; ?></span>
                <form class="d-inline" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="action" value="updateQuantity">
                  <input type="hidden" name="productId" value="<?php echo $product->getId(); ?>">
                  <input type="hidden" name="quantity" value="<?php echo $quantity + 1; ?>">
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
        <form class="d-inline" method="<?php echo is_null(Session::$userId) ? 'get' : 'post'; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <?php if (is_null(Session::$userId)) { ?>
            <input type="hidden" name="page" value="login">
            <input type="hidden" name="forPurchase" value="true">
          <?php } else { ?>
            <input type="hidden" name="action" value="purchase">
          <?php } ?>
          <button class="btn btn-lg btn-primary w-25" type="submit" <?php if (empty($shoppingCart)) echo 'disabled' ?>>
            <?php echo is_null(Session::$userId) ? 'Please Log in' : 'Purchase'; ?>
          </button>
        </form>
      </div>
      <div class="text-center mt-2">
        <a class="btn btn-link" href="<?php echo $_SERVER['PHP_SELF']; ?>">Continue Shopping</a>
      </div>
    </div>
  </div>
</main>
