@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-black-800"> Show Role</h1>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label><strong>Name </strong></label>
                        <div class="form-group">
                            {{ $role->name }}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label><strong>Permissions </strong></label>
                        <div class="form-group">
                            @if(!empty($rolePermissions))
                            <div class="card-deck">
                                @foreach ($rolePermissions as $item)
                                <div class="card border-info" style="width: 18rem;">
                                    <ul class="list-group list-group-flush">
                                        @foreach($item as $v)
                                            <li class="list-group-item">{{ $v->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection