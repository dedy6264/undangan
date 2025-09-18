@extends('layouts.admin')

@section('title', $title ?? 'Timeline Events')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Timeline Events' }}</h1>
    <a href="{{ route('timeline-events.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Timeline Event
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Timeline Events' }} List</h6>
            </div>
            <div class="card-body">
                @if ($timelineEvents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Couple</th>
                                    <th>Title</th>
                                    <th>Event Date</th>
                                    <th>Description</th>
                                    <th>Sort Order</th>
                                    <th>Is Inverted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timelineEvents as $timelineEvent)
                                    <tr>
                                        <td>{{ $timelineEvent->couple->groom_name }} & {{ $timelineEvent->couple->bride_name }}</td>
                                        <td>{{ $timelineEvent->title ?? 'N/A' }}</td>
                                        <td>{{ $timelineEvent->event_date ? $timelineEvent->event_date->format('d M Y') : 'N/A' }}</td>
                                        <td>{{ Str::limit($timelineEvent->description, 50) }}</td>
                                        <td>{{ $timelineEvent->sort_order }}</td>
                                        <td>
                                            @if($timelineEvent->is_inverted)
                                                <span class="badge badge-primary">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('timeline-events.show', $timelineEvent) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('timeline-events.edit', $timelineEvent) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('timeline-events.destroy', $timelineEvent) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this timeline event?');">
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
                            {{ $timelineEvents->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center">No timeline events found.</p>
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