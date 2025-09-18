@extends('layouts.admin-master')

@section('title', 'Wedding Events')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Wedding Events</h1>
    <a href="{{ route('wedding-events.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Wedding Event
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Wedding Events List</h6>
            </div>
            <div class="card-body">
                @if ($weddingEvents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Couple</th>
                                    <th>Event Name</th>
                                    <th>Event Date</th>
                                    <th>Event Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($weddingEvents as $weddingEvent)
                                    <tr>
                                        <td>{{ $weddingEvent->couple->groom_name }} & {{ $weddingEvent->couple->bride_name }}</td>
                                        <td>{{ $weddingEvent->event_name }}</td>
                                        <td>{{ $weddingEvent->event_date->format('d M Y') }}</td>
                                        <td>{{ $weddingEvent->event_time ?? 'N/A' }}</td>
                                        <td>{{ $weddingEvent->end_time ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('wedding-events.show', $weddingEvent) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('wedding-events.edit', $weddingEvent) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('wedding-events.destroy', $weddingEvent) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this wedding event?');">
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
                            {{ $weddingEvents->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center">No wedding events found.</p>
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