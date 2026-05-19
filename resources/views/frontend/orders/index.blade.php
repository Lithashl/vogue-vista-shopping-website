@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

<div class="py-5">
  <div class="container">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
      <div>
        <p class="section-title mb-1">Account</p>
        <div class="section-divider mb-0"></div>
        <p class="mb-0 mt-2" style="font-size:22px;font-weight:800;color:#1a1a1a;font-family:'Playfair Display',serif;">
          My Orders
        </p>
      </div>
      <a href="/collections" style="font-size:11px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#1a1a1a;text-decoration:none;border-bottom:2px solid #1a1a1a;padding-bottom:2px;">
        Continue Shopping
      </a>
    </div>

    @if ($orders->isEmpty())
      <div class="empty-state py-5">
        <i class="fa fa-shopping-bag"></i>
        <h5>No Orders Yet</h5>
        <p>You haven't placed any orders. Start shopping!</p>
        <a href="/collections" class="btn btn-checkout d-inline-block mt-3" style="width:auto;padding:12px 32px;">
          Browse Products
        </a>
      </div>
    @else

      {{-- Orders table --}}
      <div style="border:1.5px solid #e8e8e8;">

        {{-- Header row --}}
        <div class="d-none d-md-block" style="background:#f7f7f7;padding:12px 24px;border-bottom:1.5px solid #e8e8e8;">
          <div class="row">
            <div class="col-md-3">
              <span style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#6b7280;">Tracking No</span>
            </div>
            <div class="col-md-2">
              <span style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#6b7280;">Date</span>
            </div>
            <div class="col-md-2">
              <span style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#6b7280;">Items</span>
            </div>
            <div class="col-md-2">
              <span style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#6b7280;">Total</span>
            </div>
            <div class="col-md-2">
              <span style="font-size:11px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:#6b7280;">Status</span>
            </div>
            <div class="col-md-1"></div>
          </div>
        </div>

        @foreach ($orders as $order)
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
          <div style="padding:20px 24px;border-bottom:1px solid #f0f0f0;">
            <div class="row align-items-center g-2">

              {{-- Tracking --}}
              <div class="col-md-3 col-12">
                <span style="font-family:monospace;font-size:12px;font-weight:700;color:#1a1a1a;">
                  {{ $order->tracking_no }}
                </span>
              </div>

              {{-- Date --}}
              <div class="col-md-2 col-6">
                <span style="font-size:13px;color:#6b7280;">
                  {{ $order->created_at->format('d M Y') }}
                </span>
              </div>

              {{-- Items count --}}
              <div class="col-md-2 col-6">
                <span style="font-size:13px;color:#1a1a1a;font-weight:600;">
                  {{ $order->orderItems->count() }} item(s)
                </span>
              </div>

              {{-- Total --}}
              <div class="col-md-2 col-6">
                <span style="font-size:14px;font-weight:800;color:#1a1a1a;">
                  Rp{{ number_format($total, 0, ',', '.') }}
                </span>
              </div>

              {{-- Status --}}
              <div class="col-md-2 col-6">
                <span class="badge {{ $bgClass }} bg-opacity-10 {{ $textClass }}" style="font-size:11px;text-transform:capitalize;padding:5px 10px;">
                  {{ ucfirst($order->status_message ?? 'in progress') }}
                </span>
              </div>

              {{-- Action --}}
              <div class="col-md-1 col-12 text-md-end">
                <a href="{{ route('user.orders.show', $order->id) }}"
                   style="font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#1a1a1a;text-decoration:none;border-bottom:1.5px solid #1a1a1a;">
                  Detail
                </a>
              </div>

            </div>
          </div>
        @endforeach

      </div>

      {{-- Pagination --}}
      @if ($orders->hasPages())
        <div class="mt-4">
          {{ $orders->links() }}
        </div>
      @endif

    @endif

  </div>
</div>

@endsection
