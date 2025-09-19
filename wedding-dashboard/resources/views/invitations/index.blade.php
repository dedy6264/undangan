@extends('layouts.admin')

@section('title', $title ?? 'Invitations')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Invitations' }}</h1>
    <a href="{{ route('invitations.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Invitation
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Invitations' }} List</h6>
            </div>
            <div class="card-body">
                @if ($invitations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Guest</th>
                                    <th>Wedding Event</th>
                                    <th>Invitation Code</th>
                                    <th>Is Attending</th>
                                    <th>Responded At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invitations as $invitation)
                                    <tr>
                                        <td>{{ $invitation->guest->name ?? 'N/A' }}</td>
                                        <td>{{ $invitation->weddingEvent->event_name ?? 'N/A' }}</td>
                                        <td>{{ $invitation->invitation_code }}</td>
                                        <td>
                                            @if ($invitation->is_attending === null)
                                                <span class="badge badge-secondary">Not Responded</span>
                                            @elseif ($invitation->is_attending)
                                                <span class="badge badge-success">Attending</span>
                                            @else
                                                <span class="badge badge-danger">Not Attending</span>
                                            @endif
                                        </td>
                                        <td>{{ $invitation->responded_at ? $invitation->responded_at->format('d M Y, H:i') : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('invitations.show', $invitation) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('invitations.edit', $invitation) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('invitations.destroy', $invitation) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this invitation?');">
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
                            {{ $invitations->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center">No invitations found.</p>
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