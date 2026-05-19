<div>
  <div class="py-5">
    <div class="container">

      {{-- Flash message --}}
      @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-0 mb-4" role="alert"
             style="font-size:13px;font-weight:700;letter-spacing:0.5px;">
          <i class="fa fa-check-circle me-2"></i>{{ session('message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      {{-- Breadcrumb --}}
      <p style="font-size:12px;color:#6b7280;margin-bottom:28px;">
        <a href="/" class="text-dark text-decoration-none">Home</a> &nbsp;/&nbsp;
        <a href="/collections" class="text-dark text-decoration-none">Collections</a> &nbsp;/&nbsp;
        <a href="{{ url('/collections/' . $category->id) }}" class="text-dark text-decoration-none">{{ $category->name }}</a> &nbsp;/&nbsp;
        <span>{{ $product->product_name }}</span>
      </p>

      <div class="row g-5">

        {{-- ── Product image ── --}}
        <div class="col-md-5">
          <div style="overflow:hidden;background:#f7f7f7;">
            <img src="{{ asset('uploads/products/' . $product->image) }}"
                 class="w-100"
                 style="height:500px;object-fit:cover;display:block;"
                 alt="{{ $product->product_name }}">
          </div>
        </div>

        {{-- ── Product info ── --}}
        <div class="col-md-7">
          <div class="product-view">

            {{-- Stock badge --}}
            @if ($product->quantity > 0)
              <span class="badge bg-success rounded-0 mb-2" style="font-size:10px;letter-spacing:1px;">IN STOCK</span>
            @else
              <span class="badge bg-danger rounded-0 mb-2" style="font-size:10px;letter-spacing:1px;">OUT OF STOCK</span>
            @endif

            {{-- Name --}}
            <h1 class="product-name mt-1">{{ $product->product_name }}</h1>

            {{-- Category --}}
            <p class="product-path">
              Category: <a href="{{ url('/collections/' . $category->id) }}" class="text-dark">{{ $category->name }}</a>
            </p>

            {{-- Price --}}
            <div class="mb-3">
              <span class="selling-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
            </div>

            <hr style="border-color:#e8e8e8;">

            {{-- Quantity selector --}}
            @if ($product->quantity > 0)
              <div class="mb-3">
                <p style="font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#6b7280;margin-bottom:8px;">
                  Quantity
                </p>
                <div class="qty-group">
                  <button class="qty-btn" wire:click="decrementQuantity" type="button">
                    <i class="fa fa-minus"></i>
                  </button>
                  <input type="text" wire:model="quantityCount" class="qty-input" readonly />
                  <button class="qty-btn" wire:click="incrementQuantity" type="button">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
                <p class="mt-2" style="font-size:12px;color:#6b7280;">
                  {{ $product->quantity }} items available
                </p>
              </div>
            @endif

            {{-- Actions --}}
            <div class="d-flex flex-wrap gap-2 mb-4">
              @if ($product->quantity > 0)
                <button type="button" wire:click="addToCart({{ $product->id }})" class="btn btn1">
                  <span wire:loading.remove wire:target="addToCart">
                    <i class="fa fa-shopping-bag me-1"></i> Add to Cart
                  </span>
                  <span wire:loading wire:target="addToCart">Adding…</span>
                </button>
              @endif
              <button type="button" wire:click="addToWishlist({{ $product->id }})" class="btn btn1">
                <span wire:loading.remove wire:target="addToWishlist">
                  <i class="fa fa-heart-o me-1"></i> Wishlist
                </span>
                <span wire:loading wire:target="addToWishlist">Adding…</span>
              </button>
            </div>

            <hr style="border-color:#e8e8e8;">

            {{-- Description --}}
            <div class="mt-3">
              <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#6b7280;margin-bottom:10px;">
                Description
              </p>
              <div style="font-size:14px;color:#374151;line-height:1.7;">
                {!! $product->description !!}
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
