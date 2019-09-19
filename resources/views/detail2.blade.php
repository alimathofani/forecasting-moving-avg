@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Forecasting Moving Average</h2>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><i class="fas fa-fw fa-plus"></i></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>EMA</th>
                        <th>MAD</th>
                        <th>MSE</th>
                        <th>MAPE</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
        .chart-result {
          width: 100%;
          height: 400px;
        }
        
</style>
@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js')}}"></script>
<script src="{{ asset('vendor/amcharts4/core.js') }}"></script>
<script src="{{ asset('vendor/amcharts4/charts.js') }}"></script>
<script src="{{ asset('vendor/amcharts4/themes/animated.js') }}"></script>

<script>

/* Formatting function for row details - modify as you need */
function format ( rowData ) {
    var div = $('<div/>')
        .addClass( 'loading' )
        .text( 'Loading...' );
 
    $.ajax( {
        url: '{{ route('api.detail') }}',
        data: {
            unique: rowData.unique
        },
        dataType: 'json',
        success: function ( json ) {
            var str = "";
            var dataArr = json.data[0].forecasting.dataFinal;
            var resultTotal = json.data[0].forecasting.resultTotal;
            var emaTotal = json.data[0].forecasting.ema;
            var unique = json.data[0].unique;

            dataArr.forEach(function(element) {
                str += '<tr>'+
                    '<td>'+ (element.periode != null ? element.periode : "") +'</td>'+
                    '<td>'+ (element.total != null ? element.total : "") +'</td>'+
                    '<td>'+ (element.ema != null ? element.ema : "")+'</td>'+
                    '<td>'+element.actual+'</td>'+
                    '<td>'+element.abs+'</td>'+
                    '<td>'+element.squared+'</td>'+
                    '<td>'+element.abs_percent+'</td>'+
                    '</tr>';
            });

            var tpl = '<table class="table table-hover table-dark expand" >'+
                '<thead>'+
            '<tr>'+
                '<th># '+ json.data[0].master[0].type +'</th>'+
                '<th>Total Penjualan</th>'+
                '<th>EMA</th>'+
                '<th>Forecast Error (ACTUAL - ERROR)</th>'+
                '<th>MEAN ABSOLUTE DEVIATION)</th>'+
                '<th>MEAN SQUARED ERROR</th>'+
                '<th>MEAN ABSOLUTE PERCENT ERROR</th>'+
            '</tr>'+
                '</thead>'+
                '<tbody>'+
                    str+
                '</tbody>'+
            '</table>'+
            '<div id="chartdiv-'+unique+'" class="chart-result"></div>';

            
            div
                .html(tpl)
                .removeClass( 'loading' );

            am4core.ready(function() {
    
                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end
                
                // Create chart instance
                var chart = am4core.create("chartdiv-"+unique, am4charts.XYChart);
                
                // Add data
                chart.data = generateChartData();
                console.log(chart.data);
                
                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.minGridDistance = 50;
                
                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                
                // Create series
                var series = chart.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = "visits";
                series.dataFields.dateX = "date";
                series.strokeWidth = 2;
                series.minBulletDistance = 10;
                series.tooltipText = "Total: [bold]{valueY}[/]";
                series.tooltip.pointerOrientation = "vertical";
                series.tooltip.background.cornerRadius = 20;
                series.tooltip.background.fillOpacity = 0.5;
                series.tooltip.label.padding(12,12,12,12)
                
                // Create series
                function createAxisAndSeries(field, name, opposite, bullet) {
                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    
                    var series = chart.series.push(new am4charts.LineSeries());
                    series.dataFields.valueY = field;
                    series.dataFields.dateX = "date";
                    series.strokeWidth = 2;
                    series.minBulletDistance = 10;
                    series.yAxis = valueAxis;
                    series.name = name;
                    // series.tooltipText = "{valueY}";
                    series.tooltipText = "{name}: [bold]{valueY}[/]";
                    series.tooltip.pointerOrientation = "vertical";
                    series.tooltip.background.cornerRadius = 20;
                    series.tooltip.background.fillOpacity = 0.5;
                    series.tooltip.label.padding(12,12,12,12)
                    
                    valueAxis.renderer.line.strokeOpacity = 1;
                    valueAxis.renderer.line.strokeWidth = 2;
                    valueAxis.renderer.line.stroke = series.stroke;
                    valueAxis.renderer.labels.template.fill = series.stroke;
                    valueAxis.renderer.opposite = opposite;
                    valueAxis.renderer.grid.template.disabled = true;
                }

                // createAxisAndSeries("visits", "Total", false, "circle");
                createAxisAndSeries("ema", "EMA", true, "");
                // createAxisAndSeries("hits", "Hits", true, "rectangle");
                
                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series);
                
                // Add cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.xAxis = dateAxis;
                chart.cursor.snapToSeries = series;
                
                function generateChartData() {
                    var chartData = [];
                    var firstDate = new Date();
                    firstDate.setDate(firstDate.getDate() - 1000);

                    for (var i = 0; i < dataArr.length; i++) {
                        var newDate = new Date(firstDate);
                        newDate.setDate(newDate.getDate() + i);
                        var visits = resultTotal[i];
                        var ema = emaTotal[i];
                
                        chartData.push({
                            date: newDate,
                            visits: visits,
                            ema: ema
                        });
                    }
                    
                    return chartData;
                }

            });
        }
    } );
 
    return div;
}
 
$(document).ready(function() {
    var table = $('#dataTable').DataTable( {
        ajax: '{{ route('api.result') }}',
        columns: [
            {
                className:      'details-control',
                orderable:      false,
                data:           null,
                defaultContent: '<i class="fas fa-fw fa-plus-circle"></i>'
            },
            { data: "unique" },
            { data: "item" },
            { data: "forecasting.ema_end" },
            { data: "forecasting.dataAverage.averageAbs.value" },
            { data: "forecasting.dataAverage.averageSquared.value" },
            { data: "forecasting.dataAverage.averageAbsPercent.value" }
        ],
        order: [[1, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#dataTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
    
        if ( row.child.isShown() ) {
            $(this).html('<i class="fas fa-fw fa-plus-circle"></i>');
            row.child.hide();
            tr.removeClass('shown');
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
            $(this).html('<i class="fas fa-fw fa-minus-circle"></i>');
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
            
            
        }
    } );

    
} );

</script>
@endsection

