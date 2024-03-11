@extends('layouts.admin')

@section('admin_page_name')
    Modifica Ristorante
@endsection

@section('content')
    <div class="container mt-4">

        <div class="row justify-content-center">
            <div class="col-md-10">
                {{-- Back Button --}}
                <a href="{{ route('admin.dashboard') }}" class="btn ms_btn-dark mb-4">Indietro</a>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Modifica Il Tuo Ristorante</h2>

                    </div>
                    <div class="card-body p-4">
                        <small class="text-danger">I campi contrassegnati con un asterisco (*) sono obbligatori.</small>
                        {{-- Create Form --}}
                        <form class="mt-3"
                            action="{{ route('admin.restaurants.update', ['restaurant' => $restaurant->slug]) }}"
                            method="POST" enctype="multipart/form-data">
                            <button type="submit" disabled style="display:none" aria-hidden="true"></button>
                            @csrf
                            @method('PUT')

                            <div class="mb-3 has-validation">
                                <label for="name" class="form-label fw-bold">Nome <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" placeholder="Inserisci nome" name="name"
                                    value="{{ old('name', $restaurant->name) }}" autocomplete="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 has-validation">
                                <label for="address" class="form-label fw-bold">Indirizzo <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="@error('address') is-invalid @enderror form-control"
                                    id="address" placeholder="Inserisci Indirizzo" name="address"
                                    value="{{ old('address', $restaurant->address) }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 has-validation">
                                <label for="phone" class="form-label fw-bold">Telefono <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="@error('phone') is-invalid @enderror form-control"
                                    id="phone" placeholder="Inserisci Telefono" name="phone"
                                    value="{{ old('phone', $restaurant->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 has-validation">
                                <label for="description" class="form-label fw-bold">Descrizione</label>
                                <textarea class="@error('description') is-invalid @enderror form-control" placeholder="Inserisci Descrizione"
                                    id="description" rows="7" name="description">{{ old('description', $restaurant->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <p class="fw-bold">Tipologia</p>
                                <div class="d-flex flex-wrap gap-2 justify-content-around">
                                    @foreach ($types as $type)
                                        <div class="checkbox-wrapper-10">
                                            <input @checked($errors->any() ? in_array($type->id, old('types', [])) : $restaurant->types->contains($type)) name="types[]" value="{{ $type->id }}"
                                                class="tgl tgl-flip" id="cb5-{{ $type->id }}" type="checkbox" />
                                            <label class="tgl-btn" data-tg-off="{{ $type->name }}"
                                                data-tg-on="{{ $type->name }}" for="cb5-{{ $type->id }}"></label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('types')
                                    <div class="d-block invalid-feedback text-center">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="cover_image"
                                    class="form-label @error('cover_image') is-invalid @enderror fw-bold">Foto</label>
                                <input type="file" class="form-control" id="cover_image" name="cover_image">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <img id="preview-image"
                                    src="{{ old('cover_image', asset('storage/' . $restaurant->cover_image)) }}"
                                    alt="" style="max-width: 250px">
                            </div>

                            <button class="btn ms_btn-yellow" type="submit">Salva</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    @vite(['resources/js/preview.js'])
@endsection
