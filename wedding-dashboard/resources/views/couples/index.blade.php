@extends('layouts.admin')

@section('title', $title ?? 'Couples')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Couples' }}</h1>
    @if (isset($createRoute))
        <a href="{{ $createRoute }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Couple
        </a>
    @endif
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Couples' }}</h6>
            </div>
            <div class="card-body">
                @if (isset($records) && count($records) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Groom Name</th>
                                    <th>Bride Name</th>
                                    <th>Wedding Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td>{{ $record->client->client_name ?? 'N/A' }}</td>
                                        <td>{{ $record->groom_name ?? 'N/A' }}</td>
                                        <td>{{ $record->bride_name ?? 'N/A' }}</td>
                                        <td>{{ $record->wedding_date ?? 'N/A' }}</td>
                                        <td>
                                            @if (isset($editRoute))
                                                <a href="{{ route($editRoute, $record->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (isset($deleteRoute))
                                                <form action="{{ route($deleteRoute, $record->id) }}" method="POST" 
                                                    style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this couple?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $records->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center">No couples found.</p>
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