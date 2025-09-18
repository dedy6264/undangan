@extends('layouts.admin')

@section('title', $title ?? 'Edit Timeline Event')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Edit Timeline Event' }}</h1>
    <a href="{{ route('timeline-events.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Timeline Events
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Edit Timeline Event' }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $updateRoute ?? route('timeline-events.update', $record->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="couple_id" class="form-label">Couple <span class="text-danger">*</span></label>
                        <select name="couple_id" id="couple_id" class="form-control" required>
                            <option value="">Select Couple</option>
                            @forelse($couples as $couple)
                                <option value="{{ $couple->id }}" {{ (old('couple_id', $record->couple_id) == $couple->id) ? 'selected' : '' }}>
                                    {{ $couple->groom_name }} & {{ $couple->bride_name }} - {{ $couple->wedding_date->format('d M Y') }}
                                </option>
                            @empty
                                <option value="" disabled>No couples available. Please <a href="{{ route('couples.create') }}">create a couple</a> first.</option>
                            @endforelse
                        </select>
                        @error('couple_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $record->title) }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="event_date" class="form-label">Event Date</label>
                        <input type="date" name="event_date" id="event_date" class="form-control" value="{{ old('event_date', $record->event_date ? $record->event_date->format('Y-m-d') : '') }}">
                        @error('event_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $record->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="text" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', $record->image_url) }}">
                        @error('image_url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $record->sort_order) }}" min="0">
                        @error('sort_order')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="is_inverted" class="form-label">Is Inverted</label>
                        <select name="is_inverted" id="is_inverted" class="form-control">
                            <option value="0" {{ old('is_inverted', $record->is_inverted) ? '' : 'selected' }}>No</option>
                            <option value="1" {{ old('is_inverted', $record->is_inverted) ? 'selected' : '' }}>Yes</option>
                        </select>
                        @error('is_inverted')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Timeline Event
                    </button>
                    <a href="{{ route('timeline-events.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection