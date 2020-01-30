@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Forecasting Moving Average 
        </h1>
    </div>
    
    <form method="post" action="{{ route('forecasting.store') }}" id="forecastingForm">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-info float-left mr-3">Create Data </h4>
                @if(!$setDivider)
                <a href="{{ route('settings.index') }}" class="float-right">
                    <span class="badge badge-danger font-italic"> Settings OFF ! Klik disini untuk meng-aktifkan </span>
                </a>
                @endif
            </div>
            <div class="card-body">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Nama Deskripsi</label>
                                    <input type="text" class="form-control" id="divider" required name="name" id="name" placeholder="Nama Deskripsi">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="choose_item">Pilih Barang</label>
                                    <select class="form-control" id="choose_item" required>
                                        <option value="">---</option>
                                        @foreach($items as $key => $item)
                                        <option @if (old('unit') == $item) selected="selected" @endif value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="item_id" id="item_id">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="divider">Pembagi</label>
                                    <div class="input-group mb-3">
                                        <input type="number" min="3" class="form-control" id="divider" placeholder="3" value="3" name="divider">
                                        <div class="input-group-append">
                                            <span class="input-group-text"> / </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="periode-select">Tipe Periode  </label>
                                <select size="1" id="periode-select" class="form-control" name="type">
                                    <option value="Bulan" selected="selected">
                                        Bulan
                                    </option>
                                    <option value="Tahun">
                                        Tahun
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">
                                <label for="periode-select">Total Penjualan </label>
                            </th>
                            <th scope="col">
                                <div class="float-right">    
                                    <button type="button" class="btn btn-success add_field_button">Add + </button>
                                    <button type="button" class="btn btn-danger remove_field_button">Remove - </button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="input_fields_wrap">
                        @php
                            $sort = 1;
                        @endphp
                        @for($i = 1; $i <= 12; $i++)

                        <tr>
                            <th scope="row">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text periodeText">Bulan</div>
                                    </div>
                                    <input type="text" min="1" class="form-control periodeField set-datepicker" required name="periode[]" {{-- value='{{ $sort++ }}' --}}>
                                </div>
                            </th>
                            <td colspan="2">
                                <input type="number" min="1" class="form-control totalField" placeholder="Total" aria-label="Total" required name="total[]">
                                {{-- value='{{ rand(400,500) }}' --}}
                            </td>
                        </tr> 
                        @endfor    
                    </tbody>
                </table>
                <button type="submit" class="btn btn-block btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<link href="{{ asset('vendor/datepicker/css/datepicker.min.css') }}" rel="stylesheet" type="text/css">
<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: #f7f9ff;
        opacity: 1;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('vendor/datepicker/js/datepicker.min.js') }}"></script>
<script src="{{ asset('vendor/datepicker/js/i18n/datepicker.en.js') }}"></script>

<script>
    $(document).ready(function() {
        
        $('#choose_item').change(function(){
            $('#item_id').val($('#choose_item option:selected').val());
            $(this).attr('disabled', true);
        });
        
        var checkDivider = '{{ $setDivider }}';
        if(!checkDivider){
            $("#forecastingForm :input").prop("disabled", true);
        }

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
            if(total_fields> 12 ){
                wrapper[0].children[total_fields-1].remove();
            }
        });

        $('[name^=periode]').focusout(function(){
            var _this = $(this);
            var value = _this.val();
            var item_id = $('#item_id').val();
            if(!item_id){
                return alert('Pilih Barang Terlebih Dahulu');
            }

            if(value !== ''){
                $.ajax({
                    type:'GET',
                    url:"{{ route('sales.calculate') }}",
                    data:{
                        date: value,
                        item: item_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:'JSON',
                    success:function(data){
                        // data.total;
                        _this.parent().parent().siblings().children().val(data.total);
                    }
                });
            }
        });
        
        $("#periode-select").change(function (test) {
            periode = test.currentTarget.value;
            if(periode == "Bulan"){
                $(".periodeText").html(periode);
                $('.set-datepicker').datepicker({
                    language: 'en',
                    minView: "months",
                    view: "months",
                    dateFormat: "MM yyyy",
                    autoClose: true,
                    position: "bottom right",
                    onShow: function(dp, animationCompleted){
                        if (!animationCompleted) {
                            dp.el.readOnly = true
                        }
                    },
                    onHide: function(dp, animationCompleted){
                        if (!animationCompleted) {
                            dp.el.readOnly = false
                        }
                    },
                    onSelect: function onSelect(fd, date) {
                        // console.log(fd, date);
                        // console.log($(this).parents().parents().parents().parents().parents());
                    }
                });
            }else if(periode == "Tahun"){
                $(".periodeText").html(periode);
                $('.set-datepicker').datepicker({
                    language: 'en',
                    minView: "years",
                    view: "years",
                    dateFormat: "yyyy",
                    autoClose: true,
                    position: "bottom right"
                });
            }
        }).change();
        
    });
</script>
@endsection

