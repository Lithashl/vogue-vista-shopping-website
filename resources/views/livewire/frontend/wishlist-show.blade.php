<div>
  <div class="py-5">
    <div class="container">

      {{-- Header --}}
      <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
          <p class="section-title mb-1">Saved Items</p>
          <div class="section-divider mb-0"></div>
          <p class="mb-0 mt-2" style="font-size:22px;font-weight:800;color:#1a1a1a;font-family:'Playfair Display',serif;">
            My Wishlist
          </p>
        </div>
        <a href="/collections" style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#1a1a1a;text-decoration:none;border-bottom:2px solid #1a1a1a;padding-bottom:2px;">
          Continue Shopping
        </a>
      </div>

      {{-- Flash --}}
      @if ($message)
        <div class="alert alert-success border-0 rounded-0 mb-3" style="font-size:13px;">
          <i class="fa fa-check-circle me-2"></i>{{ $message }}
        </div>
      @endif

      @if ($wishlist->isEmpty())
        <div class="empty-state py-5">
          <i class="fa fa-heart-o"></i>
          <h5>Your Wishlist is Empty</h5>
          <p>Save items you love and find them here later.</p>
          <a href="/collections" class="btn btn-checkout d-inline-block mt-3" style="width:auto;padding:12px 32px;">
            Browse Products
          </a>
        </div>
      @else
        <div class="shopping-cart">

          {{-- Column headers --}}
          <div class="cart-header d-none d-md-block">
            <div class="row">
              <div class="col-md-7"><h4>Product</h4></div>
              <div class="col-md-3"><h4>Price</h4></div>
              <div class="col-md-2"><h4>Action</h4></div>
            </div>
          </div>

          @foreach ($wishlist as $wishlistItem)
            @if ($wishlistItem->product)
              <div class="cart-item">
                <div class="row align-items-center">

                  {{-- Product --}}
                  <div class="col-md-7 col-8">
                    <a href="{{ url('collections/' . $wishlistItem->product->category_id . '/' . $wishlistItem->product->id) }}"
                       class="d-flex align-items-center gap-3 text-decoration-none text-dark">
                      <img src="{{ asset('uploads/products/' . $wishlistItem->product->image) }}"
                           style="width:72px;height:72px;object-fit:cover;flex-shrink:0;"
                           alt="{{ $wishlistItem->product->product_name }}">
                      <span class="product-name">{{ $wishlistItem->product->product_name }}</span>
                    </a>
                  </div>

                  {{-- Price --}}
                  <div class="col-md-3 col-4">
                    <span class="price">Rp{{ number_format($wishlistItem->product->price, 0, ',', '.') }}</span>
                  </div>

                  {{-- Remove --}}
                  <div class="col-md-2 col-12 mt-3 mt-md-0">
                    <button type="button"
                            wire:click="removeWishlistItem({{ $wishlistItem->id }})"
                            class="btn btn1"
                            style="font-size:10px;letter-spacing:1px;text-transform:uppercase;">
                      <span wire:loading.remove wire:target="removeWishlistItem({{ $wishlistItem->id }})">
                        <i class="fa fa-times me-1"></i> Remove
                      </span>
                      <span wire:loading wire:target="removeWishlistItem({{ $wishlistItem->id }})">
                        <i class="fa fa-spinner fa-spin"></i>
                      </span>
                    </button>
                  </div>

                </div>
              </div>
            @endif
          @endforeach

        </div>
      @endif

    </div>
  </div>
</div>
