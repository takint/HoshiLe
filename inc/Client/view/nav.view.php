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
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=login">Log in</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=signup">Sign up</a>
        </li>
        <li class="nav-item ml-2">
          <a class="btn btn-warning" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=shoppingCart">Cart</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
