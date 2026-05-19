@extends('layouts.admin')

@section('content')

@if (session('message'))
  <div class="alert alert-success border-0 alert-dismissible fade show" role="alert" style="font-size:13px;">
    <i class="mdi mdi-check-circle me-2"></i>{{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="mb-1 fw-bold">Settings</h4>
    <p class="text-muted mb-0" style="font-size:13px;">Manage store payment settings</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-7">

    <div class="card border-0 shadow-sm">
      <div class="card-body p-0">

        <div class="px-4 py-3" style="border-bottom:1px solid #f0f0f0;">
          <h6 class="fw-bold mb-0">
            <i class="mdi mdi-qrcode me-2"></i>QRIS Payment
          </h6>
        </div>

        <div class="p-4">
          <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Current QR --}}
            @php $qrisImage = \App\Models\Setting::get('qris_image'); @endphp
            @if ($qrisImage)
              <div class="mb-4 text-center">
                <p class="text-muted mb-2" style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">Current QRIS Code</p>
                <img src="{{ asset($qrisImage) }}"
                     style="width:220px;height:220px;object-fit:contain;border:1.5px solid #e8e8e8;padding:12px;border-radius:4px;"
                     alt="QRIS">
              </div>
            @else
              <div class="mb-4 text-center py-4" style="border:2px dashed #e8e8e8;border-radius:4px;">
                <i class="mdi mdi-qrcode" style="font-size:48px;color:#ddd;display:block;margin-bottom:8px;"></i>
                <p class="text-muted mb-0" style="font-size:13px;">No QRIS image uploaded yet</p>
              </div>
            @endif

            {{-- Upload --}}
            <div class="mb-3">
              <label class="form-label fw-semibold" style="font-size:12px;">
                Upload QRIS Image <span class="text-muted fw-normal">(PNG/JPG, max 2MB)</span>
              </label>
              <input type="file" name="qris_image" class="form-control form-control-sm" accept="image/png,image/jpeg">
              @error('qris_image')
                <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
              @enderror
              <div class="form-text">Upload the QRIS QR code image you received from your bank or e-wallet provider.</div>
            </div>

            {{-- Merchant name --}}
            <div class="mb-3">
              <label class="form-label fw-semibold" style="font-size:12px;">Merchant Name</label>
              <input type="text" name="qris_merchant_name" class="form-control form-control-sm"
                     value="{{ \App\Models\Setting::get('qris_merchant_name', 'VogueVista') }}"
                     placeholder="e.g. VogueVista">
            </div>

            {{-- NMID --}}
            <div class="mb-4">
              <label class="form-label fw-semibold" style="font-size:12px;">NMID <span class="text-muted fw-normal">(optional)</span></label>
              <input type="text" name="qris_nmid" class="form-control form-control-sm"
                     value="{{ \App\Models\Setting::get('qris_nmid', '') }}"
                     placeholder="e.g. ID1234567890123">
              <div class="form-text">Nomor Merchant ID ditampilkan pada halaman pembayaran customer.</div>
            </div>

            <button type="submit" class="btn btn-dark btn-sm px-4" style="border-radius:0;font-size:12px;letter-spacing:1px;">
              Save Settings
            </button>

          </form>
        </div>
      </div>
    </div>

  </div>

  <div class="col-md-5">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="mdi mdi-information-outline me-2"></i>How QRIS Works</h6>
        <div class="d-flex flex-column gap-3" style="font-size:13px;color:#6b7280;">
          <div class="d-flex gap-2">
            <span class="fw-bold text-dark" style="flex-shrink:0;">1.</span>
            <span>Upload your QRIS QR code image from your bank or e-wallet (GoPay, OVO, DANA, BCA, dll).</span>
          </div>
          <div class="d-flex gap-2">
            <span class="fw-bold text-dark" style="flex-shrink:0;">2.</span>
            <span>Customers see the QR code at checkout, scan it with their app, and pay.</span>
          </div>
          <div class="d-flex gap-2">
            <span class="fw-bold text-dark" style="flex-shrink:0;">3.</span>
            <span>Orders placed via QRIS will have status <strong class="text-dark">Pending Payment Verification</strong>.</span>
          </div>
          <div class="d-flex gap-2">
            <span class="fw-bold text-dark" style="flex-shrink:0;">4.</span>
            <span>Check your payment app, verify the incoming transfer, then update the order status.</span>
          </div>
        </div>

        <hr style="border-color:#f0f0f0;margin:20px 0;">

        <p class="fw-bold mb-2" style="font-size:12px;letter-spacing:1px;text-transform:uppercase;">Accepted Wallets</p>
        <div class="d-flex flex-wrap gap-2">
          @foreach (['GoPay', 'OVO', 'DANA', 'ShopeePay', 'LinkAja', 'BCA Mobile', 'BNI', 'Mandiri'] as $w)
            <span class="badge bg-light text-dark border" style="font-size:11px;font-weight:600;">{{ $w }}</span>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
