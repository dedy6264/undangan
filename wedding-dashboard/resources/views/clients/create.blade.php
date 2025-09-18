@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Create Client</h1>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back to Clients</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="client_name" class="form-label">Client Name *</label>
                        <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Client</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection