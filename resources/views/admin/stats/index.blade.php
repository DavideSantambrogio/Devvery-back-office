@extends('layouts.admin')

@section('admin_page_name')
    Statistiche
@endsection

@section('content')
    <div
        class="d-flex justify-content-between align-items-center mb-4 py-2 px-4 align-items-center rounded ms_bg-horizontal text-white">
        <h2>Statistiche</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn ms_btn-yellow float-center">INDIETRO</a>
    </div>

    @if (count($orders) > 20)
        <div class="container-fluid">
            <div class="card mb-4">
                <h2 class="text-center card-header">I tuoi Piatti forti</h2>
                <div class="d-flex fw-bold py-3 justify-content-around px-4 ms_background">
                    <div>
                        <div class="d-flex align-items-start align-items-center gap-3">
                            <img class="ms_img_width" src="{{ Vite::asset('resources\img\coccarda_1.png') }}"
                                alt="primo_posto">
                            <p id="gold" class="m-0 p-0"></p>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-start align-items-center gap-3">
                            <img class="ms_img_width" src="{{ Vite::asset('resources\img\coccarda_2.png') }}"
                                alt="primo_posto">
                            <p id="silver" class="m-0 p-0"></p>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-start align-items-center gap-3">
                            <img class="ms_img_width" src="{{ Vite::asset('resources\img\coccarda_3.png') }}"
                                alt="primo_posto">
                            <p id="bronze" class="m-0 p-0"></p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="charts-container row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <div class="card mb-4">
                        <div class="card-body chart col p-4">
                            <canvas id="lineChartOrders"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card mb-4">
                        <div class="card-body chart col p-4">
                            <canvas id="lineChartAmount"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card mb-4">
                        <div class="card-body chart col p-4">
                            <canvas id="barChartOrders"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card mb-4">
                        <div class="card-body chart col p-4">
                            <canvas id="barChartAmount"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    @else
        <div class="row d-flex justify-content-center ">
            <h1 class="text-center ms_bg-yellow p-3 col-md-6">Le statistiche si visualizzano dopo un minimo di 20 ordini
                ricevuti</h1>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {

            const bestsFoods = await fetch('/admin/chart/most-ordered-food', {
                method: 'GET',
            }).then(response => response.json());

            // SE VOGLIO VISUALIZZARE ANCHE IL NUMERO TOTALE PER OGNI PIATTO VENDUTO
            // document.getElementById('gold').innerHTML += bestsFoods[0].name + ' X ' + bestsFoods[0]
            //     .total_ordered;

            document.getElementById('gold').innerHTML += bestsFoods[0].name;
            document.getElementById('silver').innerHTML += bestsFoods[1].name;
            document.getElementById('bronze').innerHTML += bestsFoods[2].name;

            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////


            const resultAPI = await fetch('/admin/charts/order/month', {
                method: 'GET',
            }).then(response => response.json());

            const ctxLine = document.getElementById('lineChartOrders');
            const data = resultAPI;

            const labels = data.map(item => {
                const monthNames = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                    "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
                ];
                return monthNames[item.x - 1];
            });

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ordini mensili',
                        data: data.map(item => item.orders),
                        parsing: {
                            yAxisKey: 'orders'
                        }
                    }]
                },
                options: {
                    backgroundColor: 'rgba(241, 48, 5, 0.2)',
                    borderColor: 'rgba(241, 48, 5, 1)',
                    borderWidth: 1,
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////

            const resultAPIyear = await fetch('/admin/charts/order/year', {
                method: 'GET',
            }).then(response => response.json())

            const ctxBar = document.getElementById('barChartOrders');

            let array_orders = [];
            for (let i = 0; i < resultAPIyear.orders.length; i++) {
                array_orders.push(resultAPIyear.orders[i].orders)
            }

            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: resultAPIyear.years,
                    datasets: [{
                        label: 'Ordini annui',
                        data: array_orders,
                        parsing: {
                            yAxisKey: 'orders'
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    backgroundColor: 'rgba(241, 48, 5, 0.2)',
                    borderColor: 'rgba(241, 48, 5, 1)',
                    borderWidth: 1,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////

            const resultAmountMonth = await fetch('/admin/charts/amount/month', {
                method: 'GET',
            }).then(response => response.json())

            const ctxLineAmount = document.getElementById('lineChartAmount');
            const dataAmount = resultAmountMonth

            const amount_labels = data.map(item => {
                const monthNames = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                    "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
                ];
                return monthNames[item.x - 1];
            });

            new Chart(ctxLineAmount, {
                type: 'line',
                data: {
                    labels: amount_labels,

                    datasets: [{
                        label: 'Incassi mensili €',
                        data: dataAmount.map(item => item.total),
                        parsing: {
                            yAxisKey: 'total'
                        },

                    }]
                },
                options: {
                    backgroundColor: 'rgba(241, 48, 5, 0.2)',
                    borderColor: 'rgba(241, 48, 5, 1)',
                    borderWidth: 1,
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            /////////////////////////////////////////////

            const resultAmountYear = await fetch('/admin/charts/amount/year', {
                method: 'GET',
            }).then(response => response.json())

            const ctxBarAmount = document.getElementById('barChartAmount');

            let array_amount = [];
            for (let c = 0; c < resultAmountYear.amount.length; c++) {
                array_amount.push(resultAmountYear.amount[c].amount)
            }

            new Chart(ctxBarAmount, {
                type: 'bar',
                data: {
                    labels: resultAmountYear.years,
                    datasets: [{
                        label: 'Incassi annui €',
                        data: array_amount,
                        parsing: {
                            yAxisKey: 'amount',
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    backgroundColor: 'rgba(241, 48, 5, 0.2)',
                    borderColor: 'rgba(241, 48, 5, 1)',
                    borderWidth: 1,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
    </script>
@endsection

<style>
    .ms_background {
        background-color: rgba(253, 182, 51, 0.1);
    }

    .ms_img_width {
        height: 40px;
    }
</style>
