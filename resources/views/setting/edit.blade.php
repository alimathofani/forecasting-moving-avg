@extends('layouts.app')



@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pengaturan</h1>
    </div>
    <div class="row justify-content-center">
        
        <div class="col-md-11">
            <div class="card shadow">
                <div class="card-body">
					<form action="{{ route('settings.update', $setting->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" disabled name="name" id="name" value="{{ $setting->name}}">
                        </div>
                        <div class="form-group">
							<label for="status">Status</label>
                            <div class="form-check pl-0">
                                <input type="checkbox" class="form-control" @if($setting->status) checked @endif data-toggle="toggle" data-on="ON" data-off="OFF" data-onstyle="info" data-offstyle="secondary" name="status">
                            </div>
                        </div>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
@endsection