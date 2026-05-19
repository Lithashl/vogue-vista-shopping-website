<?php

namespace App\Livewire\Admin\Slider;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $sliderToDelete;

    public function deleteSlider($slider_id)
    {
        $this->sliderToDelete = $slider_id;
    }

    public function destroySlider()
    {
        $slider = Slider::find($this->sliderToDelete);
        if ($slider) {
            $path = 'public/uploads/sliders/' . $slider->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $slider->delete();
            session()->flash('message', 'Slider Deleted');
            $this->dispatchBrowserEvent('close-modal');
        }
    }

    public function render()
    {
        $sliders = Slider::orderBy('id', 'DESC')->paginate(5);
        return view('livewire.admin.slider.index', ['sliders' => $sliders]);
    }
}
