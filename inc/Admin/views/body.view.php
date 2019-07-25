<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?= $currentCtr == "dashboard" ? "active" : "" ?>" href="?controller=dashboard">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $currentCtr == "order" ? "active" : "" ?>" href="?controller=order">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $currentCtr == "product" ? "active" : "" ?>" href="?controller=product">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $currentCtr == "user" ? "active" : "" ?>" href="?controller=user">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">