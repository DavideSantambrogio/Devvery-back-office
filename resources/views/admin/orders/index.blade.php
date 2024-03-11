@extends('layouts.admin')

@section('admin_page_name')
    I Tuoi Ordini
@endsection

@section('content')
    <div
        class="d-flex justify-content-between align-items-center mb-4 py-2 px-4 align-items-center rounded ms_bg-horizontal text-white">
        <h2>I tuoi Ordini: {{ count($total_orders) }}</h2>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn ms_btn-yellow float-center">INDIETRO</a>
            <a class="btn ms_btn-yellow mt-3 mt-sm-0" href="{{ route('admin.orders.complete') }}"><i class="fa-solid fa-check-to-slot"></i></i></a>
        </div>
        
    </div>

    <div class="container-fluid">

        <table class="table table-hover mb-5">
            <thead>
                <tr class="text-center">
                    <th scope="col">N.Ordine</th>
                    <th class="d-none" scope="col">Cliente</th>
                    <th class="d-none" scope="col" colspan="2">Indirizzo</th>
                    <th scope="col">Data</th>
                    <th class="d-none" scope="col">Spesa Totale</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders_list as $order)
                    <tr class="text-center">
                        <th>#{{ $order->id }}</th>
                        <td class="d-none">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                        <td class="d-none" colspan="2">{{ $order->customer->address }}</td>
                        <td>{{ $order->formatted_created_at }}</td>
                        <td class="d-none">{{ $order->total_amount }} €</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}"
                                    class="btn ms_btn-yellow"><i class="fa-regular fa-eye"></i></a>
                                <form action="{{ route('admin.order.check', ['order' => $order->id]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button @disabled($order->status === 1) type="submit"
                                        class="ms_btn-yellow"><i
                                            class="fa-solid fa-circle-check"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            {{ $orders_list->render() }}
    </div>
@endsection
