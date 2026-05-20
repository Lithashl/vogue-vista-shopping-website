@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- ── Hero Carousel ──────────────────────────────────────── --}}
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    @forelse ($sliders as $key => $sliderItem)

      @if ($sliderItem->image === 'nj.png')
        {{-- Split layout for nj.png --}}
        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" style="background-color: #d4a8d8;">
          <div class="container">
            <div class="row align-items-center hero-slide-row">
              <div class="col-md-6 py-4 py-md-5 custom-carousel-content">
                <p class="mb-2" style="font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#555;">
                  New Collection
                </p>
                <h1>{{ $sliderItem->title }} <span>.</span></h1>
                <p>{{ $sliderItem->description }}</p>
                <a href="/collections" class="btn-slider me-2">Shop Now</a>
                <a href="/collections" class="btn-slider" style="background:transparent;color:#1a1a1a;">Explore</a>
              </div>
              <div class="col-md-6 text-center text-md-end d-flex align-items-end justify-content-center justify-content-md-end">
                <img src="{{ asset('uploads/sliders/nj.png') }}"
                     class="img-fluid hero-slide-product-img"
                     alt="{{ $sliderItem->title }}">
              </div>
            </div>
          </div>
        </div>

      @else
        {{-- Full-screen slide --}}
        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
          <img src="{{ asset('uploads/sliders/' . $sliderItem->image) }}"
               class="d-block hero-slide-img"
               alt="{{ $sliderItem->title }}">
        </div>
      @endif

    @empty
      {{-- Fallback when no sliders --}}
      <div class="carousel-item active" style="background-color: #d4a8d8;">
        <div class="container">
          <div class="row align-items-center hero-slide-row">
            <div class="col-md-6 py-4 py-md-5 custom-carousel-content">
              <p class="mb-2" style="font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#555;">
                New Collection
              </p>
              <h1>VogueVista <span>.</span></h1>
              <p>Where fashion meets sophistication in every click.</p>
              <a href="/collections" class="btn-slider me-2">Shop Now</a>
              <a href="/collections" class="btn-slider" style="background:transparent;color:#1a1a1a;">Explore</a>
            </div>
          </div>
        </div>
      </div>
    @endforelse

  </div>

  @if ($sliders->count() > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  @endif
</div>

{{-- ── Marquee strip ───────────────────────────────────────── --}}
<div style="background:#1a1a1a;padding:10px 0;overflow:hidden;white-space:nowrap;">
  <span style="display:inline-block;animation:marquee 22s linear infinite;font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:#fff;">
    &nbsp;&nbsp;Free Shipping on Orders Over Rp500.000 &nbsp;·&nbsp;
    New Arrivals Every Week &nbsp;·&nbsp;
    Exclusive Members-Only Deals &nbsp;·&nbsp;
    Free Shipping on Orders Over Rp500.000 &nbsp;·&nbsp;
    New Arrivals Every Week &nbsp;·&nbsp;
    Exclusive Members-Only Deals &nbsp;·&nbsp;
    Free Shipping on Orders Over Rp500.000 &nbsp;·&nbsp;
    New Arrivals Every Week &nbsp;·&nbsp;
  </span>
</div>
<style>
  @keyframes marquee {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
  }
</style>

{{-- ── Shop by Category ────────────────────────────────────── --}}
@if ($categories->count())
<div class="py-5" style="background:#f7f7f7;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-4">
      <div>
        <p class="section-title mb-1">Browse</p>
        <div class="section-divider mb-0"></div>
        <p class="section-heading mb-0 mt-2">Shop by Category</p>
      </div>
      <a href="/collections" class="text-dark fw-bold" style="font-size:11px;letter-spacing:2px;text-transform:uppercase;text-decoration:none;border-bottom:2px solid #1a1a1a;padding-bottom:2px;">
        View All
      </a>
    </div>
    <div class="row g-3">
      @foreach ($categories as $cat)
        <div class="col-6 col-md-3">
          <div class="category-card">
            <a href="{{ url('collections/' . $cat->id) }}">
              <div class="category-card-img">
                <img src="{{ asset('uploads/category/' . $cat->image) }}"
                     alt="{{ $cat->name }}">
              </div>
              <div class="category-card-body">
                <h5>{{ $cat->name }}</h5>
              </div>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- ── Featured Products ───────────────────────────────────── --}}
<div class="py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-4">
      <div>
        <p class="section-title mb-1">Curated for you</p>
        <div class="section-divider mb-0"></div>
        <p class="section-heading mb-0 mt-2">Featured Products</p>
      </div>
      <a href="/collections" class="text-dark fw-bold" style="font-size:11px;letter-spacing:2px;text-transform:uppercase;text-decoration:none;border-bottom:2px solid #1a1a1a;padding-bottom:2px;">
        View All
      </a>
    </div>

    <div class="row g-3">
      @forelse ($products as $product)
        <div class="col-6 col-md-3">
          <div class="product-card">
            <a href="{{ url('collections/' . $product->category_id . '/' . $product->id) }}">
              <div class="product-card-img">
                @if ($product->quantity > 0)
                  <span class="stock bg-success">In Stock</span>
                @else
                  <span class="stock bg-danger">Out of Stock</span>
                @endif
                <img src="{{ asset('uploads/products/' . $product->image) }}"
                     alt="{{ $product->product_name }}">
              </div>
            </a>
            <div class="product-card-body">
              <div class="product-name">
                <a href="{{ url('collections/' . $product->category_id . '/' . $product->id) }}">
                  {{ $product->product_name }}
                </a>
              </div>
              <div>
                <span class="selling-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="empty-state">
            <i class="fa fa-tag"></i>
            <h5>No Products Yet</h5>
            <p>Check back soon for new arrivals.</p>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</div>

{{-- ── Promise strip ───────────────────────────────────────── --}}
<div style="background:#f7f7f7;border-top:1px solid #e8e8e8;border-bottom:1px solid #e8e8e8;">
  <div class="container py-4">
    <div class="row text-center g-3">
      <div class="col-6 col-md-3">
        <i class="fa fa-truck fa-2x mb-2 d-block" style="color:#1a1a1a;"></i>
        <p class="mb-0 fw-bold" style="font-size:11px;letter-spacing:1.5px;text-transform:uppercase;">Free Shipping</p>
        <p class="mb-0" style="font-size:12px;color:#6b7280;">On orders over Rp500K</p>
      </div>
      <div class="col-6 col-md-3">
        <i class="fa fa-refresh fa-2x mb-2 d-block" style="color:#1a1a1a;"></i>
        <p class="mb-0 fw-bold" style="font-size:11px;letter-spacing:1.5px;text-transform:uppercase;">Easy Returns</p>
        <p class="mb-0" style="font-size:12px;color:#6b7280;">30-day return policy</p>
      </div>
      <div class="col-6 col-md-3">
        <i class="fa fa-lock fa-2x mb-2 d-block" style="color:#1a1a1a;"></i>
        <p class="mb-0 fw-bold" style="font-size:11px;letter-spacing:1.5px;text-transform:uppercase;">Secure Checkout</p>
        <p class="mb-0" style="font-size:12px;color:#6b7280;">100% secure payments</p>
      </div>
      <div class="col-6 col-md-3">
        <i class="fa fa-headphones fa-2x mb-2 d-block" style="color:#1a1a1a;"></i>
        <p class="mb-0 fw-bold" style="font-size:11px;letter-spacing:1.5px;text-transform:uppercase;">24/7 Support</p>
        <p class="mb-0" style="font-size:12px;color:#6b7280;">Always here to help</p>
      </div>
    </div>
  </div>
</div>

@endsection
