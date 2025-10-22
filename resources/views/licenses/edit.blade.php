@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Lizenz bearbeiten</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('licenses.update', $license) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="license_key" class="form-label">Lizenzschlüssel *</label>
                        <input type="text" 
                               class="form-control @error('license_key') is-invalid @enderror" 
                               id="license_key" 
                               name="license_key" 
                               value="{{ old('license_key', $license->license_key) }}"
                               placeholder="JTL-DEMO-12345"
                               pattern="JTL-[A-Z]+-\d{5}"
                               title="Format: JTL-XXX-12345 (z.B. JTL-DEMO-12345)"
                               required>
                        @error('license_key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Format: JTL-XXX-12345 (Großbuchstaben, 5 Ziffern) - Beispiel: JTL-DEMO-12345
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Kundenname *</label>
                        <input type="text" 
                               class="form-control @error('customer_name') is-invalid @enderror" 
                               id="customer_name" 
                               name="customer_name" 
                               value="{{ old('customer_name', $license->customer_name) }}"
                               maxlength="100"
                               required>
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Produktname *</label>
                        <input type="text" 
                               class="form-control @error('product_name') is-invalid @enderror" 
                               id="product_name" 
                               name="product_name" 
                               value="{{ old('product_name', $license->product_name) }}"
                               maxlength="50"
                               required>
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="license_type" class="form-label">Lizenztyp *</label>
                        <select class="form-control @error('license_type') is-invalid @enderror" 
                                id="license_type" 
                                name="license_type" 
                                required>
                            <option value="">Bitte auswählen</option>
                            <option value="perpetual" {{ old('license_type', $license->license_type) == 'perpetual' ? 'selected' : '' }}>Perpetual</option>
                            <option value="subscription" {{ old('license_type', $license->license_type) == 'subscription' ? 'selected' : '' }}>Subscription</option>
                        </select>
                        @error('license_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="valid_until" class="form-label">Gültig bis *</label>
                        <input type="date" 
                               class="form-control @error('valid_until') is-invalid @enderror" 
                               id="valid_until" 
                               name="valid_until" 
                               value="{{ old('valid_until', $license->valid_until->format('Y-m-d')) }}"
                               required>
                        @error('valid_until')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-control @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="active" {{ old('status', $license->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ old('status', $license->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="suspended" {{ old('status', $license->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Änderungen speichern
                        </button>
                        <a href="{{ route('licenses.show', $license) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Abbrechen
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection