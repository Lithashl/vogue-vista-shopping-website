@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-4">Our Products</h4>
                </div>

                {{-- Pass the category_id to the Livewire component --}}
                @livewire('frontend.products.index', ['category_id' => $category_id])

            </div>
        </div>
    </div>
@endsection
