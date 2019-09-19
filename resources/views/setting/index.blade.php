@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (!$settings->count())
            <div class="col-md-11 text-center">
                <h1>Generate Setting</h1>
                <h4>Generate the setting first before run this program!</h4>
            <form action="{{ route('settings.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-primary">Generate</button>
                </form>
            </div>
        @else
            <div class="col-md-11">
                <div class="text-center">
                    <h2>Setting</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="input_fields_wrap">
                                @foreach($settings as $data)
                                <tr>
                                    <th scope="row">{{ ++$i }}</th>
                                    <th scope="row">{{ $data->name }}</th>
                                    <th scope="row">{{ $data->value }}</th>
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
        @endif
    </div>
</div>
@endsection

@section('scripts')
@endsection