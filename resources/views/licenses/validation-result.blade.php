@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Validierungsergebnis</h4>
            </div>
            <div class="card-body">
                @if($validationResult['is_valid'])
                    <div class="alert alert-success">
                        <h5><i class="fas fa-check-circle"></i> Lizenz ist gültig!</h5>
                    </div>
                @else
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-triangle"></i> Lizenz ist ungültig!</h5>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h6>Lizenzinformationen:</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Lizenzschlüssel:</th>
                                <td>{{ $validationResult['license']->license_key }}</td>
                            </tr>
                            <tr>
                                <th>Kunde:</th>
                                <td>{{ $validationResult['license']->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Produkt:</th>
                                <td>{{ $validationResult['license']->product_name }}</td>
                            </tr>
                            <tr>
                                <th>Lizenztyp:</th>
                                <td>
                                    <span class="badge bg-{{ $validationResult['license']->license_type == 'subscription' ? 'warning' : 'info' }}">
                                        {{ $validationResult['license']->license_type }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Validierungsdaten:</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $validationResult['license']->status == 'active' ? 'success' : 'danger' }}">
                                        {{ $validationResult['license']->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Gültig bis:</th>
                                <td>{{ $validationResult['license']->valid_until->format('d.m.Y') }}</td>
                            </tr>
                            <tr>
                                <th>Verbleibende Tage:</th>
                                <td>
                                    @if($validationResult['days_remaining'] > 0)
                                        <span class="text-success">{{ $validationResult['days_remaining'] }} Tage</span>
                                    @else
                                        <span class="text-danger">Abgelaufen</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Validierungsdatum:</th>
                                <td>{{ $validationResult['validation_date'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('validate.form') }}" class="btn btn-primary">
                        <i class="fas fa-redo"></i> Weitere Lizenz validieren
                    </a>
                    <a href="{{ route('licenses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Zur Lizenzübersicht
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection