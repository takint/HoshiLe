<header class="py-4">
  <div class="container text-center">
    <h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>"><?php echo htmlspecialchars(self::$title); ?></h1>
  </div>
</header>
<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $_SERVER['PHP_SELF']; ?>"><?php echo htmlspecialchars(self::$title); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-content">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item<?php if ($page == 'home') echo ' active'; ?>">
          <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>">Home</a>
        </li>
        <li class="nav-item<?php if ($page == 'about') echo ' active'; ?>">
          <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=about">About</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <?php if (is_null(Session::$userId)) { ?>
          <li class="nav-item<?php if ($page == 'login') echo ' active'; ?>">
            <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=login">Log in</a>
          </li>
          <li class="nav-item<?php if ($page == 'signup') echo ' active'; ?>">
            <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=signup">Sign up</a>
          </li>
        <?php } else { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo htmlspecialchars(Session::$userName); ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=profile">Profile</a>
              <?php if(Session::$isAdmin){ ?>
                <a class="dropdown-item" href="<?php echo $_SERVER['CONTEXT_PREFIX']; ?>/AdminPage.php?controller=order">Admin Page</a>
              <?php } else { ?>
                <a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=orderList">Order History</a>
              <?php } ?>
              <div class="dropdown-divider"></div>
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="action" value="logout">
                <button class="dropdown-item" type="submit">Log out</button>
              </form>
           </div>
          </li>
        <?php } ?>
        <li class="nav-item ml-2">
          <a class="btn btn-<?php echo empty(ShoppingCart::$shoppingCart) ? 'secondary text-white-50' : 'warning'; ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=shoppingCart">
            Cart
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
