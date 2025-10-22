@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Lizenz validieren</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('validate.license') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="license_key" class="form-label">Lizenzschlüssel</label>
                        <input type="text" 
                               class="form-control form-control-lg @error('license_key') is-invalid @enderror" 
                               id="license_key" 
                               name="license_key" 
                               value="{{ old('license_key') }}"
                               placeholder="JTL-DEMO-12345"
                               pattern="JTL-[A-Z]+-\d{5}"
                               title="Format: JTL-XXX-12345"
                               required
                               autofocus>
                        @error('license_key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Geben Sie den Lizenzschlüssel im Format <strong>JTL-XXX-12345</strong> ein
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-check-circle me-2"></i> Lizenz validieren
                    </button>
                </form>

                <div class="mt-4">
                    <h6>Beispiel-Lizenzen zum Testen:</h6>
                    <small class="text-muted">
                        @foreach(\App\Models\License::take(3)->get() as $testLicense)
                            <div><strong>{{ $testLicense->license_key }}</strong> - {{ $testLicense->customer_name }}</div>
                        @endforeach
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection