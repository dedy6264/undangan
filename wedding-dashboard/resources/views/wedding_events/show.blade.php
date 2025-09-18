@extends('layouts.admin-master')

@section('title', 'View Wedding Event')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Wedding Event</h1>
    <div>
        <a href="{{ route('wedding-events.edit', $weddingEvent) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-edit fa-sm text-white-50"></i> Edit
        </a>
        <a href="{{ route('wedding-events.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Wedding Events
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Wedding Event Details</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID</th>
                            <td>{{ $weddingEvent->id }}</td>
                        </tr>
                        <tr>
                            <th>Couple</th>
                            <td>{{ $weddingEvent->couple->groom_name }} & {{ $weddingEvent->couple->bride_name }}</td>
                        </tr>
                        <tr>
                            <th>Event Name</th>
                            <td>{{ $weddingEvent->event_name }}</td>
                        </tr>
                        <tr>
                            <th>Event Date</th>
                            <td>{{ $weddingEvent->event_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Event Time</th>
                            <td>{{ $weddingEvent->event_time ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>End Time</th>
                            <td>{{ $weddingEvent->end_time ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $weddingEvent->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $weddingEvent->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
                
                <h5 class="mt-4">Location</h5>
                @if($weddingEvent->location)
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th>Venue Name</th>
                            <td>{{ $weddingEvent->location->venue_name }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $weddingEvent->location->address }}</td>
                        </tr>
                        <tr>
                            <th>
                                <a href="{{ route('locations.edit', $weddingEvent->location) }}" class="btn btn-sm btn-warning">Edit Location</a>
                            </th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                @else
                <p>No location information found for this event.</p>
                <a href="{{ route('locations.create') }}?wedding_event_id={{ $weddingEvent->id }}" class="btn btn-primary">Add Location</a>
                @endif
                
                <h5 class="mt-4">Gallery Images</h5>
                @if($weddingEvent->galleryImages->count() > 0)
                <div class="row">
                    @foreach($weddingEvent->galleryImages as $image)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="{{ $image->image_url }}" class="card-img-top" alt="{{ $image->description }}" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text">{{ $image->description }}</p>
                                <a href="{{ route('gallery-images.edit', $image) }}" class="btn btn-sm btn-warning">Edit</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p>No gallery images found for this event.</p>
                @endif
                <a href="{{ route('gallery-images.create') }}?wedding_event_id={{ $weddingEvent->id }}" class="btn btn-primary">Add Gallery Image</a>
            </div>
        </div>
    </div>
</div>
@endsection