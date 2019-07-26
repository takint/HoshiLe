<main>
  <div class="py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h3 class="mb-3">Profile</h3>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="action" value="updateProfile">
            <div class="form-group">
              <label for="inputName">Name</label>
              <input id="inputName" class="form-control" type="text" name="name" value="<?php echo $user->getName(); ?>">
            </div>
            <div class="form-group">
              <label for="inputEmail">Email</label>
              <input id="inputEmail" class="form-control" type="email" name="email" value="<?php echo $user->getEmail(); ?>">
            </div>
            <button class="btn btn-primary" type="submit">Update Profile</button>
          </form>
          <hr class="my-4">
          <h3 class="mb-3">Password</h3>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="action" value="updatePassword">
            <div class="form-group">
              <label for="inputCurPassword">Current Password</label>
              <input id="inputCurPassword" class="form-control" type="password" name="curPassword">
            </div>
            <div class="form-group">
              <label for="inputPassword1">New Password</label>
              <input id="inputPassword1" class="form-control" type="password" name="password1">
            </div>
            <div class="form-group">
              <label for="inputPassword2">Confirm Password</label>
              <input id="inputPassword2" class="form-control" type="password" name="password2">
            </div>
            <button class="btn btn-primary" type="submit">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
