@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')

<div class="py-5">
  <div class="container">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-5">
      <div>
        <p class="section-title mb-1">Account</p>
        <div class="section-divider mb-0"></div>
        <p class="section-heading mb-1 mt-2">Order Detail</p>
        <p style="font-size:13px;color:#6b7280;margin-bottom:0;">
          Placed on {{ $order->created_at->format('d F Y, H:i') }}
        </p>
      </div>
      <a href="{{ route('user.orders') }}" style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#1a1a1a;text-decoration:none;border-bottom:2px solid #1a1a1a;padding-bottom:2px;">
        ← All Orders
      </a>
    </div>

    {{-- ── Status Timeline ── --}}
    @php
      $status          = strtolower($order->status_message ?? 'in progress');
      $stages          = ['in progress', 'shipped', 'out for delivery', 'delivered'];
      $isCancelled     = str_contains($status, 'cancelled');
      $isPendingPayment = str_contains($status, 'pending payment');

      $currentIndex = 0;
      foreach ($stages as $i => $stage) {
        if (str_contains($status, $stage)) {
          $currentIndex = $i;
        }
      }
    @endphp

    <div class="mb-5" style="border:1.5px solid #e8e8e8;padding:32px 28px;">
      <p style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#6b7280;margin-bottom:24px;">
        Order Status
      </p>

      @if ($isCancelled)
        <div class="d-flex align-items-center gap-3" style="color:#dc2626;">
          <div style="width:40px;height:40px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa fa-times" style="font-size:18px;"></i>
          </div>
          <div>
            <p style="font-size:15px;font-weight:800;margin-bottom:2px;color:#dc2626;">Order Cancelled</p>
            <p style="font-size:13px;color:#6b7280;margin-bottom:0;">This order has been cancelled.</p>
          </div>
        </div>

      @elseif ($isPendingPayment)
        <div class="d-flex align-items-center gap-3">
          <div style="width:40px;height:40px;background:#fff3cd;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;animation:pulse 1.5s infinite;">
            <i class="fa fa-qrcode" style="font-size:18px;color:#856404;"></i>
          </div>
          <div>
            <p style="font-size:15px;font-weight:800;margin-bottom:2px;color:#856404;">Menunggu Verifikasi Pembayaran</p>
            <p style="font-size:13px;color:#6b7280;margin-bottom:0;">
              Pembayaran QRIS kamu sedang diverifikasi oleh tim kami. Biasanya selesai dalam 1×24 jam.
            </p>
          </div>
        </div>
        <div class="mt-3 p-3" style="background:#fff8e1;border:1px solid #ffe082;border-radius:2px;font-size:13px;color:#5d4037;">
          <i class="fa fa-info-circle me-2"></i>
          Jika pembayaran belum diverifikasi lebih dari 24 jam, silakan hubungi kami dengan menyertakan bukti pembayaran.
        </div>
        <style>
          @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(133,100,4,0.2); }
            50%       { box-shadow: 0 0 0 8px rgba(133,100,4,0); }
          }
        </style>

      @else
        {{-- Progress bar --}}
        <div class="order-status-scroll">
        <div class="order-status-inner">
        <div class="d-flex align-items-center" style="position:relative;">
          @foreach ($stages as $i => $stage)
            @php
              $done   = $i <= $currentIndex;
              $active = $i === $currentIndex;
            @endphp

            {{-- Step circle --}}
            <div class="text-center" style="flex:0 0 auto;position:relative;z-index:1;">
              <div style="
                width: {{ $active ? '40px' : '32px' }};
                height: {{ $active ? '40px' : '32px' }};
                border-radius: 50%;
                background: {{ $done ? '#1a1a1a' : '#e8e8e8' }};
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 8px;
                transition: all 0.3s;
                border: {{ $active ? '3px solid #1a1a1a' : 'none' }};
                box-shadow: {{ $active ? '0 0 0 4px rgba(26,26,26,0.1)' : 'none' }};
              ">
                @if ($done && !$active)
                  <i class="fa fa-check" style="color:#fff;font-size:12px;"></i>
                @elseif ($active)
                  <div style="width:10px;height:10px;background:#fff;border-radius:50%;"></div>
                @else
                  <div style="width:10px;height:10px;background:#aaa;border-radius:50%;"></div>
                @endif
              </div>
              <p style="font-size:10px;font-weight:{{ $done ? '800' : '600' }};letter-spacing:0.5px;text-transform:uppercase;color:{{ $done ? '#1a1a1a' : '#9ca3af' }};margin-bottom:0;white-space:nowrap;">
                {{ ucwords($stage) }}
              </p>
            </div>

            {{-- Connector line --}}
            @if (!$loop->last)
              <div style="flex:1;height:2px;background:{{ $i < $currentIndex ? '#1a1a1a' : '#e8e8e8' }};margin: 0 4px;margin-bottom:28px;"></div>
            @endif

          @endforeach
        </div>
        </div>
        </div>
      @endif
    </div>

    <div class="row g-4">

      {{-- ── Left: Order items ── --}}
      <div class="col-md-8">
        <div style="border:1.5px solid #e8e8e8;">

          <div style="padding:16px 24px;border-bottom:1.5px solid #e8e8e8;background:#f7f7f7;">
            <p style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#6b7280;margin-bottom:0;">
              Items Ordered
            </p>
          </div>

          @php $grandTotal = 0; @endphp

          @forelse ($order->orderItems as $item)
            @php
              $subtotal = $item->price * $item->quantity;
              $grandTotal += $subtotal;
            @endphp
            <div style="padding:20px 24px;border-bottom:1px solid #f0f0f0;">
              <div class="d-flex align-items-center gap-3">

                {{-- Image --}}
                @if ($item->product && $item->product->image)
                  <a href="{{ url('collections/' . $item->product->category_id . '/' . $item->product->id) }}">
                    <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                         style="width:80px;height:80px;object-fit:cover;flex-shrink:0;"
                         alt="{{ $item->product->product_name }}">
                  </a>
                @else
                  <div style="width:80px;height:80px;background:#f0f0f0;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                    <i class="fa fa-image" style="color:#ccc;font-size:24px;"></i>
                  </div>
                @endif

                {{-- Info --}}
                <div class="flex-grow-1">
                  <p style="font-size:15px;font-weight:700;color:#1a1a1a;margin-bottom:4px;">
                    {{ $item->product->product_name ?? 'Product no longer available' }}
                  </p>
                  <p style="font-size:13px;color:#6b7280;margin-bottom:0;">
                    Rp{{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
                  </p>
                </div>

                {{-- Subtotal --}}
                <div class="text-end" style="flex-shrink:0;">
                  <p style="font-size:15px;font-weight:800;color:#1a1a1a;margin-bottom:0;">
                    Rp{{ number_format($subtotal, 0, ',', '.') }}
                  </p>
                </div>

              </div>
            </div>
          @empty
            <div style="padding:24px;text-align:center;color:#6b7280;font-size:13px;">
              No items found.
            </div>
          @endforelse

          {{-- Grand Total --}}
          <div class="d-flex justify-content-between align-items-center"
               style="padding:18px 24px;background:#f7f7f7;border-top:1.5px solid #e8e8e8;">
            <span style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#6b7280;">
              Grand Total
            </span>
            <span style="font-size:20px;font-weight:800;color:#1a1a1a;">
              Rp{{ number_format($grandTotal, 0, ',', '.') }}
            </span>
          </div>

        </div>
      </div>

      {{-- ── Right: Info cards ── --}}
      <div class="col-md-4">

        {{-- Order info --}}
        <div style="border:1.5px solid #e8e8e8;padding:20px;margin-bottom:16px;">
          <p style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#6b7280;margin-bottom:14px;">
            Order Info
          </p>
          <div class="d-flex flex-column gap-2" style="font-size:13px;">
            <div class="d-flex justify-content-between">
              <span style="color:#6b7280;">Tracking No</span>
              <span style="font-family:monospace;font-weight:700;font-size:12px;">{{ $order->tracking_no }}</span>
            </div>
            <div class="d-flex justify-content-between">
              <span style="color:#6b7280;">Payment</span>
              <span style="font-weight:600;">{{ $order->payment_mode ?? '—' }}</span>
            </div>
            <div class="d-flex justify-content-between">
              <span style="color:#6b7280;">Date</span>
              <span>{{ $order->created_at->format('d M Y') }}</span>
            </div>
          </div>
        </div>

        {{-- Shipping address --}}
        <div style="border:1.5px solid #e8e8e8;padding:20px;">
          <p style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#6b7280;margin-bottom:14px;">
            Shipping To
          </p>
          <p style="font-size:14px;font-weight:700;color:#1a1a1a;margin-bottom:4px;">{{ $order->fullname }}</p>
          <p style="font-size:13px;color:#6b7280;margin-bottom:4px;">{{ $order->phone }}</p>
          <p style="font-size:13px;color:#6b7280;margin-bottom:4px;">{{ $order->address }}</p>
          <p style="font-size:13px;color:#6b7280;margin-bottom:0;">Postal code: {{ $order->pincode }}</p>
        </div>

      </div>
    </div>

  </div>
</div>

@endsection
