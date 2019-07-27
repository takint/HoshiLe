<main>
  <div class="py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h3 class="mb-3">Please Sign up, or <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=login' . ($forPurchase ? '&forPurchase=true' : ''); ?>">Log in</a></h3>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="action" value="signup">
            <?php if ($forPurchase) { ?>
              <input type="hidden" name="forPurchase" value="true">
            <?php } ?>
            <div class="form-group">
              <label for="inputName">Name</label>
              <input id="inputName" class="form-control" type="text" name="name" autofocus>
            </div>
            <div class="form-group">
              <label for="inputEmail">Email</label>
              <input id="inputEmail" class="form-control" type="email" name="email">
            </div>
            <div class="form-group">
              <label for="inputPassword1">Password</label>
              <input id="inputPassword1" class="form-control" type="password" name="password1">
            </div>
            <div class="form-group">
              <label for="inputPassword2">Confirm Password</label>
              <input id="inputPassword2" class="form-control" type="password" name="password2">
            </div>
            <button class="btn btn-primary" type="submit">Sign up</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
