@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product
                        <a href="{{ url('admin/products') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                <form action="{{ url('admin/products') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Category</label>
                                @if($categories->isEmpty())
                                    <div class="alert alert-warning py-2">No categories yet. <a href="{{ url('admin/category/create') }}">Add a category first</a>.</div>
                                @else
                                    <select name="category_id" class="form-control">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" name="product_name" class="form-control" /> 
                                @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Price</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="font-weight:700;font-size:13px;">Rp</span>
                                    <input type="text" id="price_display" class="form-control"
                                           placeholder="0" autocomplete="off"
                                           style="letter-spacing:0.5px;" />
                                    <input type="hidden" name="price" id="price_hidden" value="{{ old('price') }}" />
                                </div>
                                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" />
                                @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" />
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

    // Pre-fill if old() value exists (validation fail)
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
