@extends('layouts.app')

@section('title', $query ? 'Search: ' . $query : 'Search')

@section('content')

<div class="py-5">
  <div class="container">

    {{-- Header --}}
    <div class="mb-5">
      <p class="section-title mb-1">Discover</p>
      <div class="section-divider mb-0"></div>
      <p class="mb-0 mt-2" style="font-size:22px;font-weight:800;color:#1a1a1a;font-family:'Playfair Display',serif;">
        @if ($query) Search Results @else Search @endif
      </p>
      @if ($query)
        <p style="font-size:13px;color:#6b7280;margin-top:6px;">
          {{ $products->total() }} result(s) for &ldquo;{{ $query }}&rdquo;
        </p>
      @endif
    </div>

    {{-- Search bar --}}
    <form action="{{ route('search') }}" method="GET" class="mb-5">
      <div class="d-flex" style="border:1.5px solid #1a1a1a;max-width:560px;">
        <input type="search" name="q" value="{{ $query }}"
               placeholder="Search products…"
               style="flex:1;border:0;outline:none;padding:12px 16px;font-size:14px;background:transparent;">
        <button type="submit"
                style="background:#1a1a1a;color:#fff;border:0;padding:0 20px;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;">
          Search
        </button>
      </div>
    </form>

    @if (!$query)
      <div style="border:1.5px solid #e8e8e8;padding:60px;text-align:center;">
        <i class="fa fa-search fa-2x d-block mb-3" style="color:#e8e8e8;"></i>
        <p style="font-size:14px;color:#6b7280;">Type something above to search for products.</p>
      </div>

    @elseif ($products->isEmpty())
      <div style="border:1.5px solid #e8e8e8;padding:60px;text-align:center;">
        <i class="fa fa-inbox fa-2x d-block mb-3" style="color:#e8e8e8;"></i>
        <p style="font-size:14px;color:#6b7280;margin-bottom:16px;">
          No products found for &ldquo;{{ $query }}&rdquo;.
        </p>
        <a href="/collections" class="btn-checkout d-inline-block" style="width:auto;padding:10px 28px;font-size:11px;">
          Browse All Products
        </a>
      </div>

    @else
      <div class="row g-3">
        @foreach ($products as $product)
          @php $category = $product->category; @endphp
          <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ url('collections/' . $product->category_id . '/' . $product->id) }}"
               style="text-decoration:none;color:inherit;">
              <div class="product-card" style="border:1.5px solid #e8e8e8;transition:border-color 0.2s;"
                   onmouseover="this.style.borderColor='#1a1a1a'" onmouseout="this.style.borderColor='#e8e8e8'">

                {{-- Image --}}
                <div style="position:relative;overflow:hidden;background:#f7f7f7;">
                  @if ($product->image)
                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                         style="width:100%;aspect-ratio:3/4;object-fit:cover;display:block;"
                         alt="{{ $product->product_name }}">
                  @else
                    <div style="width:100%;aspect-ratio:3/4;display:flex;align-items:center;justify-content:center;">
                      <i class="fa fa-image fa-2x" style="color:#ccc;"></i>
                    </div>
                  @endif

                  @if ($product->quantity < 1)
                    <div style="position:absolute;top:8px;left:8px;background:#1a1a1a;color:#fff;font-size:10px;font-weight:800;letter-spacing:1px;padding:3px 8px;text-transform:uppercase;">
                      Sold Out
                    </div>
                  @endif
                </div>

                {{-- Info --}}
                <div style="padding:12px;">
                  @if ($category)
                    <p style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#9ca3af;margin-bottom:4px;">
                      {{ $category->name }}
                    </p>
                  @endif
                  <p style="font-size:14px;font-weight:700;color:#1a1a1a;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $product->product_name }}
                  </p>
                  <p style="font-size:14px;font-weight:800;color:#1a1a1a;margin-bottom:0;">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                  </p>
                </div>

              </div>
            </a>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if ($products->hasPages())
        <div class="mt-5">
          {{ $products->links() }}
        </div>
      @endif
    @endif

  </div>
</div>

@endsection
