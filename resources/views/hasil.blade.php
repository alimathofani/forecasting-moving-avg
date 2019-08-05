@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>Forecasting Moving Average</h2>
        <div class="col-md-9">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="input_fields_wrap">
                    @foreach($transaction as $key => $data)
                    <tr>
                        <th scope="row">{{ ++$i }}</th>
                        <th scope="row">{{ $key }}</th>
                        <th scope="row">{{ $data->first()->item['name'] }}</th>
                        <th scope="row">
                            <a class="btn btn-primary" href="{{ route('detail.index', $key) }}">Hitung FMA</a>
                            <form action="{{ route('delete_detail.destroy', $key) }}" method="post" style="display: inline;" class="float-right">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                        </th>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


