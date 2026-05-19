@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Slider
                        <a href="{{ route('admin.slider.index') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Title</label>
                                <input type="text" name="title" value="{{ $slider->title }}" class="form-control" />
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $slider->description }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>     
                            <div class="col-md-6 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" />
                                <img src="{{ asset('uploads/sliders/' . $slider->image) }}" alt="Slider Image" width="60px" height="60px" />
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
@endsection
