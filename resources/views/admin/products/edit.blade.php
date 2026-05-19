@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Product
                        <a href="{{ url('admin/products') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                <form action="{{ url('admin/products/'.$product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" />
                                @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Price</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="font-weight:700;font-size:13px;">Rp</span>
                                    <input type="text" id="price_display" class="form-control"
                                           placeholder="0" autocomplete="off"
                                           style="letter-spacing:0.5px;" />
                                    <input type="hidden" name="price" id="price_hidden"
                                           value="{{ old('price', (int) $product->price) }}" />
                                </div>
                                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Quantity</label>
                                <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control" />
                                @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" />
                                <img src="{{ asset('uploads/products/' . $product->image) }}" alt="Product Image" width="60px" height="60px" />
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary float-end">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('script')
<script>
(function () {
    const display = document.getElementById('price_display');
    const hidden  = document.getElementById('price_hidden');

    function fmt(val) {
        val = val.replace(/\D/g, '');
        return val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Pre-fill with existing price on page load
    if (hidden.value) {
        display.value = fmt(hidden.value);
    }

    display.addEventListener('input', function () {
        const raw    = this.value.replace(/\D/g, '');
        this.value   = raw ? fmt(raw) : '';
        hidden.value = raw;
    });
})();
</script>
@endpush

@endsection
