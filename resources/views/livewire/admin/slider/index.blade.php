<div>

  {{-- Delete modal --}}
  <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-body text-center p-4">
          <div style="width:56px;height:56px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i class="mdi mdi-trash-can-outline" style="font-size:28px;color:#c62828;"></i>
          </div>
          <h6 class="fw-bold mb-1">Delete Slider?</h6>
          <p class="text-muted mb-4" style="font-size:13px;">This action cannot be undone.</p>
          <form wire:submit.prevent="destroySlider">
            <div class="d-flex gap-2 justify-content-center">
              <button type="button" class="btn btn-outline-secondary btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger btn-sm px-4">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Flash --}}
  @if (session('message'))
    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert" style="font-size:13px;">
      <i class="mdi mdi-check-circle me-2"></i>{{ session('message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Card --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="d-flex justify-content-between align-items-center px-4 py-3"
           style="border-bottom:1px solid #f0f0f0;">
        <div>
          <h6 class="fw-bold mb-0">Home Sliders</h6>
          <p class="text-muted mb-0" style="font-size:12px;">Manage homepage carousel slides</p>
        </div>
        <a href="{{ url('admin/sliders/create') }}"
           class="btn btn-dark btn-sm d-flex align-items-center gap-1">
          <i class="mdi mdi-plus"></i> Add Slider
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:13px;">
          <thead style="background:#f9f9f9;">
            <tr>
              <th class="px-4 py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">#</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Image</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Title</th>
              <th class="py-3 border-0 text-muted fw-semibold" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Description</th>
              <th class="py-3 pe-4 border-0 text-muted fw-semibold text-end" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sliders as $slider)
              <tr style="border-bottom:1px solid #f7f7f7;">
                <td class="px-4 border-0 text-muted">{{ $slider->id }}</td>
                <td class="border-0">
                  @if ($slider->image)
                    <img src="{{ asset('uploads/sliders/' . $slider->image) }}"
                         style="width:72px;height:44px;object-fit:cover;border-radius:6px;"
                         alt="{{ $slider->title }}">
                  @else
                    <div style="width:72px;height:44px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                      <i class="mdi mdi-image text-muted"></i>
                    </div>
                  @endif
                </td>
                <td class="border-0 fw-semibold">{{ $slider->title }}</td>
                <td class="border-0 text-muted" style="max-width:220px;">
                  <span style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">
                    {{ $slider->description }}
                  </span>
                </td>
                <td class="border-0 pe-4 text-end">
                  <a href="{{ url('admin/sliders/' . $slider->id . '/edit') }}"
                     class="btn btn-outline-dark btn-sm me-1" style="font-size:11px;">
                    <i class="mdi mdi-pencil"></i> Edit
                  </a>
                  <a href="#"
                     wire:click="deleteSlider({{ $slider->id }})"
                     data-bs-toggle="modal" data-bs-target="#deleteModal"
                     class="btn btn-outline-danger btn-sm" style="font-size:11px;">
                    <i class="mdi mdi-trash-can-outline"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if ($sliders->hasPages())
        <div class="px-4 py-3" style="border-top:1px solid #f0f0f0;">
          {{ $sliders->links() }}
        </div>
      @endif

    </div>
  </div>

</div>

@push('script')
<script>
  window.addEventListener('close-modal', () => {
    var modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
    if (modal) modal.hide();
  });
</script>
@endpush
