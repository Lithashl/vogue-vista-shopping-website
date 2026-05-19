<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed {{ request()->is('admin/category*') ? 'active' : '' }}"
         data-bs-toggle="collapse" href="#menu-category"
         aria-expanded="{{ request()->is('admin/category*') ? 'true' : 'false' }}"
         aria-controls="menu-category">
        <i class="mdi mdi-view-grid menu-icon"></i>
        <span class="menu-title">Categories</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('admin/category*') ? 'show' : '' }}" id="menu-category">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/category/create') ? 'active' : '' }}"
               href="{{ url('admin/category/create') }}">
              Add Category
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/category') ? 'active' : '' }}"
               href="{{ url('admin/category') }}">
              All Categories
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed {{ request()->is('admin/products*') ? 'active' : '' }}"
         data-bs-toggle="collapse" href="#menu-products"
         aria-expanded="{{ request()->is('admin/products*') ? 'true' : 'false' }}"
         aria-controls="menu-products">
        <i class="mdi mdi-tag-multiple menu-icon"></i>
        <span class="menu-title">Products</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->is('admin/products*') ? 'show' : '' }}" id="menu-products">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/products/create') ? 'active' : '' }}"
               href="{{ url('admin/products/create') }}">
              Add Product
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}"
               href="{{ url('admin/products') }}">
              All Products
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}"
         href="{{ route('admin.orders.index') }}">
        <i class="mdi mdi-shopping menu-icon"></i>
        <span class="menu-title">Orders</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/sliders*') ? 'active' : '' }}"
         href="{{ url('admin/sliders') }}">
        <i class="mdi mdi-image-multiple menu-icon"></i>
        <span class="menu-title">Home Sliders</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
        <i class="mdi mdi-cog menu-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}" target="_blank">
        <i class="mdi mdi-open-in-new menu-icon"></i>
        <span class="menu-title">View Store</span>
      </a>
    </li>

  </ul>
</nav>
