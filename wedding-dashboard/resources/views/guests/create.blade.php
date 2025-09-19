@extends('layouts.admin')

@section('title', $title ?? 'Create Guest')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Create Guest' }}</h1>
    <a href="{{ route('guests.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Guests
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Create Guest' }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $storeRoute ?? route('guests.store') }}">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="couple_id" class="form-label">Couple <span class="text-danger">*</span></label>
                        <select name="couple_id" id="couple_id" class="form-control" required>
                            <option value="">Select Couple</option>
                            @forelse($couples as $couple)
                                <option value="{{ $couple->id }}" {{ old('couple_id') == $couple->id ? 'selected' : '' }}>
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
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Guest
                    </button>
                    <a href="{{ route('guests.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection