<h2>
  <?= "Order date time: " . $order->getCreateDate()?>
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

<form method="post" action="<?= $_SERVER["PHP_SELF"]."?controller=order&action=".$mode?>">
  <input type="hidden" name="id" value="<?= $order->getId()?>">
  <div class="form-group">
    <label for="txtOrderCustName">Belong to user</label>
    <input type="text" readonly value="<?= $order->getUser()->getName()?>" name="name" class="form-control" id="txtOrderName" placeholder="Customer Name">
  </div>
  <div class="form-group">
    <label for="txtOrderBrand">User email</label>
    <input type="text" readonly value="<?= $order->getUser()->getEmail()?>" name="brand" class="form-control" id="txtOrderBrand" placeholder="Brand">
  </div>
  <div class="form-group">
    <label for="txtOrderTotal">Order's Total</label>
    <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
            <div class="input-group-text">$</div>
        </div>
        <input type="number" readonly value="<?= $order->getTotal()?>" name="price" class="form-control" id="txtOrderTotal" placeholder="Total">
    </div>
  </div>
  <div class="form-group">
    <h3>List Items</h3>
    <table class="table table-striped">
        <tr>
          <th>Product name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Cost</th>
        </tr>
        <?php
          $details = $order->getDetails();
          foreach($details as $key => $line){ 
            $price = $line->getProduct()->getPrice();
            $cost = $line->getQuantity() * $price;
        ?>
            <tr>
              <td><?=$line->getProduct()->getName()?></td>
              <td><?=$line->getQuantity()?></td>
              <td><?="$".$price?></td>
              <td><?="$".$cost?></td>
            </tr>
          <?php }
        ?>
    </table>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="?controller=order" class="btn btn-secondary">Back to list</a>
</form>