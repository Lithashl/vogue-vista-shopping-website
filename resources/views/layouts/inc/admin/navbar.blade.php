<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

  {{-- Brand --}}
  <div class="navbar-brand-wrapper d-flex justify-content-center">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand brand-logo fw-bold" href="{{ route('admin.dashboard') }}"
         style="letter-spacing:2px;text-transform:uppercase;font-size:1rem;">
        VogueVista
      </a>
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-sort-variant"></span>
      </button>
    </div>
  </div>

  {{-- Right side --}}
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

    {{-- Search --}}
    <ul class="navbar-nav mr-lg-4 w-100">
      <li class="nav-item nav-search d-none d-lg-block w-100">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="search">
              <i class="mdi mdi-magnify"></i>
            </span>
          </div>
          <input type="text" class="form-control" placeholder="Search…"
                 aria-label="search" aria-describedby="search">
        </div>
      </li>
    </ul>

    {{-- User menu --}}
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
           href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <div style="width:32px;height:32px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
            <i class="mdi mdi-account" style="font-size:18px;"></i>
          </div>
          <span class="nav-profile-name">{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="{{ url('/') }}" target="_blank">
            <i class="mdi mdi-open-in-new menu-icon"></i> View Store
          </a>
          <a class="dropdown-item" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout text-danger menu-icon"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
    </ul>

    {{-- Mobile toggle --}}
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>

  </div>
</nav>
