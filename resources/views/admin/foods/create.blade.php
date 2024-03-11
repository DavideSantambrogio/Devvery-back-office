@extends('layouts.admin')

@section('admin_page_name')
    Crea Piatto
@endsection

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <a href="{{ route('admin.foods.index') }}" class="btn ms_btn-dark mb-4">MENU</a>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Aggiungi un nuovo Piatto:</h2>
                    </div>
                    <div class="card-body p-4">
                        <small class="text-danger">I campi contrassegnati con un asterisco (*) sono obbligatori.</small>
                        <form class="mt-3" action="{{ route('admin.foods.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Form per il nome --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Form per il prezzo --}}
                            <div class="mb-3">
                                <label for="price" class="form-label">Prezzo: <span class="text-danger">*</span></label>
                                <input type="number" min="0.00" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                    value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Form per la descrizione --}}
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrizione:</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="d-md-flex gap-4 justify-content-between">
                                <div class="d-flex justify-content-around flex-md-column">
                                    <div class="checkbox-wrapper-8 mb-3">
                                        <input class="tgl tgl-skewed" id="vegan" type="checkbox" name="vegan"
                                            value="1" />
                                        <label class="tgl-btn" data-tg-off="Vegano" data-tg-on="Vegano"
                                            for="vegan"></label>
                                    </div>

                                    {{-- Form per indicare se è celiaco --}}
                                    <div class="checkbox-wrapper-8 mb-3">
                                        <input class="tgl tgl-skewed" id="celiac" type="checkbox" name="celiac"
                                            value="1" />
                                        <label class="tgl-btn" data-tg-off="Celiaco" data-tg-on="Celiaco"
                                            for="celiac"></label>
                                    </div>
                                </div>

                                <div class="border-end border-2"></div>

                                <div class="mb-3 w-100">
                                    <label for="categories">Categoria <span class="text-danger">*</span></label>
                                    <select required size="3"
                                        class="mt-2 form-select @error('category_id') is-invalid @enderror"
                                        name="category_id" id="categories">
                                        @foreach ($categories as $category)
                                            <option @selected(old('category_id') == $category->id) value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Form per indicare se è vegano --}}
                            <hr>

                            {{-- Form per l'immagine --}}
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Immagine del Piatto:</label>
                                <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                    id="cover_image" name="cover_image">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <img id="preview-image" src="" alt="" style="max-width: 250px">
                            </div>

                            <button class="btn ms_btn-yellow mt-3" type="submit">Salva</button>

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
