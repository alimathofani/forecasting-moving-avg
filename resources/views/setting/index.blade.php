@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-hover table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="input_fields_wrap">
                            @foreach($settings as $data)
                            <tr>
                                <th scope="row">{{ ++$i }}</th>
                                <th scope="row">{{ $data->name }}</th>
                                <th scope="row">{!! $data->status? '<span class="badge badge-success">ON</span>' : '<span class="badge badge-secondary">OFF</span>' !!}</th>
                                <th scope="row">
                                    <a class="btn btn-primary" href="{{ route('settings.edit',$data->id) }}">Edit</a>
                                </th>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection