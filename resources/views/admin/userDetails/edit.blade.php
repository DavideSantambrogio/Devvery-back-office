@extends('layouts.admin')

@section('admin_page_name')
    Modifica I Tuoi Dati
@endsection

@section('content')
    <div class="container mt-4">

        <div class="row justify-content-center">
            <div class="col-md-10">
                {{-- Back Button --}}
                <a href="{{ route('admin.dashboard') }}" class="btn ms_btn-dark mb-4">Indietro</a>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Modifica i tuoi dati</h2>

                    </div>
                    <div class="card-body p-4">
                        <small class="text-danger">Tutti i campi sono obbligatori</small>
                        <form class="mt-3" action="{{ route('admin.userDetails.update', ['userDetail' => $userDetail->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            {{-- form to vat_number --}}
                            <div class="mb-3 has-validation">
                                <label for="vat_number" class="form-label">Partita IVA</label>
                                <input type="text" class="form-control @error('vat_number') is-invalid @enderror"
                                    id="vat_number" name="vat_number"
                                    value="{{ old('vat_number', $userDetail->vat_number) }}" required>
                                @error('vat_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- form to phone --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label">Numero di Telefono</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $userDetail->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- form to address --}}
                            <div class="mt-3">
                                <label for="address" class="form-label">Indirizzo</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address', $userDetail->address) }}" required>
                            </div>

                            <button class="btn ms_btn-yellow mt-3" type="submit">Salva</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
