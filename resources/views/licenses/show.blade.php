@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Lizenzdetails</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Lizenzschlüssel:</th>
                                <td>{{ $license->license_key }}</td>
                            </tr>
                            <tr>
                                <th>Kunde:</th>
                                <td>{{ $license->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Produkt:</th>
                                <td>{{ $license->product_name }}</td>
                            </tr>
                            <tr>
                                <th>Lizenztyp:</th>
                                <td>
                                    <span class="badge bg-{{ $license->license_type == 'subscription' ? 'warning' : 'info' }}">
                                        {{ $license->license_type }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $license->status == 'active' ? 'success' : 'danger' }}">
                                        {{ $license->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Gültig bis:</th>
                                <td>{{ $license->valid_until->format('d.m.Y') }}</td>
                            </tr>
                            <tr>
                                <th>Erstellt am:</th>
                                <td>{{ $license->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Aktualisiert am:</th>
                                <td>{{ $license->updated_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('licenses.edit', $license) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Bearbeiten
                    </a>
                    <a href="{{ route('licenses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Zurück zur Übersicht
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection