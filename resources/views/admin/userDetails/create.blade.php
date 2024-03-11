@extends('layouts.admin')

@section('admin_page_name')
    Dettagli Utente
@endsection

@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.dashboard') }}" class="btn ms_btn-dark mb-4">Indietro</a>
        <div class="card">
            <div class="card-header">
                <h2>Aggiungi i tuoi dati personali</h2>
            </div>
            <div class="card-body p-4">
                <small class="text-danger">Tutti i campi sono obbligatori</small>
                <form class="mt-3" action="{{ route('admin.userDetails.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- form to vat-number --}}
                    <div class="mb-3 has-validation">
                        <label for="vat_number" class="form-label">Partita IVA</label>
                        <input type="text" class="form-control @error('vat_number') is-invalid @enderror" id="vat_number"
                            name="vat_number" value="{{ old('vat_number') }}" required>
                        @error('vat_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- form to phone --}}
                    <div class="mb-3">
                        <label for="phone" class="form-label">Numero di Telefono</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- form to address --}}
                    <div class="mb-3">
                        <label for="address" class="form-label">Indirizzo</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="address" name="address"
                            value="{{ old('address') }}" required>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn ms_btn-yellow" type='submit'>Salva</button>
                </form>
            </div>
        </div>
    </div>
@endsection
