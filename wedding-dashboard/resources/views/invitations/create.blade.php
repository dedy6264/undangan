@extends('layouts.admin')

@section('title', $title ?? 'Create Invitation')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Create Invitation' }}</h1>
    <a href="{{ route('invitations.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Invitations
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Create Invitation' }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $storeRoute ?? route('invitations.store') }}">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="guest_id" class="form-label">Guest <span class="text-danger">*</span></label>
                        <select name="guest_id" id="guest_id" class="form-control" required>
                            <option value="">Select Guest</option>
                            @forelse($guests as $guest)
                                <option value="{{ $guest->id }}" {{ old('guest_id') == $guest->id ? 'selected' : '' }}>
                                    {{ $guest->name }} ({{ $guest->email ?? 'No Email' }})
                                </option>
                            @empty
                                <option value="" disabled>No guests available. Please <a href="{{ route('guests.create') }}">create a guest</a> first.</option>
                            @endforelse
                        </select>
                        @error('guest_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
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
                        <label for="invitation_code" class="form-label">Invitation Code <span class="text-danger">*</span></label>
                        <input type="text" name="invitation_code" id="invitation_code" class="form-control" value="{{ old('invitation_code') }}" required>
                        @error('invitation_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="is_attending" class="form-label">Is Attending</label>
                        <select name="is_attending" id="is_attending" class="form-control">
                            <option value="">Not Responded</option>
                            <option value="1" {{ old('is_attending') ? 'selected' : '' }}>Attending</option>
                            <option value="0" {{ old('is_attending') === '0' ? 'selected' : '' }}>Not Attending</option>
                        </select>
                        @error('is_attending')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="responded_at" class="form-label">Responded At</label>
                        <input type="datetime-local" name="responded_at" id="responded_at" class="form-control" value="{{ old('responded_at') }}">
                        @error('responded_at')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Invitation
                    </button>
                    <a href="{{ route('invitations.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection