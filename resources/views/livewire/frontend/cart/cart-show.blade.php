<div>
  <div class="py-5">
    <div class="container">

      {{-- Header --}}
      <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
          <p class="section-title mb-1">Shopping</p>
          <div class="section-divider mb-0"></div>
          <p class="mb-0 mt-2" style="font-size:22px;font-weight:800;color:#1a1a1a;font-family:'Playfair Display',serif;">
            My Cart
          </p>
        </div>
        <a href="/collections" style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#1a1a1a;text-decoration:none;border-bottom:2px solid #1a1a1a;padding-bottom:2px;">
          Continue Shopping
        </a>
      </div>

      {{-- Flash --}}
      @if (session()->has('message'))
        <div class="alert alert-success border-0 rounded-0 mb-3" style="font-size:13px;">
          <i class="fa fa-check-circle me-2"></i>{{ session('message') }}
        </div>
      @endif

      @if ($cart->isEmpty())
        <div class="empty-state py-5">
          <i class="fa fa-shopping-bag"></i>
          <h5>Your Cart is Empty</h5>
          <p>Add items to your cart to see them here.</p>
          <a href="/collections" class="btn btn-checkout d-inline-block mt-3" style="width:auto;padding:12px 32px;">
            Browse Products
          </a>
        </div>
      @else
        <div class="row g-5">

          {{-- ── Cart items ── --}}
          <div class="col-md-8">
            <div class="shopping-cart">

              {{-- Column headers --}}
              <div class="cart-header d-none d-md-block">
                <div class="row">
                  <div class="col-md-6"><h4>Product</h4></div>
                  <div class="col-md-3"><h4>Quantity</h4></div>
                  <div class="col-md-2"><h4>Total</h4></div>
                  <div class="col-md-1"></div>
                </div>
              </div>

              @php $totalPrice = 0; @endphp

              @foreach ($cart as $cartItem)
                @if ($cartItem->product)
                  @php
                    $lineTotal = $cartItem->product->price * $cartItem->quantity;
                    $totalPrice += $lineTotal;
                  @endphp
                  <div class="cart-item">
                    <div class="row align-items-center">

                      {{-- Product --}}
                      <div class="col-md-6 col-8">
                        <div class="d-flex align-items-center gap-3">
                          <img src="{{ asset('uploads/products/' . $cartItem->product->image) }}"
                               style="width:72px;height:72px;object-fit:cover;flex-shrink:0;"
                               alt="{{ $cartItem->product->product_name }}">
                          <div style="min-width:0;">
                            <span class="product-name">{{ $cartItem->product->product_name }}</span>
                            <span style="font-size:12px;color:#6b7280;">
                              Rp{{ number_format($cartItem->product->price, 0, ',', '.') }} each
                            </span>
                          </div>
                        </div>
                      </div>

                      {{-- Quantity --}}
                      <div class="col-md-3 col-4 mt-3 mt-md-0">
                        <div class="d-flex align-items-center" style="border:1.5px solid #1a1a1a;display:inline-flex;width:fit-content;">
                          <button type="button" wire:click="decrementQuantity({{ $cartItem->id }})" class="btn btn1" style="border:none;padding:5px 10px;">
                            <i class="fa fa-minus"></i>
                          </button>
                          <input type="text" value="{{ $cartItem->quantity }}" class="input-quantity" disabled>
                          <button type="button" wire:click="incrementQuantity({{ $cartItem->id }})" class="btn btn1" style="border:none;padding:5px 10px;">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                      </div>

                      {{-- Total --}}
                      <div class="col-md-2 d-none d-md-block">
                        <span class="price">Rp{{ number_format($lineTotal, 0, ',', '.') }}</span>
                      </div>

                      {{-- Remove --}}
                      <div class="col-md-1 col-12 text-md-center mt-3 mt-md-0">
                        <button type="button"
                                wire:click="removeCartItem({{ $cartItem->id }})"
                                class="btn p-0"
                                style="color:#6b7280;"
                                title="Remove">
                          <span wire:loading.remove wire:target="removeCartItem({{ $cartItem->id }})">
                            <i class="fa fa-times fa-lg"></i>
                          </span>
                          <span wire:loading wire:target="removeCartItem({{ $cartItem->id }})">
                            <i class="fa fa-spinner fa-spin"></i>
                          </span>
                        </button>
                      </div>

                    </div>
                  </div>
                @endif
              @endforeach

            </div>
          </div>

          {{-- ── Order summary ── --}}
          <div class="col-md-4">
            <div class="cart-summary-box">
              <p class="total-label mb-1">Order Summary</p>
              <div class="section-divider mb-3"></div>

              <div class="d-flex justify-content-between mb-2" style="font-size:13px;color:#6b7280;">
                <span>Subtotal</span>
                <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2" style="font-size:13px;color:#6b7280;">
                <span>Shipping</span>
                <span>Calculated at checkout</span>
              </div>
              <hr style="border-color:#e8e8e8;">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="total-label">Total</span>
                <span class="total-amount">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
              </div>

              <a href="/checkout" class="btn-checkout">Proceed to Checkout</a>

              <div class="mt-3 text-center" style="font-size:11px;color:#6b7280;">
                <i class="fa fa-lock me-1"></i> Secure &amp; Encrypted Checkout
              </div>
            </div>
          </div>

        </div>
      @endif

    </div>
  </div>
</div>
