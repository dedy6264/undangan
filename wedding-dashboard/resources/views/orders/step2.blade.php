@extends('orders.layout')

@section('title', 'Create Order - Step 2: Client Information')

@section('wizard-content')
<form method="POST" action="{{ route('create-order.process-step2') }}">
    @csrf
    
    <div class="row">
        <div class="col-12">
            <h5>Client Information</h5>
            <p>Please enter the client's information.</p>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_name">Client Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="client_name" name="client_name" 
                           value="{{ old('client_name') }}" required>
                    @if ($errors->has('client_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('client_name') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" 
                           value="{{ old('phone') }}">
                    @if ($errors->has('phone'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="nik">NIK (Identity Number)</label>
                    <input type="text" class="form-control" id="nik" name="nik" 
                           value="{{ old('nik') }}">
                    @if ($errors->has('nik'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('nik') }}
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" 
                           value="{{ old('address') }}">
                    @if ($errors->has('address'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Continue to Couple Information</button>
                <a href="{{ route('create-order.step1') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</form>
@endsection