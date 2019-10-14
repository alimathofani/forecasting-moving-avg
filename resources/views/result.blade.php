@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Hasil Pengujian FMA</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 ">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered main-table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th><i class="fas fa-fw fa-plus"></i></th>
                                <th>ID</th>
                                <th>Deskripsi</th>
                                <th>Barang</th>
                                <th>EMA</th>
                                <th>MAD</th>
                                <th>MSE</th>
                                <th>MAPE</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
        .main-table {
            font-size: 14px;
        }
        
</style>
@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/amcharts4/core.js') }}"></script>
<script src="{{ asset('vendor/amcharts4/charts.js') }}"></script>
<script src="{{ asset('vendor/amcharts4/themes/animated.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable( {
        ajax: '{{ route('result.list') }}',
        columns: [
            {
                className:      'details-control',
                orderable:      false,
                data:           null,
                defaultContent: '<i class="fas fa-fw fa-plus-circle"></i>'
            },
            { data: "id" },
            { data: "name" },
            { data: "item" },
            { data: "forecasting.ema_end" },
            { data: "forecasting.dataAverage.averageAbs.value" },
            { data: "forecasting.dataAverage.averageSquared.value" },
            { data: "forecasting.dataAverage.averageAbsPercent.value" },
            {
                orderable:      false,
                data: 'id',
                render: function (data, type, row, meta) {
                    var url = '{{ route('result.destroy', ":id") }}';
                    url = url.replace(':id', data);
                    return '<form action="'+url+'" method="post" style="display: inline;" class="float-right" onclick="return confirm('+ "'Are you sure?'" + ')" >@csrf @method('DELETE')<input type="submit" value="Delete" class="btn btn-danger" ></form>';
                }
            },
        ],
        order: [[1, 'desc']]
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

function format ( rowData ) {
    var div = $('<div/>')
        .addClass( 'loading' )
        .text( 'Loading...' );
 
    $.ajax( {
        url: '{{ route('result.show') }}',
        data: {
            id: rowData.id
        },
        dataType: 'json',
        success: function ( json ) {
            var str = "";
            var dataArr = json.data.forecasting.dataFinal;
            var resultTotal = json.data.forecasting.resultTotal;
            var emaTotal = json.data.forecasting.ema;
            var id = json.data.id;
            var dataType = json.data.master[0].type;
            
            var periode = '';

            dataArr.forEach(function(element) {
                if(dataType == "Bulan"){
                    periode = moment(element.periode).format('MMMM YYYY');
                }else{
                    periode = moment(element.periode).format('YYYY');
                }
                str += '<tr>'+
                    '<td>'+ (element.periode != null ? periode : "") +'</td>'+
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
                '<th># '+ json.data.master[0].type +'</th>'+
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
            '<div class="row"><div class="col-md-11">'+
            '<div id="chartdiv-'+id+'" class="chart-result"></div>'+
            '</div></div>';

            
            div.html(tpl).removeClass( 'loading' );

            am4core.ready(function() {
    
                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end
                
                // Create chart instance
                var chart = am4core.create("chartdiv-"+id, am4charts.XYChart);
                chart.dateFormatter.dateFormat = "dd/mm/yyyy";
                
                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.minGridDistance = 50;
                dateAxis.periodChangeDateFormats.setKey("month", "[bold]yyyy");
                
                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                

                // Add Data
                let series_one = createTrendLine(generateChartData(), 'value', 'Total', 'blue');
                let series_two = createTrendLine(generateChartData(), 'ema', 'EMA', 'red');
                
                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series_one);
                chart.scrollbarX.series.push(series_two);
                
                // Add cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.xAxis = dateAxis;
                
                function createTrendLine(data, value, name, color) {
                    let trend = chart.series.push(new am4charts.LineSeries());
                    trend.dataFields.valueY = value;
                    trend.dataFields.dateX = "date";
                    trend.strokeWidth = 2;
                    trend.stroke = am4core.color("#c00");
                    trend.data = data;
                    trend.name = name;
                    trend.fill = am4core.color(color);
                    trend.stroke = am4core.color(color);

                    trend.tooltipText = "{name}: [bold]{valueY}[/]";
                    trend.tooltip.pointerOrientation = "vertical";
                    trend.tooltip.background.cornerRadius = 20;
                    trend.tooltip.background.fillOpacity = 0.5;
                    trend.tooltip.label.padding(12,12,12,12)

                    let bullet = trend.bullets.push(new am4charts.CircleBullet());
                    bullet.strokeWidth = 2;
                    bullet.stroke = am4core.color("#fff");
                    bullet.circle.fill = trend.stroke;

                    return trend;
                };

                function generateChartData() {
                    var chartData = [];
                    for (var i = 0; i < dataArr.length; i++) {
                        var totalTrans = resultTotal[i];
                        var dateTrans = dataArr[i].periode;
                        var ema = emaTotal[i];
                
                        chartData.push({
                            date: dateTrans,
                            value: totalTrans,
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

</script>
@endsection

