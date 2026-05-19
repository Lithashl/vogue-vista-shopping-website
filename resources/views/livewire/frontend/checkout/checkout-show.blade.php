<div>
  <div class="py-5 checkout">
    <div class="container">

      {{-- Header --}}
      <div class="mb-5">
        <p class="section-title mb-1">Almost There</p>
        <div class="section-divider mb-0"></div>
        <p class="mb-0 mt-2" style="font-size:22px;font-weight:800;color:#1a1a1a;font-family:'Playfair Display',serif;">
          Checkout
        </p>
      </div>

      {{-- Flash --}}
      @if (session()->has('message'))
        <div class="alert alert-success border-0 rounded-0 mb-4" style="font-size:13px;">
          <i class="fa fa-check-circle me-2"></i>{{ session('message') }}
        </div>
      @endif
      @if (session()->has('error'))
        <div class="alert alert-danger border-0 rounded-0 mb-4" style="font-size:13px;">
          <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
      @endif

      <div class="row g-5">

        {{-- ── Left: shipping + payment ── --}}
        <div class="col-md-7">

          {{-- 01 Shipping --}}
          <div class="mb-5">
            <p style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#6b7280;margin-bottom:16px;">
              01 — Shipping Information
            </p>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" wire:model="fullname" class="form-control" placeholder="Enter your full name" />
                @error('fullname') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="text" wire:model="phone" class="form-control" placeholder="e.g. 08123456789" />
                @error('phone') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Email Address</label>
                <input type="email" wire:model="email" class="form-control" placeholder="email@example.com" />
                @error('email') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Postal Code</label>
                <input type="text" wire:model="pincode" class="form-control" placeholder="6-digit postal code" maxlength="6" />
                @error('pincode') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
              </div>
              <div class="col-md-12">
                <label class="form-label">Full Address</label>
                <textarea wire:model="address" class="form-control" rows="3" placeholder="Street address, city, province…"></textarea>
                @error('address') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          {{-- 02 Payment --}}
          <div>
            <p style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#6b7280;margin-bottom:16px;">
              02 — Payment Method
            </p>

            {{-- Payment tabs --}}
            <div class="row g-3 mb-4">
              <div class="col-6">
                <button type="button"
                        class="payment-tab-btn {{ $payment_mode === 'Cash on Delivery' ? 'active' : '' }}"
                        wire:click="$set('payment_mode', 'Cash on Delivery')">
                  <i class="fa fa-money me-2"></i> Cash on Delivery
                </button>
              </div>
              <div class="col-6">
                <button type="button"
                        class="payment-tab-btn {{ $payment_mode === 'QRIS' ? 'active' : '' }}"
                        wire:click="$set('payment_mode', 'QRIS')">
                  <i class="fa fa-qrcode me-2"></i> QRIS / Scan QR
                </button>
              </div>
            </div>

            {{-- COD Panel --}}
            @if ($payment_mode === 'Cash on Delivery')
              <div class="p-4" style="background:#f7f7f7;border:1.5px solid #e8e8e8;">
                <div class="d-flex align-items-start gap-3 mb-4">
                  <div style="width:40px;height:40px;background:#1a1a1a;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa fa-money" style="color:#fff;font-size:16px;"></i>
                  </div>
                  <div>
                    <p style="font-size:14px;font-weight:700;color:#1a1a1a;margin-bottom:4px;">Cash on Delivery</p>
                    <p style="font-size:13px;color:#6b7280;margin-bottom:0;">Pay with cash when your order arrives. Please have the exact amount ready for the courier.</p>
                  </div>
                </div>
                <button type="button" wire:click="codOrder" class="place-order-btn">
                  <span wire:loading.remove wire:target="codOrder">Place Order — Cash on Delivery</span>
                  <span wire:loading wire:target="codOrder"><i class="fa fa-spinner fa-spin me-2"></i>Placing Order…</span>
                </button>
              </div>

            {{-- QRIS Panel --}}
            @elseif ($payment_mode === 'QRIS')
              @php
                $qrisImage    = \App\Models\Setting::get('qris_image');
                $merchantName = \App\Models\Setting::get('qris_merchant_name', 'VogueVista');
                $nmid         = \App\Models\Setting::get('qris_nmid');
              @endphp

              <div style="border:1.5px solid #e8e8e8;">

                {{-- QRIS header --}}
                <div style="background:#1a1a1a;padding:14px 20px;display:flex;align-items:center;gap:10px;">
                  <i class="fa fa-qrcode" style="color:#fff;font-size:20px;"></i>
                  <div>
                    <p style="font-size:13px;font-weight:800;color:#fff;margin-bottom:0;letter-spacing:0.5px;">QRIS Payment</p>
                    <p style="font-size:11px;color:rgba(255,255,255,0.6);margin-bottom:0;letter-spacing:0.5px;">Scan with any e-wallet or mobile banking</p>
                  </div>
                  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/QRIS_logo.svg/200px-QRIS_logo.svg.png"
                       style="height:28px;margin-left:auto;opacity:0.9;"
                       alt="QRIS" onerror="this.style.display='none'">
                </div>

                <div class="p-4">
                  <div class="row g-4 align-items-center">

                    {{-- QR Code --}}
                    <div class="col-md-5 text-center">
                      @if ($qrisImage)
                        <div style="display:inline-block;padding:16px;border:1.5px solid #e8e8e8;background:#fff;border-radius:4px;">
                          <img src="{{ asset($qrisImage) }}"
                               style="width:180px;height:180px;object-fit:contain;display:block;"
                               alt="QRIS QR Code">
                        </div>
                        <p style="font-size:10px;color:#9ca3af;margin-top:8px;margin-bottom:0;letter-spacing:0.5px;">
                          Scan QR Code di atas
                        </p>
                      @else
                        <div style="width:180px;height:180px;border:2px dashed #e8e8e8;border-radius:4px;display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0 auto;">
                          <i class="fa fa-qrcode" style="font-size:48px;color:#ddd;margin-bottom:8px;"></i>
                          <p style="font-size:11px;color:#9ca3af;margin-bottom:0;text-align:center;padding:0 12px;">QRIS not configured yet. Please contact admin.</p>
                        </div>
                      @endif
                    </div>

                    {{-- Payment instructions --}}
                    <div class="col-md-7">
                      <div style="margin-bottom:16px;">
                        <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#9ca3af;margin-bottom:4px;">Merchant</p>
                        <p style="font-size:15px;font-weight:800;color:#1a1a1a;margin-bottom:0;">{{ $merchantName }}</p>
                        @if ($nmid)
                          <p style="font-size:11px;color:#9ca3af;margin-bottom:0;font-family:monospace;">NMID: {{ $nmid }}</p>
                        @endif
                      </div>

                      <div style="background:#f7f7f7;padding:14px;border-radius:2px;margin-bottom:16px;">
                        <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#9ca3af;margin-bottom:4px;">Total to Pay</p>
                        <p style="font-size:24px;font-weight:800;color:#1a1a1a;margin-bottom:0;">
                          Rp{{ number_format($totalProductAmount, 0, ',', '.') }}
                        </p>
                      </div>

                      <div style="margin-bottom:20px;">
                        <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#9ca3af;margin-bottom:10px;">Cara Pembayaran</p>
                        <div class="d-flex flex-column gap-2" style="font-size:13px;color:#374151;">
                          <div class="d-flex gap-2">
                            <span style="width:18px;height:18px;background:#1a1a1a;color:#fff;border-radius:50%;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">1</span>
                            <span>Buka aplikasi dompet digital atau mobile banking kamu</span>
                          </div>
                          <div class="d-flex gap-2">
                            <span style="width:18px;height:18px;background:#1a1a1a;color:#fff;border-radius:50%;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">2</span>
                            <span>Pilih menu <strong>Scan QR</strong> atau <strong>QRIS</strong></span>
                          </div>
                          <div class="d-flex gap-2">
                            <span style="width:18px;height:18px;background:#1a1a1a;color:#fff;border-radius:50%;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">3</span>
                            <span>Scan QR code di atas & masukkan nominal <strong>Rp{{ number_format($totalProductAmount, 0, ',', '.') }}</strong></span>
                          </div>
                          <div class="d-flex gap-2">
                            <span style="width:18px;height:18px;background:#1a1a1a;color:#fff;border-radius:50%;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">4</span>
                            <span>Klik tombol di bawah setelah pembayaran berhasil</span>
                          </div>
                        </div>
                      </div>

                      {{-- Accepted wallets --}}
                      <div style="margin-bottom:20px;">
                        <p style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Diterima oleh</p>
                        <div class="d-flex flex-wrap gap-1">
                          @foreach (['GoPay', 'OVO', 'DANA', 'ShopeePay', 'LinkAja', 'BCA', 'BNI', 'BRI', 'Mandiri'] as $w)
                            <span style="font-size:10px;font-weight:700;padding:3px 8px;border:1px solid #e8e8e8;color:#374151;background:#fff;">{{ $w }}</span>
                          @endforeach
                        </div>
                      </div>

                    </div>
                  </div>

                  {{-- Confirm button --}}
                  @if ($qrisImage)
                    <div style="border-top:1.5px solid #e8e8e8;padding-top:20px;margin-top:4px;">
                      <button type="button" wire:click="qrisOrder" class="place-order-btn">
                        <span wire:loading.remove wire:target="qrisOrder">
                          <i class="fa fa-check me-2"></i>Saya Sudah Membayar — Konfirmasi Pesanan
                        </span>
                        <span wire:loading wire:target="qrisOrder">
                          <i class="fa fa-spinner fa-spin me-2"></i>Memproses…
                        </span>
                      </button>
                      <p style="font-size:11px;color:#9ca3af;margin-top:10px;margin-bottom:0;text-align:center;">
                        <i class="fa fa-lock me-1"></i>
                        Pesanan akan diverifikasi oleh tim kami dalam 1×24 jam
                      </p>
                    </div>
                  @else
                    <div style="border-top:1.5px solid #e8e8e8;padding-top:20px;margin-top:4px;text-align:center;">
                      <p style="font-size:13px;color:#9ca3af;">QRIS belum dikonfigurasi. Silakan pilih metode pembayaran lain atau hubungi kami.</p>
                    </div>
                  @endif

                </div>
              </div>

            {{-- Nothing selected --}}
            @else
              <div style="padding:24px;border:1.5px dashed #e8e8e8;text-align:center;color:#9ca3af;font-size:13px;">
                <i class="fa fa-arrow-up me-1"></i> Pilih metode pembayaran di atas.
              </div>
            @endif

          </div>
        </div>

        {{-- ── Right: order summary ── --}}
        <div class="col-md-5">
          <div class="checkout-summary-box">
            <p class="summary-label mb-1">Order Total</p>
            <div class="section-divider mb-3"></div>

            <p class="summary-amount mb-1">
              Rp{{ number_format($totalProductAmount, 0, ',', '.') }}
            </p>
            <p style="font-size:12px;color:#6b7280;margin-bottom:20px;">
              Includes all taxes &amp; fees
            </p>

            <div class="d-flex flex-column gap-2" style="font-size:13px;color:#6b7280;">
              <div class="d-flex justify-content-between">
                <span>Subtotal</span>
                <span>Rp{{ number_format($totalProductAmount, 0, ',', '.') }}</span>
              </div>
              <div class="d-flex justify-content-between">
                <span>Shipping</span>
                <span>Calculated at delivery</span>
              </div>
              <hr style="border-color:#e8e8e8;margin:8px 0;">
              <div class="d-flex justify-content-between fw-bold" style="color:#1a1a1a;font-size:15px;">
                <span>Total</span>
                <span>Rp{{ number_format($totalProductAmount, 0, ',', '.') }}</span>
              </div>
            </div>

            <div class="mt-4 pt-3" style="border-top:1px solid #e8e8e8;">
              <div class="d-flex align-items-center gap-2 mb-2" style="font-size:12px;color:#6b7280;">
                <i class="fa fa-truck"></i>
                <span>Estimated delivery: 3–5 business days</span>
              </div>
              <div class="d-flex align-items-center gap-2" style="font-size:12px;color:#6b7280;">
                <i class="fa fa-lock"></i>
                <span>Secure &amp; encrypted checkout</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
