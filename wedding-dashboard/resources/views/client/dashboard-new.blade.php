
@extends('layouts.admin-master')

@section('title', 'Client Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Client Dashboard</h1>
</div>

<div class="row">
    @if(isset($client))
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your Profile</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $client->client_name }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $client->address ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $client->phone ?? 'Not provided' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="text-right">
                    <a href="#" class="btn btn-primary btn-sm">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your Weddings</h6>
            </div>
            <div class="card-body">
                @if(isset($couples) && $couples->count() > 0)
                    <p>You have {{ $couples->count() }} wedding(s) registered.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Groom</th>
                                    <th>Bride</th>
                                    <th>Wedding Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($couples as $couple)
                                    <tr>
                                        <td>{{ $couple->groom_name }}</td>
                                        <td>{{ $couple->bride_name }}</td>
                                        <td>{{ $couple->wedding_date }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm">View</a>
                                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>You haven't registered any weddings yet.</p>
                    <div class="text-center">
                        <a href="#" class="btn btn-primary">Create Your First Wedding</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-primary btn-block">
                            <i class="fas fa-heart mr-2"></i>Add Couple
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-success btn-block">
                            <i class="fas fa-calendar-alt mr-2"></i>Add Event
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-info btn-block">
                            <i class="fas fa-images mr-2"></i>Manage Gallery
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-warning btn-block">
                            <i class="fas fa-history mr-2"></i>Add Timeline
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-12">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Your client profile is not set up yet. Please contact support.
        </div>
    </div>
    @endif
</div>
@endsection