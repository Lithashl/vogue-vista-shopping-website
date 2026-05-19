<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SliderFormRequest;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(SliderFormRequest $request)
    {
        $validatedData = $request->validated();

        $slider = new Slider();
        $slider->title = $validatedData['title'];
        $slider->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/sliders'), $imageName);
            $slider->image = $imageName;
        }

        $slider->save();

        return redirect()->route('admin.slider.index')->with('success', 'Slider created successfully');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(SliderFormRequest $request, $id)
    {
        $validatedData = $request->validated();

        $slider = Slider::findOrFail($id);
        $slider->title = $validatedData['title'];
        $slider->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $imagePath = public_path('uploads/sliders/' . $slider->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/sliders'), $imageName);
            $slider->image = $imageName;
        }

        $slider->save();

        return redirect()->route('admin.slider.index')->with('success', 'Slider updated successfully');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $imagePath = public_path('uploads/sliders/' . $slider->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Slider deleted successfully');
    }
}
