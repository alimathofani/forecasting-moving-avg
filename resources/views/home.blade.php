@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-9">
            <form method="post" action="{{ route('home.store') }}">
                @csrf
                <div class="card">
                    <div class="card-header">Forecasting Moving Average 
                        <span class="float-right">
                            <select class="form-control" name="item_id" required>
                                <option value="">Pilih Barang</option>
                                @foreach($items as $key => $item)
                                    <option @if (old('unit') == $item) selected="selected" @endif value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </span> </div>

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
                                @for($i = 1; $i <= 3; $i++)
                                <tr>
                                    <th scope="row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text periodeText">Bulan</div>
                                            </div>
                                            <input type="number" min="1" class="form-control periodeField" required name="periode[]">
                                        </div>
                                    </th>
                                    <td colspan="2">
                                        <input type="number" min="1" class="form-control totalField" placeholder="Total" aria-label="Total" required name="total[]">
                                    </td>
                                </tr> 
                                @endfor    
                            </tbody>
                        </table>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var max_fields      = 12; //maximum input boxes allowed
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
                // $(wrapper).append('<tr><th scope="row">'+ (total_fields + 1) +'</th><td colspan="2"><input type="text" class="form-control" placeholder="Total" aria-label="Total" required name="total[]"></td></tr>');
                $(wrapper).append('<tr><th scope="row"><div class="input-group"><div class="input-group-prepend"><div class="input-group-text periodeText">'+ periode +'</div></div><input type="text" class="form-control periodeField" required name="periode[]"></div></th><td colspan="2"><input type="text" class="form-control totalField" placeholder="Total" aria-label="Total" required name="total[]"></td></tr> ');
            }
        });

        $(remove_button).click(function(e){
            e.preventDefault();
            var total_fields = wrapper[0].children.length;
            if(total_fields>3){
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

