@extends('layouts.admin')

@section('title', $title ?? 'Gallery Images')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Gallery Images' }}</h1>
    <a href="{{ route('gallery-images.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Gallery Image
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Gallery Images' }} List</h6>
            </div>
            <div class="card-body">
                @if ($galleryImages->count() > 0)
                    <div class="row">
                        @foreach ($galleryImages as $galleryImage)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="gallery-item" style="height: 200px; overflow: hidden;">
                                        @if($galleryImage->image_url)
                                            <img src="{{ asset($galleryImage->image_url) }}" alt="{{ $galleryImage->description ?? 'Gallery Image' }}" class="card-img-top" style="height: 100%; object-fit: cover; cursor: pointer;" onclick="openModal('{{ asset($galleryImage->image_url) }}')">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                                <span>No image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">{{ Str::limit($galleryImage->description ?? 'No description', 30) }}</h6>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                {{ $galleryImage->weddingEvent->event_name }}<br>
                                                {{ $galleryImage->weddingEvent->couple->groom_name }} & {{ $galleryImage->weddingEvent->couple->bride_name }}
                                            </small>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Sort: {{ $galleryImage->sort_order }}</small>
                                            <div>
                                                <a href="{{ route('gallery-images.show', $galleryImage) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('gallery-images.edit', $galleryImage) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('gallery-images.destroy', $galleryImage) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this gallery image?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        {{ $galleryImages->links() }}
                    </div>
                @else
                    <p class="text-center">No gallery images found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for image gallery -->
<div id="galleryModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Gallery Image" class="img-fluid">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .gallery-item {
        position: relative;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .gallery-item:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .card-img-top {
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .modal-body {
        padding: 0;
    }
    
    #modalImage {
        max-height: 80vh;
        object-fit: contain;
    }
</style>
@endsection

@section('scripts')
<script>
    function openModal(src) {
        document.getElementById('modalImage').src = src;
        $('#galleryModal').modal('show');
    }
</script>
@endsection