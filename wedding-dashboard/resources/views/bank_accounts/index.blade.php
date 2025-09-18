@extends('layouts.admin')

@section('title', $title ?? 'Bank Accounts')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'Bank Accounts' }}</h1>
    <a href="{{ route('bank-accounts.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Bank Account
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Bank Accounts' }} List</h6>
            </div>
            <div class="card-body">
                @if ($bankAccounts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Wedding Event</th>
                                    <th>Bank Name</th>
                                    <th>Account Number</th>
                                    <th>Account Holder</th>
                                    <th>Is Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankAccounts as $bankAccount)
                                    <tr>
                                        <td>{{ $bankAccount->weddingEvent->event_name }} - {{ $bankAccount->weddingEvent->couple->groom_name }} & {{ $bankAccount->weddingEvent->couple->bride_name }}</td>
                                        <td>{{ $bankAccount->bank_name }}</td>
                                        <td>{{ $bankAccount->account_number }}</td>
                                        <td>{{ $bankAccount->account_holder_name }}</td>
                                        <td>
                                            @if($bankAccount->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('bank-accounts.show', $bankAccount) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('bank-accounts.edit', $bankAccount) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('bank-accounts.destroy', $bankAccount) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this bank account?');">
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
                            {{ $bankAccounts->links() }}
                        </div>
                    </div>
                @else
                    <p class="text-center">No bank accounts found.</p>
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