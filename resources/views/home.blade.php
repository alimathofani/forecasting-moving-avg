@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Forecasting</h1>
    </div>
    
    <form method="post" action="{{ route('home.store') }}">
        @csrf
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-info float-left">Form</h4>
                <div class="float-right">
                    <select class="form-control" name="item_id" required>
                        <option value="">Pilih Barang</option>
                        @foreach($items as $key => $item)
                            <option @if (old('unit') == $item) selected="selected" @endif value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"># Periode 
                                <select size="1" id="periode-select" class="form-control" name="type">
                                    <option value="Bulan" selected="selected">
                                        Bulan
                                    </option>
                                    <option value="Tahun">
                                        Tahun
                                    </option>
                                </select>
                            </th>
                            <th scope="col">Total Penjualan</th>
                            <th scope="col">
                                <button type="button" class="btn btn-success add_field_button">Add + </button>
                                <button type="button" class="btn btn-danger remove_field_button">Remove Field</button>
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="input_fields_wrap">
                        @php
                            $sort = 1;
                        @endphp
                        @for($i = 1; $i <= 60; $i++)

                        <tr>
                            <th scope="row">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text periodeText">Bulan</div>
                                    </div>
                                    <input type="number" min="1" class="form-control periodeField" required name="periode[]" value='{{ $sort++ }}'>
                                </div>
                            </th>
                            <td colspan="2">
                                <input type="number" min="1" class="form-control totalField" placeholder="Total" aria-label="Total" required name="total[]" value='{{ rand(400,500) }}'>
                            </td>
                        </tr> 
                        @endfor    
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var max_fields      = 9999999999; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var remove_button   = $(".remove_field_button");
        var lenghtInput     = wrapper[0].children.length;
        var periode         = $("#periode-select").children("option:selected")[0].text;
        
        // var x = 1; //initlal text box count
        // var number = x; //initlal text box count
        $(add_button).click(function(e){
            e.preventDefault();
            var total_fields = wrapper[0].children.length;
            if(total_fields < max_fields){
                $(wrapper).append('<tr><th scope="row"><div class="input-group"><div class="input-group-prepend"><div class="input-group-text periodeText">'+ periode +'</div></div><input type="number" class="form-control periodeField" required name="periode[]"></div></th><td colspan="2"><input type="number" class="form-control totalField" placeholder="Total" aria-label="Total" required name="total[]"></td></tr> ');
            }
        });

        $(remove_button).click(function(e){
            e.preventDefault();
            var total_fields = wrapper[0].children.length;
            if(total_fields>{{ $periode }}){
                wrapper[0].children[total_fields-1].remove();
            }
        });

        $( "#periode-select" ) .change(function (test) {
            periode = test.currentTarget.value;
            $(".periodeText").html(periode);
        });
        
    });
</script>
@endsection

