@extends('orders.layout')

@section('title', 'Create Order - Step 5: Wedding Event Information')

@section('wizard-content')
<form method="POST" action="{{ route('create-order.process-step5') }}">
    @csrf
    
    <div class="row">
        <div class="col-12">
            <h5>Wedding Event Information</h5>
            <p>Please enter the wedding event details.</p>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="event_name">Event Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="event_name" name="event_name" 
                           value="{{ old('event_name') }}" required>
                    @if ($errors->has('event_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('event_name') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="event_date">Event Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="event_date" name="event_date" 
                           value="{{ old('event_date') }}" required>
                    @if ($errors->has('event_date'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('event_date') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="event_time">Event Time</label>
                    <input type="time" class="form-control" id="event_time" name="event_time" 
                           value="{{ old('event_time') }}">
                    @if ($errors->has('event_time'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('event_time') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="end_time">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time" 
                           value="{{ old('end_time') }}">
                    @if ($errors->has('end_time'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('end_time') }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Continue to Location Information</button>
                <a href="{{ route('create-order.step4') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</form>
@endsection