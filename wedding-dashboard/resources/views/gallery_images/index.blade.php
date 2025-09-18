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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Wedding Event</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Sort Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($galleryImages as $galleryImage)
                                    <tr>
                                        <td>{{ $galleryImage->weddingEvent->event_name }} - {{ $galleryImage->weddingEvent->couple->groom_name }} & {{ $galleryImage->weddingEvent->couple->bride_name }}</td>
                                        <td>
                                            @if($galleryImage->thumbnail_url)
                                                <img src="{{ $galleryImage->thumbnail_url }}" alt="Thumbnail" style="max-width: 100px; max-height: 100px;">
                                            @elseif($galleryImage->image_url)
                                                <img src="{{ $galleryImage->image_url }}" alt="Image" style="max-width: 100px; max-height: 100px;">
                                            @else
                                                <span>No image</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($galleryImage->description, 50) }}</td>
                                        <td>{{ $galleryImage->sort_order }}</td>
                                        <td>
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $galleryImages->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center">No gallery images found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection

@section('styles')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection