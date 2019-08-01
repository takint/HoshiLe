<h2>
  <?= $customer->getId() != 0 ? "Editing " . $customer->getName() : "Adding"?>
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
<form method="post" action="<?= $_SERVER["PHP_SELF"]."?controller=user&action=".$mode?>">
  <input type="hidden" name="id" value="<?= $customer->getId()?>">
  <div class="form-group">
    <label for="txtCustomerName">Customer Name</label>
    <input type="text" value="<?= $customer->getName()?>" name="name" class="form-control" id="txtCustomerName" placeholder="Customer Name">
  </div>
  <div class="form-group">
    <label for="txtCustomerEmail">Customer Email</label>
    <input readonly type="text" value="<?= $customer->getEmail()?>" name="brand" class="form-control" id="txtCustomerBrand" placeholder="Brand">
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="?controller=user" class="btn btn-secondary">Back to list</a>
</form>