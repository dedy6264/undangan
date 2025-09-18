@extends('layouts.admin')

@section('title', $title ?? 'View Gallery Image')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'View Gallery Image' }}</h1>
    <div>
        <a href="{{ route('gallery-images.edit', $galleryImage) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-edit fa-sm text-white-50"></i> Edit
        </a>
        <a href="{{ route('gallery-images.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Gallery Images
        </a>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Gallery Image Details' }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $galleryImage->id }}</td>
                                </tr>
                                <tr>
                                    <th>Wedding Event</th>
                                    <td>{{ $galleryImage->weddingEvent->event_name }} - {{ $galleryImage->weddingEvent->couple->groom_name }} & {{ $galleryImage->weddingEvent->couple->bride_name }}</td>
                                </tr>
                                <tr>
                                    <th>Image URL</th>
                                    <td>{{ $galleryImage->image_url }}</td>
                                </tr>
                                <tr>
                                    <th>Thumbnail URL</th>
                                    <td>{{ $galleryImage->thumbnail_url ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $galleryImage->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $galleryImage->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $galleryImage->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $galleryImage->updated_at->format('d M Y, H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Image Preview</h5>
                        @if($galleryImage->image_url)
                            <img src="{{ $galleryImage->image_url }}" alt="Gallery Image" class="img-fluid">
                        @else
                            <p>No image available</p>
                        @endif
                        
                        @if($galleryImage->thumbnail_url)
                            <h5 class="mt-3">Thumbnail Preview</h5>
                            <img src="{{ $galleryImage->thumbnail_url }}" alt="Thumbnail" class="img-fluid" style="max-width: 200px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection