@extends('layouts.app')

@section('title', 'My Account')

@section('content')

<div class="py-5">
  <div class="container">

    {{-- Greeting --}}
    <div class="mb-5">
      <p class="section-title mb-1">Welcome back</p>
      <div class="section-divider mb-0"></div>
      <p class="section-heading mb-0 mt-2">{{ Auth::user()->name }}</p>
    </div>

    @if (session('status'))
      <div class="alert alert-success border-0 rounded-0 mb-4" style="font-size:13px;">
        <i class="fa fa-check-circle me-2"></i>{{ session('status') }}
      </div>
    @endif

    {{-- Quick links --}}
    <div class="row g-3 mb-5">
      <div class="col-6 col-md-3">
        <a href="{{ route('user.orders') }}" style="text-decoration:none;">
          <div style="border:1.5px solid #e8e8e8;padding:24px 20px;text-align:center;transition:border-color 0.2s;"
               onmouseover="this.style.borderColor='#1a1a1a'" onmouseout="this.style.borderColor='#e8e8e8'">
            <i class="fa fa-shopping-bag fa-2x d-block mb-2" style="color:#1a1a1a;"></i>
            <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#1a1a1a;margin-bottom:0;">
              My Orders
            </p>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="/wishlist" style="text-decoration:none;">
          <div style="border:1.5px solid #e8e8e8;padding:24px 20px;text-align:center;transition:border-color 0.2s;"
               onmouseover="this.style.borderColor='#1a1a1a'" onmouseout="this.style.borderColor='#e8e8e8'">
            <i class="fa fa-heart-o fa-2x d-block mb-2" style="color:#1a1a1a;"></i>
            <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#1a1a1a;margin-bottom:0;">
              Wishlist
            </p>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="/cart" style="text-decoration:none;">
          <div style="border:1.5px solid #e8e8e8;padding:24px 20px;text-align:center;transition:border-color 0.2s;"
               onmouseover="this.style.borderColor='#1a1a1a'" onmouseout="this.style.borderColor='#e8e8e8'">
            <i class="fa fa-shopping-cart fa-2x d-block mb-2" style="color:#1a1a1a;"></i>
            <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#1a1a1a;margin-bottom:0;">
              My Cart
            </p>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="/collections" style="text-decoration:none;">
          <div style="border:1.5px solid #e8e8e8;padding:24px 20px;text-align:center;transition:border-color 0.2s;"
               onmouseover="this.style.borderColor='#1a1a1a'" onmouseout="this.style.borderColor='#e8e8e8'">
            <i class="fa fa-th-large fa-2x d-block mb-2" style="color:#1a1a1a;"></i>
            <p style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#1a1a1a;margin-bottom:0;">
              Shop Now
            </p>
          </div>
        </a>
      </div>
    </div>

    {{-- Recent orders --}}
    <div>
      <div class="d-flex justify-content-between align-items-end mb-3">
        <p style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#1a1a1a;margin-bottom:0;">
          Recent Orders
        </p>
        <a href="{{ route('user.orders') }}" style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#1a1a1a;text-decoration:none;border-bottom:1.5px solid #1a1a1a;padding-bottom:1px;">
          View All
        </a>
      </div>

      @php
        $recentOrders = \App\Models\Order::with('orderItems')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();
      @endphp

      @if ($recentOrders->isEmpty())
        <div style="border:1.5px solid #e8e8e8;padding:40px;text-align:center;">
          <i class="fa fa-shopping-bag fa-2x d-block mb-3" style="color:#e8e8e8;"></i>
          <p style="font-size:13px;color:#6b7280;margin-bottom:12px;">You haven't placed any orders yet.</p>
          <a href="/collections" class="btn-checkout d-inline-block" style="width:auto;padding:10px 28px;font-size:11px;">
            Start Shopping
          </a>
        </div>
      @else
        <div style="border:1.5px solid #e8e8e8;">
          @foreach ($recentOrders as $order)
            @php
              $total = $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
              $status = strtolower($order->status_message ?? 'in progress');
              [$bgClass, $textClass] = match(true) {
                str_contains($status, 'delivered')        => ['bg-success',   'text-success'],
                str_contains($status, 'cancelled')        => ['bg-danger',    'text-danger'],
                str_contains($status, 'shipped')          => ['bg-info',      'text-info'],
                str_contains($status, 'out for delivery') => ['bg-info',      'text-info'],
                str_contains($status, 'pending payment')  => ['bg-secondary', 'text-secondary'],
                default                                   => ['bg-warning',   'text-warning'],
              };
            @endphp
            <div style="padding:16px 24px;border-bottom:1px solid #f0f0f0;" class="d-flex justify-content-between align-items-center flex-wrap gap-2">
              <div>
                <p style="font-family:monospace;font-size:12px;font-weight:700;color:#1a1a1a;margin-bottom:4px;">
                  {{ $order->tracking_no }}
                </p>
                <p style="font-size:12px;color:#6b7280;margin-bottom:0;">
                  {{ $order->created_at->format('d M Y') }}
                  &nbsp;·&nbsp;
                  {{ $order->orderItems->count() }} item(s)
                  &nbsp;·&nbsp;
                  <strong style="color:#1a1a1a;">Rp{{ number_format($total, 0, ',', '.') }}</strong>
                </p>
              </div>
              <div class="d-flex align-items-center gap-3">
                <span class="badge {{ $bgClass }} bg-opacity-10 {{ $textClass }}" style="font-size:11px;text-transform:capitalize;">
                  {{ ucfirst($order->status_message ?? 'in progress') }}
                </span>
                <a href="{{ route('user.orders.show', $order->id) }}"
                   style="font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#1a1a1a;text-decoration:none;border-bottom:1.5px solid #1a1a1a;">
                  Detail
                </a>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

  </div>
</div>

@endsection
