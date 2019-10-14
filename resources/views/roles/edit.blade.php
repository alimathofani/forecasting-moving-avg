@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-black-800">Edit Role</h1>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name User" value="{{ $role->name }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="permission">Permission</label>
                                <div class="row">
                                    @foreach($permissions as $key => $permission)
                                    <div class="col-sm-4">
                                        <div class="card border-info mb-4">
                                            <div class="card-header">
                                                {{ $key }}
                                            </div>
                                            <div class="card-body">
                                            @foreach ($permission as $value)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $value->slug }}" id="defaultCheck-{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }} name="permission[]">
                                                    <label class="form-check-label" for="defaultCheck-{{ $value->id }}">
                                                    {{ $value->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection