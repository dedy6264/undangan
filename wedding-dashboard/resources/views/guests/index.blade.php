@extends('layouts.admin')

@section('title', $title ?? 'Guests')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Guests' }}</h1>
    <a href="{{ route('guests.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Guest
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Guests' }} List</h6>
            </div>
            <div class="card-body">
                @if ($guests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Couple</th>
                                    <th>Guest Index</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guests as $guest)
                                    <tr>
                                        <td>{{ $guest->name }}</td>
                                        <td>{{ $guest->email ?? 'N/A' }}</td>
                                        <td>{{ $guest->phone ?? 'N/A' }}</td>
                                        <td>{{ $guest->couple ? $guest->couple->groom_name . ' & ' . $guest->couple->bride_name : 'N/A' }}</td>
                                        <td>{{ $guest->guest_index ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('guests.show', $guest) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('guests.edit', $guest) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('guests.destroy', $guest) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this guest?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $guests->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center">No guests found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection

@section('styles')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection