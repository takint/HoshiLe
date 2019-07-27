<main>
  <div class="py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h3 class="mb-3">Please Log in, or <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=signup' . ($forPurchase ? '&forPurchase=true' : ''); ?>">Sign up</a></h3>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="action" value="login">
            <?php if ($forPurchase) { ?>
              <input type="hidden" name="forPurchase" value="true">
            <?php } ?>
            <div class="form-group">
              <label for="inputEmail">Email</label>
              <input id="inputEmail" class="form-control" type="email" name="email" autofocus>
            </div>
            <div class="form-group">
              <label for="inputPassword">Password</label>
              <input id="inputPassword" class="form-control" type="password" name="password">
            </div>
            <button class="btn btn-primary" type="submit">Log in</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
