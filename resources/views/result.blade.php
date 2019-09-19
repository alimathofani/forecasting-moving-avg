@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @foreach($forecasting as $key => $data)
        <div class="col-md-11">
            <div class="card">
                {{ $data['item']['name'] }}
                <div class="card-header">Forecasting Moving Average <span class="float-right"># {{ $key }}</span></div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#
                                    {{ $data['master'][0]['type'] }}
                                </th>
                                <th scope="col">Total Penjualan</th>
                                <th scope="col">EMA</th>
                                <th scope="col">Forecast Error (ACTUAL - ERROR)</th>
                                <th scope="col">MEAN ABSOLUTE DEVIATION)</th>
                                <th scope="col">MEAN SQUARED ERROR</th>
                                <th scope="col">MEAN ABSOLUTE PERCENT ERROR</th>
                            </tr>
                        </thead>
                        <tbody class="input_fields_wrap">
                            @foreach($data['forecasting']['dataFinal'] as $item)
                            <tr>
                                <th scope="row">{{ $item['periode'] }}</th>
                                <th scope="row">{{ $item['total'] }}</th>
                                <th scope="row">{{ $item['ema'] }}</th>
                                <td scope="row">{{ $item['actual'] }}</td>
                                <td scope="row">{{ $item['abs'] }}</td>
                                <td scope="row">{{ $item['squared'] }}</td>
                                <td scope="row">{{ $item['abs_percent'] }}</td>
                            </tr> 
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{ $data['forecasting']['dataAverage']['averageAbs']['value'] }}</th>
                                <th>{{ $data['forecasting']['dataAverage']['averageSquared']['value'] }}</th>
                                <th>{{ $data['forecasting']['dataAverage']['averageAbsPercent']['value'] }}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>MAD</th>
                                <th>MSE</th>
                                <th>MAPE</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <canvas id="myChart_{{$key}}" width="200" height="200"></canvas>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js')}}"></script>

<script>
@foreach($forecasting as $key => $data)
var ctx_{{$key}} = document.getElementById('myChart_{{$key}}').getContext('2d');
var myChart = new Chart(ctx_{{$key}}, {
    type: 'line',
    data: {
            labels: [
                @foreach($data['forecasting']['dataFinal'] as $item)
                    {{ $item['periode'] }},
                @endforeach
                ],
            datasets: [
                {
                    label: '# Total Penjualan',
                    fill: false,
                    
                    data: [
                        @foreach($data['forecasting']['resultTotal'] as $item)
                        {{$item}},
                        @endforeach
                        ],
                    
                    backgroundColor: 'blue',
                    borderColor: 'blue',
                    borderWidth: 1
                },
                {
                    label: '# Forecasting Moving Average',
                    fill: false,
                    
                    data: [
                        @foreach($data['forecasting']['ema'] as $item)
                        {{$item}},
                        @endforeach
                        ],
                    
                    backgroundColor: 'red',
                    borderColor: 'red',
                    borderWidth: 1
                }
            ]
        },
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'Chart.js Line Chart'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Month'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'
                }
            }]
        }
    }
});
@endforeach
</script>
@endsection

