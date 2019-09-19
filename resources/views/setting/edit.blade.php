@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Setting</div>

                <div class="card-body">
					<form action="{{ route('settings.update', $setting->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="value">Value</label>
							<input type="text" class="form-control" name="value" id="value" value="{{ $setting->value}}">
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