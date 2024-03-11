@extends('layouts.admin')

@section('admin_page_name')
    Dettagli Ordine
@endsection

@section('content')
    <div
        class="d-flex justify-content-between align-items-center mb-4 py-2 px-4 align-items-center rounded ms_bg-horizontal text-white">
        <h2>Ordine N. #{{ $order->id }}</h2>
        <a href="{{ url()->previous() }}" class="btn ms_btn-yellow float-center">INDIETRO</a>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Dati Cliente</h2>
                    </div>
                    <div class="card-body fs-5">
                        <p><strong>Nome:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
                        <p><strong>Indirizzo:</strong> {{ $order->customer->address }}</p>
                        <p><strong>Telefono:</strong> {{ $order->customer->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Dettagli Ordine</h2>
                    </div>
                    <div class="card-body fs-5">
                        <ul class="row list-unstyled text-center">

                            @if (count($appetizers) > 0)
                                <li class="col-md-6 mb-4">
                                    <h5>Antipasti</h5>
                                    @foreach ($appetizers as $order_food)
                                        <p>{{ $order_food->name }} <strong> x {{ $order_food->pivot->quantity_ordered }}</strong></p>
                                    @endforeach
                                </li>
                            @endif

                            @if (count($first_dishes) > 0)
                                <li class="col-md-6 mb-4">
                                    <h5>Primi</h5>
                                    @foreach ($first_dishes as $order_food)
                                        <p>{{ $order_food->name }} <strong> x {{ $order_food->pivot->quantity_ordered }}</strong></p>
                                    @endforeach
                                </li>
                            @endif

                            @if (count($second_dishes) > 0)
                                <li class="col-md-6 mb-4">
                                    <h5>Secondi</h5>
                                    @foreach ($second_dishes as $order_food)
                                        <p>{{ $order_food->name }} <strong> x {{ $order_food->pivot->quantity_ordered }}</strong></p>
                                    @endforeach
                                </li>
                            @endif

                            @if (count($side_dishes) > 0)
                                <li class="col-md-6 mb-4">
                                    <h5>Contorni</h5>
                                    @foreach ($side_dishes as $order_food)
                                        <p>{{ $order_food->name }} <strong> x {{ $order_food->pivot->quantity_ordered }}</strong></p>
                                    @endforeach
                                </li>
                            @endif

                            @if (count($sweets) > 0)
                                <li class="col-md-6 mb-4">
                                    <h5>Dolci</h5>
                                    @foreach ($sweets as $order_food)
                                        <p>{{ $order_food->name }} <strong> x {{ $order_food->pivot->quantity_ordered }}</strong></p>
                                    @endforeach
                                </li>
                            @endif

                            <li>
                                <hr>
                                <h5>Totale</h5>
                                <p class="mb-0">{{ $order->total_amount }} €</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
