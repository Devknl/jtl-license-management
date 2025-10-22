@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lizenzen Übersicht</h1>
    <a href="{{ route('licenses.create') }}" class="btn btn-primary">Neue Lizenz</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Lizenzschlüssel</th>
            <th>Kunde</th>
            <th>Produkt</th>
            <th>Typ</th>
            <th>Gültig bis</th>
            <th>Status</th>
            <th>Aktionen</th>
        </tr>
    </thead>
    <tbody>
        @foreach($licenses as $license)
        <tr>
            <td>{{ $license->license_key }}</td>
            <td>{{ $license->customer_name }}</td>
            <td>{{ $license->product_name }}</td>
            <td>
                <span class="badge bg-{{ $license->license_type == 'subscription' ? 'warning' : 'info' }}">
                    {{ $license->license_type }}
                </span>
            </td>
            <td>{{ $license->valid_until->format('d.m.Y') }}</td>
            <td>
                <span class="badge bg-{{ $license->status == 'active' ? 'success' : 'danger' }}">
                    {{ $license->status }}
                </span>
            </td>
            <td>
                <a href="{{ route('licenses.show', $license) }}" class="btn btn-sm btn-info">Anzeigen</a>
                <a href="{{ route('licenses.edit', $license) }}" class="btn btn-sm btn-warning">Bearbeiten</a>
                <form action="{{ route('licenses.destroy', $license) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Lizenz löschen?')">Löschen</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection