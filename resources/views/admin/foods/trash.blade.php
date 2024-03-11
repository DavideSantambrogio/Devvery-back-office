@extends('layouts.admin')

@section('admin_page_name')
    Cestino
@endsection

@section('content')

    {{-- Trash Table --}}
    <div class="container-fluid">

        @if (count($foods) > 0)
            <div
                class="d-flex justify-content-between align-items-center mb-4 py-2 px-4 align-items-center rounded ms_bg-horizontal text-white">
                <h2>I tuoi piatti eliminati: {{ count($food_deleted) }}</h2>
                <a href="{{ route('admin.foods.index') }}" class="btn ms_btn-yellow float-center">INDIETRO</a>
            </div>

            <div class="mt-5 d-flex justify-content-between align-items-center">
                <div>
                    {{-- Restore Message Success --}}
                    @if (session('message'))
                        <div class="container text-center">
                            <p class="alert alert-success fw-bold">
                                {{ strtoupper(session('message')) }}
                            </p>
                        </div>
                    @endif

                    {{-- Def Delete Message --}}
                    @if (session('def_del_mess'))
                        <div class="container text-center">
                            <p class="alert alert-danger fw-bold">
                                {{ strtoupper(session('def_del_mess')) }}
                            </p>
                        </div>
                    @endif
                </div>
                {{ $foods->render() }}
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                @foreach ($foods as $food)
                    <div class="col g-4">
                        <div class="card shadow rounded h-100">
                            <div class="card-body h-25">
                                <h5 class="card-title mb-0">{{ $food->name }}</h5>
                                <p class="mt-0">{{ $food->category->name }}</p>
                                <hr>
                            </div>
                            <div class="card-body h-50">
                                <h5>Descrizione:</h5>
                                <p>{{ $food->description }}</p>
                            </div>
                            <div
                                class="gap-2 d-flex card-body flex-wrap align-items-center justify-content-around border-top border-2">
                                <form action="{{ route('admin.foods.restore', ['food' => $food->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn ms_btn-yellow" type="submit">RIPRISTINA</button>
                                </form>
                                <form action="{{ route('admin.foods.def_destroy', ['food' => $food->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn ms_btn-red def-delete-btn" type="submit" data-bs-toggle="modal"
                                        data-bs-target="#modal-def-delete">CANCELLA</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div
                class="d-flex justify-content-between align-items-center mb-4 py-2 px-4 align-items-center rounded ms_bg-horizontal text-white">
                <h2 class="">Il tuo cestino è vuoto</h2>
            </div>
            <div class="d-flex justify-content-center">
                <a href="{{ route('admin.foods.index') }}" class="btn ms_btn-dark float-center">INDIETRO</a>
            </div>
        @endif

        {{-- Deleted Modal --}}
        @include('partials.modal_def_delete')
    </div>
@endsection
