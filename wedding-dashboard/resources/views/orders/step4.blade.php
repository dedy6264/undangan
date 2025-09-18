@extends('orders.layout')

@section('title', 'Create Order - Step 4: People Information')

@section('wizard-content')
<form method="POST" action="{{ route('create-order.process-step4') }}">
    @csrf
    
    <div class="row">
        <div class="col-12">
            <h5>People Information</h5>
            <p>Please enter information for both the groom and bride.</p>
            
            <!-- Groom Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Groom Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="groom_full_name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="groom_full_name" name="groom_full_name" 
                                   value="{{ old('groom_full_name') }}" required>
                            @if ($errors->has('groom_full_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_full_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="groom_image_url">Image URL</label>
                            <input type="text" class="form-control" id="groom_image_url" name="groom_image_url" 
                                   value="{{ old('groom_image_url') }}">
                            @if ($errors->has('groom_image_url'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_image_url') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="groom_additional_info">Additional Info</label>
                            <textarea class="form-control" id="groom_additional_info" name="groom_additional_info" 
                                      rows="3">{{ old('groom_additional_info') }}</textarea>
                            @if ($errors->has('groom_additional_info'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_additional_info') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="groom_father_name">Father's Name</label>
                            <input type="text" class="form-control" id="groom_father_name" name="groom_father_name" 
                                   value="{{ old('groom_father_name') }}">
                            @if ($errors->has('groom_father_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_father_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="groom_father_status">Father's Status</label>
                            <select class="form-control" id="groom_father_status" name="groom_father_status">
                                <option value="alive" {{ old('groom_father_status') == 'alive' ? 'selected' : '' }}>Alive</option>
                                <option value="deceased" {{ old('groom_father_status') == 'deceased' ? 'selected' : '' }}>Deceased</option>
                            </select>
                            @if ($errors->has('groom_father_status'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_father_status') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="groom_mother_name">Mother's Name</label>
                            <input type="text" class="form-control" id="groom_mother_name" name="groom_mother_name" 
                                   value="{{ old('groom_mother_name') }}">
                            @if ($errors->has('groom_mother_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_mother_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="groom_mother_status">Mother's Status</label>
                            <select class="form-control" id="groom_mother_status" name="groom_mother_status">
                                <option value="alive" {{ old('groom_mother_status') == 'alive' ? 'selected' : '' }}>Alive</option>
                                <option value="deceased" {{ old('groom_mother_status') == 'deceased' ? 'selected' : '' }}>Deceased</option>
                            </select>
                            @if ($errors->has('groom_mother_status'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('groom_mother_status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bride Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Bride Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bride_full_name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bride_full_name" name="bride_full_name" 
                                   value="{{ old('bride_full_name') }}" required>
                            @if ($errors->has('bride_full_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_full_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="bride_image_url">Image URL</label>
                            <input type="text" class="form-control" id="bride_image_url" name="bride_image_url" 
                                   value="{{ old('bride_image_url') }}">
                            @if ($errors->has('bride_image_url'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_image_url') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="bride_additional_info">Additional Info</label>
                            <textarea class="form-control" id="bride_additional_info" name="bride_additional_info" 
                                      rows="3">{{ old('bride_additional_info') }}</textarea>
                            @if ($errors->has('bride_additional_info'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_additional_info') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="bride_father_name">Father's Name</label>
                            <input type="text" class="form-control" id="bride_father_name" name="bride_father_name" 
                                   value="{{ old('bride_father_name') }}">
                            @if ($errors->has('bride_father_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_father_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="bride_father_status">Father's Status</label>
                            <select class="form-control" id="bride_father_status" name="bride_father_status">
                                <option value="alive" {{ old('bride_father_status') == 'alive' ? 'selected' : '' }}>Alive</option>
                                <option value="deceased" {{ old('bride_father_status') == 'deceased' ? 'selected' : '' }}>Deceased</option>
                            </select>
                            @if ($errors->has('bride_father_status'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_father_status') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="bride_mother_name">Mother's Name</label>
                            <input type="text" class="form-control" id="bride_mother_name" name="bride_mother_name" 
                                   value="{{ old('bride_mother_name') }}">
                            @if ($errors->has('bride_mother_name'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_mother_name') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="bride_mother_status">Mother's Status</label>
                            <select class="form-control" id="bride_mother_status" name="bride_mother_status">
                                <option value="alive" {{ old('bride_mother_status') == 'alive' ? 'selected' : '' }}>Alive</option>
                                <option value="deceased" {{ old('bride_mother_status') == 'deceased' ? 'selected' : '' }}>Deceased</option>
                            </select>
                            @if ($errors->has('bride_mother_status'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('bride_mother_status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Continue to Wedding Event Information</button>
                <a href="{{ route('create-order.step3') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</form>
@endsection