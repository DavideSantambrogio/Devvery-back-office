@extends('layouts.admin')

@section('admin_page_name')
    {{ $food->name }}
@endsection

@section('content')
    <div class="container mt-3">
        <a href="{{ route('admin.foods.index') }}" class="btn ms_btn-dark mb-5">MENU</a>

        <div class="row">

            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-5 object-fit-cover">
                            @if ($food->cover_image)
                                <img src="{{ asset('storage/' . $food->cover_image) }}" class="w-100 object-fit-cover"
                                    alt="Foto del {{ $food->name }}">
                            @else
                                <img src="{{ Vite::asset('resources\img\noimg.png') }}" class="img-fluid"
                                    alt="Immagine non disponibile">
                            @endif
                            <div class="card-img-overlay">
                                @if ($food->celiac === 1)
                                    <p class="badge bg-warning rounded-pill px-3 border me-2"><i
                                            class="fa-solid fa-bread-slice"></i></p>
                                @endif
                                @if ($food->vegan === 1)
                                    <p class="badge bg-success rounded-pill px-3 border"><i
                                            class="fa-solid fa-seedling"></i></p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body d-flex flex-column justify-content-between h-100">
                                @if ($food->available === 1)
                                    <span class="badge bg-success">Disponibile</span>
                                @else
                                    <span class="badge bg-danger">Non Disponibile</span>
                                @endif
                                <div>
                                    <h3 class="card-title mt-4 mb-0">{{ $food->name }}</h3>
                                    <p class="mt-0">{{ $food->category->name }}</p>
                                </div>


                                <p class="card-text fs-5">{{ $food->description }}</p>
                                <p class="card-text fs-5"><strong>Price:</strong> {{ $food->price }} €</p>
                                <div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text mb-0"><small class="text-muted">Last updated:
                                                {{ $food->updated_at->format('d/m/Y') }}</small></p>
                                        <a href="{{ route('admin.foods.edit', ['food' => $food->id]) }}"
                                            class="btn ms_btn-yellow position-relative">Modifica</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
