@extends('layouts.admin')

@section('content')

{{-- Flash --}}
@if (session('message'))
  <div class="alert alert-success alert-dismissible fade show border-0 rounded-0 mb-4" role="alert">
    <i class="mdi mdi-check-circle me-2"></i> {{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

{{-- Page heading --}}
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="mb-1 fw-bold">Dashboard</h4>
    <p class="text-muted mb-0" style="font-size:13px;">Welcome back, {{ Auth::user()->name }}</p>
  </div>
  <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
    <i class="mdi mdi-open-in-new me-1"></i> View Store
  </a>
</div>

{{-- ── Stat cards ── --}}
<div class="row g-3 mb-4">

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div style="background:#e8f5e9;width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <i class="mdi mdi-tag-multiple" style="font-size:22px;color:#2e7d32;"></i>
          </div>
          <span class="badge bg-success bg-opacity-10 text-success" style="font-size:11px;">Active</span>
        </div>
        <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
        <p class="text-muted mb-0" style="font-size:12px;text-transform:uppercase;letter-spacing:1px;">Total Products</p>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div style="background:#e3f2fd;width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <i class="mdi mdi-view-grid" style="font-size:22px;color:#1565c0;"></i>
          </div>
          <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size:11px;">Active</span>
        </div>
        <h3 class="fw-bold mb-0">{{ $totalCategories }}</h3>
        <p class="text-muted mb-0" style="font-size:12px;text-transform:uppercase;letter-spacing:1px;">Categories</p>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <a href="{{ route('admin.orders.index') }}" style="text-decoration:none;">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div style="background:#fff3e0;width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
              <i class="mdi mdi-shopping" style="font-size:22px;color:#e65100;"></i>
            </div>
            <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size:11px;">Total</span>
          </div>
          <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
          <p class="text-muted mb-0" style="font-size:12px;text-transform:uppercase;letter-spacing:1px;">Orders</p>
        </div>
      </div>
    </a>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div style="background:#fce4ec;width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <i class="mdi mdi-image-multiple" style="font-size:22px;color:#ad1457;"></i>
          </div>
          <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size:11px;">Live</span>
        </div>
        <h3 class="fw-bold mb-0">{{ $totalSliders }}</h3>
        <p class="text-muted mb-0" style="font-size:12px;text-transform:uppercase;letter-spacing:1px;">Sliders</p>
      </div>
    </div>
  </div>

</div>

{{-- ── Quick actions + recent products ── --}}
<div class="row g-3">

  {{-- Quick actions --}}
  <div class="col-md-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <h6 class="fw-bold mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:#6b7280;">
          Quick Actions
        </h6>
        <div class="d-grid gap-2">
          <a href="{{ url('admin/products/create') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
            <i class="mdi mdi-plus"></i> Add New Product
          </a>
          <a href="{{ url('admin/category/create') }}" class="btn btn-outline-dark btn-sm d-flex align-items-center gap-2">
            <i class="mdi mdi-plus"></i> Add New Category
          </a>
          <a href="{{ url('admin/sliders/create') }}" class="btn btn-outline-dark btn-sm d-flex align-items-center gap-2">
            <i class="mdi mdi-plus"></i> Add New Slider
          </a>
          <hr class="my-1">
          <a href="{{ url('admin/products') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <i class="mdi mdi-format-list-bulleted"></i> Manage Products
          </a>
          <a href="{{ url('admin/category') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <i class="mdi mdi-format-list-bulleted"></i> Manage Categories
          </a>
          <a href="{{ url('admin/sliders') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
            <i class="mdi mdi-format-list-bulleted"></i> Manage Sliders
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Recent products --}}
  <div class="col-md-8">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="fw-bold mb-0" style="font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:#6b7280;">
            Recent Products
          </h6>
          <a href="{{ url('admin/products') }}" class="text-dark" style="font-size:12px;">View all →</a>
        </div>
        @if ($recentProducts->isEmpty())
          <p class="text-muted" style="font-size:13px;">No products added yet.</p>
        @else
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:13px;">
              <thead>
                <tr style="border-bottom:2px solid #f0f0f0;">
                  <th class="text-muted fw-semibold border-0" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Product</th>
                  <th class="text-muted fw-semibold border-0" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Category</th>
                  <th class="text-muted fw-semibold border-0" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Price</th>
                  <th class="text-muted fw-semibold border-0" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Stock</th>
                  <th class="border-0"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($recentProducts as $product)
                  <tr style="border-bottom:1px solid #f7f7f7;">
                    <td class="border-0">
                      <div class="d-flex align-items-center gap-2">
                        @if ($product->image)
                          <img src="{{ asset('uploads/products/' . $product->image) }}"
                               style="width:36px;height:36px;object-fit:cover;border-radius:4px;"
                               alt="{{ $product->product_name }}">
                        @else
                          <div style="width:36px;height:36px;background:#f0f0f0;border-radius:4px;display:flex;align-items:center;justify-content:center;">
                            <i class="mdi mdi-image text-muted"></i>
                          </div>
                        @endif
                        <span class="fw-semibold">{{ $product->product_name }}</span>
                      </div>
                    </td>
                    <td class="border-0 text-muted">{{ $product->category->name ?? '—' }}</td>
                    <td class="border-0 fw-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="border-0">
                      @if ($product->quantity > 0)
                        <span class="badge bg-success bg-opacity-10 text-success">{{ $product->quantity }}</span>
                      @else
                        <span class="badge bg-danger bg-opacity-10 text-danger">Out of Stock</span>
                      @endif
                    </td>
                    <td class="border-0 text-end">
                      <a href="{{ url('admin/products/' . $product->id . '/edit') }}"
                         class="btn btn-outline-dark btn-sm" style="font-size:11px;padding:3px 10px;">
                        Edit
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>

</div>

@endsection
