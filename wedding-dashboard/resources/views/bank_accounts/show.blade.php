@extends('layouts.admin')

@section('title', $title ?? 'View Bank Account')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title ?? 'View Bank Account' }}</h1>
    <div>
        <a href="{{ route('bank-accounts.edit', $bankAccount) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-edit fa-sm text-white-50"></i> Edit
        </a>
        <a href="{{ route('bank-accounts.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Bank Accounts
        </a>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title ?? 'Bank Account Details' }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID</th>
                            <td>{{ $bankAccount->id }}</td>
                        </tr>
                        <tr>
                            <th>Wedding Event</th>
                            <td>{{ $bankAccount->weddingEvent->event_name }} - {{ $bankAccount->weddingEvent->couple->groom_name }} & {{ $bankAccount->weddingEvent->couple->bride_name }}</td>
                        </tr>
                        <tr>
                            <th>Bank Name</th>
                            <td>{{ $bankAccount->bank_name }}</td>
                        </tr>
                        <tr>
                            <th>Account Number</th>
                            <td>{{ $bankAccount->account_number }}</td>
                        </tr>
                        <tr>
                            <th>Account Holder Name</th>
                            <td>{{ $bankAccount->account_holder_name }}</td>
                        </tr>
                        <tr>
                            <th>Is Active</th>
                            <td>
                                @if($bankAccount->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $bankAccount->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $bankAccount->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection