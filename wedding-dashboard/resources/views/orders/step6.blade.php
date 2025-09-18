@extends('orders.layout')

@section('title', 'Create Order - Step 6: Location Information')

@section('wizard-content')
<form method="POST" action="{{ route('create-order.process-step6') }}">
    @csrf
    
    <div class="row">
        <div class="col-12">
            <h5>Location Information</h5>
            <p>Please enter the wedding event location details.</p>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="venue_name">Venue Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="venue_name" name="venue_name" 
                           value="{{ old('venue_name') }}" required>
                    @if ($errors->has('venue_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('venue_name') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="address">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    @if ($errors->has('address'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="map_embed_url">Map Embed URL</label>
                    <input type="text" class="form-control" id="map_embed_url" name="map_embed_url" 
                           value="{{ old('map_embed_url') }}">
                    @if ($errors->has('map_embed_url'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('map_embed_url') }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Continue to Payment Method</button>
                <a href="{{ route('create-order.step5') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</form>
@endsection