@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Master Barang</h1>
    </div>
    <div class="row justify-content-center">
        @can('item-create')
        <div class="col-md-11 ">
            <div class="card shadow mb-4">
                <div class="card-body">
					<form action="{{ route('items.store') }}" method="POST">
						@csrf
						<div class="form-group">
							<label for="name">Nama Barang</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<button type="submit" class="btn btn-primary">Create</button>
					</form>
                </div>
            </div>
        </div>
        @endcan

        <div class="col-md-11">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
                </div>
                <div class="card-body">
					<table class="table table-hover table-borderless">
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
                                    @can('item-edit')
                                    <a class="btn btn-primary" href="{{ route('items.edit',$data->id) }}">Edit</a>
                                    @endcan
                                    @can('item-delete')
					            	<form action="{{ route('items.destroy', $data->id) }}" method="post" style="display: inline;">
					            		@csrf
					            		@method('DELETE')
					            		<input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                    @endcan
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