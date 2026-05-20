<div>

  {{-- Page title --}}
  <div class="page-title-bar">
    <div class="container">
      <h2>{{ $category->name ?? 'Products' }}</h2>
      <p class="breadcrumb mb-0">
        <a href="/" class="text-dark">Home</a> &nbsp;/&nbsp;
        <a href="/collections" class="text-dark">Collections</a> &nbsp;/&nbsp;
        {{ $category->name ?? '' }}
      </p>
    </div>
  </div>

  <div class="py-5">
    <div class="container">
      <div class="row g-4">

        {{-- ── Filter sidebar ── --}}
        <div class="col-md-3 col-lg-2">

          {{-- Mobile toggle button --}}
          <button class="filter-toggle-btn btn w-100 mb-2 d-flex d-md-none align-items-center justify-content-between"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#filterCollapse"
                  aria-expanded="false"
                  aria-controls="filterCollapse">
            <span>Filter &amp; Sort</span>
            <i class="fa fa-sliders"></i>
          </button>

          <div class="collapse d-md-block" id="filterCollapse">
            <div class="filter-card">
              <p class="filter-title">Sort by Price</p>
              <label class="d-flex align-items-center gap-2 mb-2">
                <input type="radio" name="priceSort" wire:model.live="priceInput" value="low-to-high">
                <span>Low to High</span>
              </label>
              <label class="d-flex align-items-center gap-2">
                <input type="radio" name="priceSort" wire:model.live="priceInput" value="high-to-low">
                <span>High to Low</span>
              </label>
            </div>
          </div>

        </div>

        {{-- ── Product grid ── --}}
        <div class="col-md-9 col-lg-10">
          <div class="row g-3">

            @forelse ($products as $productItem)
              <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                  <a href="{{ url('/collections/' . $category->id . '/' . $productItem->id) }}">
                    <div class="product-card-img">
                      @if ($productItem->quantity > 0)
                        <span class="stock bg-success">In Stock</span>
                      @else
                        <span class="stock bg-danger">Out of Stock</span>
                      @endif
                      <img src="{{ $productItem->image_url }}" alt="{{ $productItem->product_name }}">
                    </div>
                  </a>
                  <div class="product-card-body">
                    <div class="product-name">
                      <a href="{{ url('/collections/' . $category->id . '/' . $productItem->id) }}">
                        {{ $productItem->product_name }}
                      </a>
                    </div>
                    <div>
                      <span class="selling-price">Rp{{ number_format($productItem->price, 0, ',', '.') }}</span>
                    </div>
                    <div>
                      <a href="{{ url('/collections/' . $category->id . '/' . $productItem->id) }}"
                         class="btn btn1 mt-2">View Product</a>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="empty-state">
                  <i class="fa fa-tag"></i>
                  <h5>No Products Found</h5>
                  <p>
                    @isset($category)
                      No products available in <strong>{{ $category->name }}</strong> yet.
                    @else
                      No products available yet.
                    @endisset
                  </p>
                </div>
              </div>
            @endforelse

          </div>
        </div>

      </div>
    </div>
  </div>

</div>
