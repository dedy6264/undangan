@extends('layouts.admin-master')

@section('title', 'People Management')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">People</h1>
    <a href="{{ route('people.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Person
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">People List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>

                                <th>Person Index</th>
                                <th>Couple</th>
                                <th>Role</th>
                                <th>Full Name</th>
                                <th>Image URL</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($people as $person)
                            <tr>
                                <td>{{ $person->id }}</td>
                                <td>{{ $person->person_index }}</td>
                                <td>{{ $person->couple->groom_name }} & {{ $person->couple->bride_name }}</td>
                                <td>{{ ucfirst($person->role) }}</td>
                                <td>{{ $person->full_name }}</td>
                                <td>{{ $person->image_url }}</td>
                                <td>{{ $person->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('people.show', $person) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('people.edit', $person) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('people.destroy', $person) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No people found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $people->links() }}
            </div>
        </div>
    </div>
</div>
@endsection