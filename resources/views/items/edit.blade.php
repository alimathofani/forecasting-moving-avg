@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Master Barang</div>

                <div class="card-body">
					<form action="{{ route('items.update', $item->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Nama Barang</label>
							<input type="text" class="form-control" name="name" id="name" value="{{ $item->name}}">
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