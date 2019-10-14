@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-black-800">Role Management</h1>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
        @endcan
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover table-borderless">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Primary</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
                    @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $role->slug }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a class="btn btn-sm btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                            @can('role-edit')
                                <a class="btn btn-sm btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                            @endcan
                            @can('role-delete')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="post" style="display:contents;" onclick="return confirm('Are you sure for delete this?')" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
                {!! $roles->render() !!}

            </div>
        </div>    
    </div>
</div>
@endsection