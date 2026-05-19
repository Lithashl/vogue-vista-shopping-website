@extends('layouts.app')

@section('title', 'All Categories')

@section('content')

<div class="py-5">
  <div class="container">

    <div class="mb-4">
      <p class="mb-0 mt-2" style="font-size:22px;font-weight:800;color:#1a1a1a;font-family:'Playfair Display',serif;">
        All Categories
      </p>
      <div class="section-divider mb-0"></div>
      
    </div>

    <div class="row g-3">

      @forelse ($categories as $categoryItem)
        <div class="col-6 col-md-3">
          <div class="category-card">
            <a href="{{ url('collections/' . $categoryItem->id) }}">
              <div class="category-card-img">
                <img src="{{ asset('uploads/category/' . $categoryItem->image) }}"
                     alt="{{ $categoryItem->name }}">
              </div>
              <div class="category-card-body">
                <h5>{{ $categoryItem->name }}</h5>
              </div>
            </a>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="empty-state">
            <i class="fa fa-folder-open-o"></i>
            <h5>No Categories Yet</h5>
            <p>Categories will appear here once they are added.</p>
          </div>
        </div>
      @endforelse

    </div>
  </div>
</div>

@endsection
