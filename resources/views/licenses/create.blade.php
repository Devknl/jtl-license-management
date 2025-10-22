@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Neue Lizenz erstellen</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('licenses.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="license_key" class="form-label">Lizenzschlüssel *</label>
                        <input type="text" 
                               class="form-control @error('license_key') is-invalid @enderror" 
                               id="license_key" 
                               name="license_key" 
                               value="{{ old('license_key') }}"
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
                               value="{{ old('customer_name') }}"
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
                               value="{{ old('product_name') }}"
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
                            <option value="perpetual" {{ old('license_type') == 'perpetual' ? 'selected' : '' }}>Perpetual</option>
                            <option value="subscription" {{ old('license_type') == 'subscription' ? 'selected' : '' }}>Subscription</option>
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
                               value="{{ old('valid_until') }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        @error('valid_until')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Lizenz erstellen
                        </button>
                        <a href="{{ route('licenses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Abbrechen
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection