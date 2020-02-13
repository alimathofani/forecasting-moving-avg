@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">NOTA</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <form action="{{ route('sales.store') }}" method="POST">
            <div class="card shadow">
                <div class="card-header py-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text periodeText">Bulan</div>
                        </div>
                        <input type="text" min="1" class="form-control periodeField set-datepicker" required name="date">
                    </div>
                </div>
                <div class="card-body">
                        @csrf
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody class="input_fields_wrap">
                                @for ($i=1; $i <= $count ; $i++)
                                <tr>
                                    <th scope="row">
                                        {{ $i }}
                                    </th>
                                    <th scope="row">
                                        <input type="hidden" class="sale_id-{{ $i }}" name="sale_id[]">
                                        <div class="form-group">
                                            <select class="form-control item items-{{ $i }}" id="items" name="item[]">
                                                <option selected disabled>-- Select Item -- </option>
                                                @foreach ($items as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <input class="form-control price prices-{{ $i }}" type="number" name="price[]">
                                    </th>
                                    <th scope="row">
                                        <input class="form-control qty qtys-{{ $i }}" type="number" value="0" name="qty[]">
                                    </th>
                                    <th scope="row">
                                        <input class="form-control total totals-{{ $i }}" type="number" readonly value="0" name="total[]">
                                    </th>
                                </tr> 
                                @endfor
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    $("input").change(function(){
        var price = $(this).parent().parent().find('.price').val();
        var qty = $(this).parent().parent().find('.qty').val();
        var total = price * qty;
        $(this).parent().parent().find('.total').val(total);
    });
    $('.set-datepicker').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        autoClose: true,
        position: "bottom left",
        onShow: function(dp, animationCompleted){
            if (!animationCompleted) {
                dp.el.readOnly = true
            }
        },
        onHide: function(dp, animationCompleted){
            if (!animationCompleted) {
                dp.el.readOnly = false
            }
        }
    });
    
    $('[name=date]').focusout(function(){
        var _this = $(this);
        var value = _this.val();

        if(value !== ''){
            $.ajax({
                type:'GET',
                url:"{{ route('sales.data') }}",
                data:{
                    date: value
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'JSON',
                success:function(data){
                    data.forEach((value, key) => {
                        let keyField = key + 1;
                        $('select.items-' + keyField).val(value.item.id);
                        $('.prices-' + keyField).val(value.price);
                        $('.qtys-' + keyField).val(value.qty);
                        $('.totals-' + keyField).val(value.total);
                        $('.sale_id-' + keyField).val(value.id);
                    });
                }
            });
        }
    });
});
</script>
@endsection