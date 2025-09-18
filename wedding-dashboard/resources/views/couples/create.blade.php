@extends('layouts.admin')

@section('title', $title ?? 'Create Couple')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Create Couple' }}</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Create Couple' }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $storeRoute ?? '#' }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_id">Client</label>
                            <select class="form-control" id="client_id" name="client_id" required>
                                <option value="">Select a client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->client_name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('client_id'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('client_id') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="groom_name">Groom Name</label>
                            <input type="text" class="form-control" id="groom_name" name="groom_name" 
                                value="{{ old('groom_name') }}" required>
                            @if ($errors->has('groom_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="bride_name">Bride Name</label>
                            <input type="text" class="form-control" id="bride_name" name="bride_name" 
                                value="{{ old('bride_name') }}" required>
                            @if ($errors->has('bride_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="wedding_date">Wedding Date</label>
                            <input type="date" class="form-control" id="wedding_date" name="wedding_date" 
                                value="{{ old('wedding_date') }}" required>
                            @if ($errors->has('wedding_date'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('wedding_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('couples.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection