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
    <h4 class="mb-1 fw-bold">Orders</h4>
    <p class="text-muted mb-0" style="font-size:13px;">All incoming customer orders</p>
  </div>
</div>

{{-- Table card --}}
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">

    @if ($orders->isEmpty())
      <div class="text-center py-5">
        <div style="width:64px;height:64px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
          <i class="mdi mdi-shopping-outline" style="font-size:32px;color:#9e9e9e;"></i>
        </div>
        <p class="fw-semibold mb-1">No orders yet</p>
        <p class="text-muted" style="font-size:13px;">Orders will appear here once customers place them.</p>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:13px;">
          <thead style="background:#f9f9f9;">
            <tr>
              <th class="px-4 py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">#</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Tracking No</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Customer</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Payment</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Status</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Date</th>
              <th class="py-3 pe-4 border-0 text-muted fw-semibold text-end" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr style="border-bottom:1px solid #f7f7f7;">
                <td class="px-4 border-0 text-muted">{{ $order->id }}</td>
                <td class="border-0">
                  <span class="fw-semibold" style="font-family:monospace;font-size:12px;">
                    {{ $order->tracking_no }}
                  </span>
                </td>
                <td class="border-0">
                  <span class="fw-semibold d-block">{{ $order->fullname }}</span>
                  <span class="text-muted" style="font-size:12px;">{{ $order->email }}</span>
                </td>
                <td class="border-0 text-muted">{{ $order->payment_mode ?? '—' }}</td>
                <td class="border-0">
                  @php
                    $status = strtolower($order->status_message ?? '');
                    $badge = match(true) {
                      str_contains($status, 'delivered') => ['bg-success', 'text-success'],
                      str_contains($status, 'cancelled') => ['bg-danger',  'text-danger'],
                      str_contains($status, 'shipped')   => ['bg-info',    'text-info'],
                      default                            => ['bg-warning', 'text-warning'],
                    };
                  @endphp
                  <span class="badge {{ $badge[0] }} bg-opacity-10 {{ $badge[1] }}" style="font-size:11px;text-transform:capitalize;">
                    {{ $order->status_message ?? 'in progress' }}
                  </span>
                </td>
                <td class="border-0 text-muted" style="font-size:12px;">
                  {{ $order->created_at->format('d M Y') }}<br>
                  <span style="font-size:11px;">{{ $order->created_at->format('H:i') }}</span>
                </td>
                <td class="border-0 pe-4 text-end">
                  <a href="{{ route('admin.orders.show', $order->id) }}"
                     class="btn btn-outline-dark btn-sm" style="font-size:11px;">
                    <i class="mdi mdi-eye-outline me-1"></i> View
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($orders->hasPages())
        <div class="px-4 py-3" style="border-top:1px solid #f0f0f0;">
          {{ $orders->links() }}
        </div>
      @endif
    @endif

  </div>
</div>

@endsection
