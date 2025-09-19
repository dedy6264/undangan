@extends('layouts.admin')

@section('title', $title ?? 'View Guest')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'View Guest' }}</h1>
    <a href="{{ route('guests.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Guests
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'View Guest' }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Name</th>
                                <td>{{ $guest->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $guest->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $guest->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Couple</th>
                                <td>{{ $guest->couple ? $guest->couple->groom_name . ' & ' . $guest->couple->bride_name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Guest Index</th>
                                <td>{{ $guest->guest_index ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $guest->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $guest->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <a href="{{ route('guests.edit', $guest) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Guest
                </a>
                <a href="{{ route('guests.index') }}" class="btn btn-secondary">Back to List</a>
                
                <form action="{{ route('guests.destroy', $guest) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this guest?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Guest
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection