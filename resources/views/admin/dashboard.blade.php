@extends('layouts.admin')

@section('admin_page_name')
    Dashboard
@endsection

@section('content')

    <div class="container-fluid">

        <div
            class="d-flex justify-content-between align-items-center mb-4 py-2 px-4 align-items-center rounded ms_bg-horizontal text-white flex-wrap">
            <h2>Ciao {{ $user->name }}</h2>
            @if ($user->userDetail)
                <p class="mt-3"><strong>Partita IVA:</strong><br> {{ $user->userDetail->vat_number }}
                </p>
                <p class="mt-3"><strong>Telefono:</strong><br> {{ $user->userDetail->phone }}</p>
                <p class="mt-3"><strong>Indirizzo:</strong><br> {{ $user->userDetail->address }}</p>

                <a class="btn ms_btn-yellow" href="{{ route('admin.userDetails.edit', ['userDetail' => Auth::user()->id]) }}">
                    Modifica i tuoi dati
                </a>
            @endif
        </div>

        {{-- Message Section --}}
        @if (Session::has('message'))
            <div class="container text-center mt-3">
                <p class="alert alert-dark ms_color-dark fw-bold">
                    {{ strtoupper(Session::get('message')) }}
                </p>
            </div>
        @endif

        <div class="row d-flex justify-content-center text-center">
            <div class="col-md-8">
                @if (!$restaurant)
                    <div>
                        <div class="card shadow align-self-streach ">
                            <div class="card-body">
                                @if (!$user->userDetail)
                                    <p class="fw-bolder">Per creare un ristorante, inseirsci prima i tuoi dati personali</p>

                                    <a class="btn ms_btn-yellow" href="{{ route('admin.userDetails.create') }}">
                                        Inserisci i tuoi dati
                                    </a>
                                @endif

                                @if (!empty($user->userDetail) && !$restaurant)
                                    <p class="mt-3 fw-bolder">Crea il tuo Ristorante per cominciare</p>

                                    <a class="btn ms_btn-yellow" href="{{ route('admin.restaurants.create') }}">
                                        Aggiungi un ristorante
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                @if ($restaurant)
                    <div class="card shadow align-self-streach mt-5 mt-md-0">
                        <div class="card-header">
                            <h4>{{ $restaurant->name }}</h4>
                        </div>
                        <div class="card-body">
                            @if ($restaurant->cover_image)
                                <img class="w-50 my-3" src="{{ asset('storage/' . $restaurant->cover_image) }}"
                                    alt="immagine del ristorante">
                            @else
                                <img src="{{ Vite::asset('resources\img\noimg.png') }}" class="w-50 my-3"
                                    alt="Immagine non disponibile">
                            @endif
                            <div class="my-4 d-flex flex-wrap gap-1 justify-content-center">
                                @foreach ($restaurant->types as $type)
                                    <span class="ms_badge-dark">{{ $type->name }}</span>
                                @endforeach
                            </div>
                            <hr>
                            <p class="mb-2"><strong>Indirizzo: </strong>{{ $restaurant->address }}</p>
                            <p class="mb-2"><strong>Telefono: </strong>{{ $restaurant->phone }}</p>
                            @if ($restaurant->description)
                                <p class="mb-2"><strong>Descrizione: </strong>{{ $restaurant->description }}</p>
                            @endif

                            <div
                                class="mt-4 d-flex flex-column gap-4 align-items-center flex-md-row justify-content-center">
                                <a class="btn ms_btn-yellow"
                                    href="{{ route('admin.restaurants.edit', ['restaurant' => $restaurant->slug]) }}">
                                    Modifica il ristorante
                                </a>

                                <form class="d-inline-block"
                                    action="{{ route('admin.restaurants.destroy', ['restaurant' => $restaurant->slug]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button data-title='Il tuo Ristorante' type="submit" class="btn ms_btn-red delete-btn"
                                        data-bs-toggle="modal" data-bs-target="#modal-delete">Cancella il
                                        ristorante</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>



        @include('partials.modal_delete')
    </div>
@endsection
