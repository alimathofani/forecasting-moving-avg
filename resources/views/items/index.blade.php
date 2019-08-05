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
					<form action="{{ route('items.store') }}" method="POST">
						@csrf
						<div class="form-group">
							<label for="name">Nama Barang</label>
							<input type="text" class="form-control" name="name" id="name">
						</div>
						<button type="submit" class="btn btn-primary">Tambah</button>
					</form>
                </div>
            </div>
        </div>

        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
					<table class="table table-hover">
					    <thead>
					        <tr>
					            <th scope="col">No</th>
					            <th scope="col">Total Penjualan</th>
					            <th scope="col">Tanggal Buat</th>
					            <th scope="col">Action</th>
					        </tr>
					    </thead>
					    <tbody class="input_fields_wrap">
					    	@foreach($items as $data)
					        <tr>
					            <th scope="row">{{ ++$i }}</th>
					            <th scope="row">{{ $data->name }}</th>
					            <th scope="row">{{ $data->created_at }}</th>
					            <th scope="row">
					            	<a class="btn btn-primary" href="{{ route('items.edit',$data->id) }}">Edit</a>
					            	<form action="{{ route('items.destroy', $data->id) }}" method="post" style="display: inline;">
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
        
    </div>
</div>
@endsection

@section('scripts')

@endsection