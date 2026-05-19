@extends('layouts.admin')

@section('content')

{{-- Flash --}}
@if (session('message'))
  <div class="alert alert-success border-0 alert-dismissible fade show" role="alert" style="font-size:13px;">
    <i class="mdi mdi-check-circle me-2"></i>{{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="mb-1 fw-bold">Order Detail</h4>
    <p class="text-muted mb-0" style="font-size:13px;">
      <span style="font-family:monospace;">{{ $order->tracking_no }}</span>
      &nbsp;·&nbsp; {{ $order->created_at->format('d M Y, H:i') }}
    </p>
  </div>
  <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
    <i class="mdi mdi-arrow-left me-1"></i> Back to Orders
  </a>
</div>

<div class="row g-4">

  {{-- ── Left column ── --}}
  <div class="col-md-8">

    {{-- Order items --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body p-0">
        <div class="px-4 py-3" style="border-bottom:1px solid #f0f0f0;">
          <h6 class="fw-bold mb-0">Items Ordered</h6>
        </div>

        @php $grandTotal = 0; @endphp

        <div class="table-responsive">
          <table class="table align-middle mb-0" style="font-size:13px;">
            <thead style="background:#f9f9f9;">
              <tr>
                <th class="px-4 py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Product</th>
                <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Unit Price</th>
                <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Qty</th>
                <th class="py-3 pe-4 border-0 text-muted fw-semibold text-end" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($order->orderItems as $item)
                @php
                  $subtotal = $item->price * $item->quantity;
                  $grandTotal += $subtotal;
                @endphp
                <tr style="border-bottom:1px solid #f7f7f7;">
                  <td class="px-4 border-0">
                    <div class="d-flex align-items-center gap-3">
                      @if ($item->product && $item->product->image)
                        <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                             style="width:48px;height:48px;object-fit:cover;border-radius:6px;flex-shrink:0;"
                             alt="{{ $item->product->product_name }}">
                      @else
                        <div style="width:48px;height:48px;background:#f0f0f0;border-radius:6px;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                          <i class="mdi mdi-image text-muted"></i>
                        </div>
                      @endif
                      <div>
                        <span class="fw-semibold d-block">
                          {{ $item->product->product_name ?? 'Product Deleted' }}
                        </span>
                        @if ($item->product)
                          <span class="text-muted" style="font-size:11px;">
                            ID #{{ $item->product_id }}
                          </span>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td class="border-0">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                  <td class="border-0">
                    <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size:12px;">
                      × {{ $item->quantity }}
                    </span>
                  </td>
                  <td class="border-0 pe-4 text-end fw-bold">
                    Rp{{ number_format($subtotal, 0, ',', '.') }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4 border-0">No items found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Total --}}
        <div class="px-4 py-3 d-flex justify-content-between align-items-center"
             style="border-top:2px solid #f0f0f0;background:#fafafa;">
          <span class="text-muted fw-semibold" style="font-size:12px;letter-spacing:1px;text-transform:uppercase;">
            Grand Total
          </span>
          <span class="fw-bold" style="font-size:18px;">
            Rp{{ number_format($grandTotal, 0, ',', '.') }}
          </span>
        </div>

      </div>
    </div>

    {{-- Shipping address --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="fw-bold mb-3">Shipping Address</h6>
        <p class="mb-1 fw-semibold">{{ $order->fullname }}</p>
        <p class="mb-1 text-muted" style="font-size:13px;">{{ $order->address }}</p>
        <p class="mb-0 text-muted" style="font-size:13px;">Postal code: {{ $order->pincode }}</p>
      </div>
    </div>

  </div>

  {{-- ── Right column ── --}}
  <div class="col-md-4">

    {{-- Status update --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <h6 class="fw-bold mb-3">Order Status</h6>

        @php
          $status  = strtolower($order->status_message ?? '');
          $badge   = match(true) {
            str_contains($status, 'delivered')             => ['bg-success', 'text-success'],
            str_contains($status, 'cancelled')             => ['bg-danger',  'text-danger'],
            str_contains($status, 'shipped')               => ['bg-info',    'text-info'],
            str_contains($status, 'pending payment')       => ['bg-secondary','text-secondary'],
            default                                        => ['bg-warning', 'text-warning'],
          };
        @endphp

        <div class="mb-3">
          <span class="badge {{ $badge[0] }} bg-opacity-10 {{ $badge[1] }} px-3 py-2"
                style="font-size:13px;text-transform:capitalize;">
            {{ $order->status_message ?? 'in progress' }}
          </span>
          @if ($order->payment_mode === 'QRIS' && str_contains($status, 'pending payment'))
            <div class="mt-2 p-2" style="background:#fff3cd;border:1px solid #ffc107;border-radius:4px;font-size:12px;color:#856404;">
              <i class="mdi mdi-alert me-1"></i>
              Verifikasi pembayaran QRIS dari customer sebelum mengubah status.
            </div>
          @endif
        </div>

        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
          @csrf
          @method('PUT')
          <label class="form-label text-muted" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">
            Update Status
          </label>
          <select name="status_message" class="form-select form-select-sm mb-3"
                  style="border-radius:0;border-color:#dee2e6;font-size:13px;">
            @foreach ([
              'pending payment verification',
              'in progress',
              'shipped',
              'out for delivery',
              'delivered',
              'cancelled',
            ] as $s)
              <option value="{{ $s }}" {{ $order->status_message === $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
              </option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-dark btn-sm w-100" style="border-radius:0;font-size:12px;letter-spacing:1px;">
            Update Status
          </button>
        </form>
      </div>
    </div>

    {{-- Customer info --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <h6 class="fw-bold mb-3">Customer</h6>
        <div class="d-flex flex-column gap-2" style="font-size:13px;">
          <div class="d-flex justify-content-between">
            <span class="text-muted">Name</span>
            <span class="fw-semibold">{{ $order->fullname }}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted">Email</span>
            <span>{{ $order->email }}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted">Phone</span>
            <span>{{ $order->phone }}</span>
          </div>
          @if ($order->user)
            <div class="d-flex justify-content-between">
              <span class="text-muted">Account</span>
              <span class="fw-semibold">{{ $order->user->name }}</span>
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Payment info --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="fw-bold mb-3">Payment</h6>
        <div class="d-flex flex-column gap-2" style="font-size:13px;">
          <div class="d-flex justify-content-between">
            <span class="text-muted">Method</span>
            <span class="fw-semibold">{{ $order->payment_mode ?? '—' }}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted">Payment ID</span>
            <span style="font-family:monospace;font-size:12px;">{{ $order->payment_id ?? '—' }}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted">Tracking No</span>
            <span style="font-family:monospace;font-size:12px;">{{ $order->tracking_no }}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted">Order Date</span>
            <span>{{ $order->created_at->format('d M Y') }}</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
