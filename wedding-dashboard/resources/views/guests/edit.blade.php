@extends('layouts.admin')

@section('title', $title ?? 'Edit Guest')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Edit Guest' }}</h1>
    <a href="{{ route('guests.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Guests
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Edit Guest' }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $updateRoute ?? route('guests.update', $record->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="couple_id" class="form-label">Couple <span class="text-danger">*</span></label>
                        <select name="couple_id" id="couple_id" class="form-control" required>
                            <option value="">Select Couple</option>
                            @forelse($couples as $couple)
                                <option value="{{ $couple->id }}" {{ (old('couple_id', $record->couple_id) == $couple->id) ? 'selected' : '' }}>
                                    {{ $couple->groom_name }} & {{ $couple->bride_name }}
                                </option>
                            @empty
                                <option value="" disabled>No couples available.</option>
                            @endforelse
                        </select>
                        @error('couple_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $record->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $record->email) }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $record->phone) }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="guest_index" class="form-label">Guest Index</label>
                        <input type="text" name="guest_index" id="guest_index" class="form-control" value="{{ old('guest_index', $record->guest_index) }}" readonly>
                        @error('guest_index')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Guest
                    </button>
                    <a href="{{ route('guests.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection