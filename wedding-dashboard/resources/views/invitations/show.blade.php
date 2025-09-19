@extends('layouts.admin')

@section('title', $title ?? 'View Invitation')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'View Invitation' }}</h1>
    <a href="{{ route('invitations.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Invitations
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'View Invitation' }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Guest</th>
                                <td>{{ $invitation->guest->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Wedding Event</th>
                                <td>{{ $invitation->weddingEvent->event_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Invitation Code</th>
                                <td>{{ $invitation->invitation_code }}</td>
                            </tr>
                            <tr>
                                <th>Is Attending</th>
                                <td>
                                    @if ($invitation->is_attending === null)
                                        <span class="badge badge-secondary">Not Responded</span>
                                    @elseif ($invitation->is_attending)
                                        <span class="badge badge-success">Attending</span>
                                    @else
                                        <span class="badge badge-danger">Not Attending</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Responded At</th>
                                <td>{{ $invitation->responded_at ? $invitation->responded_at->format('d M Y, H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $invitation->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $invitation->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <a href="{{ route('invitations.edit', $invitation) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Invitation
                </a>
                <a href="{{ route('invitations.index') }}" class="btn btn-secondary">Back to List</a>
                
                <form action="{{ route('invitations.destroy', $invitation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this invitation?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Invitation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection