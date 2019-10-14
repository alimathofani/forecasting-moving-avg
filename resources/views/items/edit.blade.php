@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Barang</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow">
                <div class="card-body">
					<form action="{{ route('items.update', $item->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Nama Barang</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $item->name}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('scripts')

@endsection