<div class="main-navbar sticky-top">

  {{-- ── Top bar ── --}}
  <div class="top-navbar">
    <div class="container-fluid px-4">
      <div class="d-flex align-items-center" style="gap:16px;">

        {{-- Brand --}}
        <a href="/" class="brand-name me-auto d-none d-md-block" style="text-decoration:none;white-space:nowrap;">
          VogueVista
        </a>

        {{-- Search --}}
        <form action="{{ route('search') }}" method="GET" class="flex-grow-1" style="max-width:520px;">
          <div class="nav-search-wrap">
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Search products, categories…"
                   class="nav-search-input">
            <button type="submit" class="nav-search-btn">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </form>

        {{-- Actions --}}
        <ul class="nav align-items-center" style="gap:4px;flex-shrink:0;">

          {{-- Wishlist --}}
          <li class="nav-item d-none d-md-block">
            <a class="nav-link nav-icon-link {{ request()->is('wishlist') ? 'active' : '' }}" href="/wishlist">
              <span class="nav-icon-wrap">
                <i class="fa fa-heart-o"></i>
                @if (auth()->check() && $wishlistCount > 0)
                  <span class="nav-badge">{{ $wishlistCount > 99 ? '99+' : $wishlistCount }}</span>
                @endif
              </span>
              <span class="d-none d-lg-inline nav-icon-label">Wishlist</span>
            </a>
          </li>

          {{-- Cart --}}
          <li class="nav-item">
            <a class="nav-link nav-icon-link {{ request()->is('cart') ? 'active' : '' }}" href="/cart">
              <span class="nav-icon-wrap">
                <i class="fa fa-shopping-bag"></i>
                @if (auth()->check() && $cartCount > 0)
                  <span class="nav-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                @endif
              </span>
              <span class="d-none d-lg-inline nav-icon-label">Cart</span>
            </a>
          </li>

          {{-- Account --}}
          @guest
            <li class="nav-item d-none d-md-block">
              <a class="nav-link nav-icon-link" href="{{ route('login') }}">
                <i class="fa fa-user-o"></i>
                <span class="nav-icon-label">Login</span>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a class="nav-link nav-icon-link" href="{{ route('register') }}"
                 style="background:#1a1a1a;color:#fff !important;padding:6px 14px;">
                Register
              </a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a id="userDropdown" class="nav-link nav-icon-link dropdown-toggle" href="#"
                 role="button" data-bs-toggle="dropdown" aria-expanded="false" style="gap:6px;">
                <span class="nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                <span class="d-none d-lg-inline nav-icon-label">{{ strlen(Auth::user()->name) > 12 ? substr(Auth::user()->name, 0, 12) . '…' : Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end nav-dropdown" aria-labelledby="userDropdown">
                <li>
                  <div class="nav-dropdown-header">
                    <span class="nav-avatar nav-avatar-lg">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    <div>
                      <p style="font-size:13px;font-weight:700;margin-bottom:2px;color:#1a1a1a;">{{ Auth::user()->name }}</p>
                      <p style="font-size:11px;color:#9ca3af;margin-bottom:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;">
                        {{ Auth::user()->email }}
                      </p>
                    </div>
                  </div>
                </li>
                <li><hr class="dropdown-divider" style="margin:0;border-color:#f0f0f0;"></li>

                @if (Auth::user()->role_as == 1)
                  <li>
                    <a class="dropdown-item nav-dropdown-item" href="{{ route('admin.dashboard') }}">
                      <i class="fa fa-tachometer fa-fw me-2"></i> Admin Dashboard
                    </a>
                  </li>
                @else
                  <li>
                    <a class="dropdown-item nav-dropdown-item" href="{{ route('home') }}">
                      <i class="fa fa-user fa-fw me-2"></i> My Account
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item nav-dropdown-item" href="{{ route('user.orders') }}">
                      <i class="fa fa-shopping-bag fa-fw me-2"></i> My Orders
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item nav-dropdown-item" href="/wishlist">
                      <i class="fa fa-heart-o fa-fw me-2"></i> Wishlist
                      @if ($wishlistCount > 0)
                        <span class="nav-badge ms-1" style="position:static;transform:none;font-size:10px;padding:1px 5px;">
                          {{ $wishlistCount }}
                        </span>
                      @endif
                    </a>
                  </li>
                @endif

                <li><hr class="dropdown-divider" style="margin:0;border-color:#f0f0f0;"></li>
                <li>
                  <a class="dropdown-item nav-dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                     style="color:#dc2626;">
                    <i class="fa fa-sign-out fa-fw me-2"></i> Sign Out
                  </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </ul>
            </li>
          @endguest

        </ul>
      </div>
    </div>
  </div>

  {{-- ── Bottom nav: categories ── --}}
  <nav class="navbar navbar-expand-lg bottom-navbar">
    <div class="container-fluid px-4">

      {{-- Mobile: brand + toggler --}}
      <a class="navbar-brand d-md-none" href="/" style="font-size:1rem;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#fff;">
        VogueVista
      </a>

      <button class="navbar-toggler border-0 p-1" type="button"
              data-bs-toggle="collapse" data-bs-target="#navMain"
              aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation"
              style="color:#fff;">
        <i class="fa fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav me-auto align-items-lg-center">

          <li class="nav-item">
            <a class="nav-link bottom-nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link bottom-nav-link {{ request()->is('collections') && !request()->route('category_id') ? 'active' : '' }}"
               href="/collections">All Collections</a>
          </li>

          {{-- Dynamic categories --}}
          @if ($navCategories->isNotEmpty())
            <li class="nav-item dropdown">
              <a class="nav-link bottom-nav-link dropdown-toggle" href="#"
                 id="categoryDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                Categories
              </a>
              <ul class="dropdown-menu nav-cat-dropdown" aria-labelledby="categoryDropdown">
                @foreach ($navCategories as $cat)
                  <li>
                    <a class="dropdown-item nav-cat-item {{ request()->route('category_id') == $cat->id ? 'active' : '' }}"
                       href="{{ url('collections/' . $cat->id) }}">
                      {{ $cat->name }}
                    </a>
                  </li>
                @endforeach
                <li><hr class="dropdown-divider" style="margin:4px 0;border-color:#f0f0f0;"></li>
                <li>
                  <a class="dropdown-item nav-cat-item" href="/collections"
                     style="font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#6b7280;">
                    View All
                  </a>
                </li>
              </ul>
            </li>
          @endif

          {{-- Mobile-only auth links --}}
          @guest
            <li class="nav-item d-lg-none">
              <a class="nav-link bottom-nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item d-lg-none">
              <a class="nav-link bottom-nav-link" href="{{ route('register') }}">Register</a>
            </li>
          @else
            <li class="nav-item d-lg-none">
              <a class="nav-link bottom-nav-link" href="{{ route('home') }}">My Account</a>
            </li>
            <li class="nav-item d-lg-none">
              <a class="nav-link bottom-nav-link" href="{{ route('user.orders') }}">My Orders</a>
            </li>
            <li class="nav-item d-lg-none">
              <a class="nav-link bottom-nav-link" href="/wishlist">
                Wishlist @if ($wishlistCount > 0) ({{ $wishlistCount }}) @endif
              </a>
            </li>
            <li class="nav-item d-lg-none">
              <a class="nav-link bottom-nav-link" href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Sign Out
              </a>
            </li>
          @endguest

        </ul>

        {{-- Desktop right: search shortcut hint --}}
        <div class="d-none d-lg-flex align-items-center" style="gap:16px;font-size:11px;color:rgba(255,255,255,0.5);">
          <span>Free shipping on orders over Rp500.000</span>
        </div>

      </div>
    </div>
  </nav>

</div>
