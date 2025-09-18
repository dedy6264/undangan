@extends('layouts.admin')

@section('title', $title ?? 'Create Gallery Image')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Create Gallery Image' }}</h1>
    <a href="{{ route('gallery-images.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Gallery Images
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Create Gallery Image' }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $storeRoute ?? route('gallery-images.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="wedding_event_id" class="form-label">Wedding Event <span class="text-danger">*</span></label>
                        <select name="wedding_event_id" id="wedding_event_id" class="form-control" required>
                            <option value="">Select Wedding Event</option>
                            @forelse($weddingEvents as $weddingEvent)
                                <option value="{{ $weddingEvent->id }}" {{ old('wedding_event_id') == $weddingEvent->id ? 'selected' : '' }}>
                                    {{ $weddingEvent->event_name }} - {{ $weddingEvent->couple->groom_name }} & {{ $weddingEvent->couple->bride_name }}
                                </option>
                            @empty
                                <option value="" disabled>No wedding events available. Please <a href="{{ route('wedding-events.create') }}">create a wedding event</a> first.</option>
                            @endforelse
                        </select>
                        @error('wedding_event_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="images" class="form-label">Images <span class="text-danger">*</span></label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                        <small class="form-text text-muted">Select one or more images (JPG, PNG, GIF) - Max 2MB each</small>
                        @error('images')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="imagePreview" class="mt-2"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Gallery Image
                    </button>
                    <a href="{{ route('gallery-images.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('images').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';
        
        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    img.style.margin = '5px';
                    img.classList.add('img-thumbnail');
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    });
</script>
@endsection