@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
    <div>
        <livewire:frontend.products.view :category="$category" :product="$product"/>
    </div>
@endsection