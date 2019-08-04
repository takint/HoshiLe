<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">HoshiLe Group</a>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <form method="post" action="<?php echo $_SERVER['CONTEXT_PREFIX']; ?>/index.php">
        <input type="hidden" name="action" value="logout">
        <button class="btn btn-link nav-link" type="submit">Log out</button>
      </form>
    </li>
  </ul>
</nav>