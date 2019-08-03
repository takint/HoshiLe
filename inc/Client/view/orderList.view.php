<main>
  <div class="py-4">
    <div class="container">
      <h3 class="mb-3">Order History</h3>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>#Items</th>
            <th>Total Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order) { ?>
            <tr onclick="window.location = '<?php echo $_SERVER['PHP_SELF'] . '?orderId=' . $order->getId(); ?>'">
              <td><?php echo $order->getCreateDate(); ?></td>
              <td><?php echo $order->getTotalItems(); ?></td>
              <td>$<?php echo number_format($order->getTotal(), 2); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
