@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-black-800">User Management</h1>
        @can('user-create')
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
        </div>
        @endcan
    </div>
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover table-borderless">
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Roles</th>
                    <th scope="col">Action</th>
                    </tr>
                    @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                        @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                            @can('user-edit')
                                <a class="btn btn-sm btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                            @endcan
                            @can('user-delete')
                                <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display:contents;" onclick="return confirm('Are you sure for delete this?')" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
                {!! $data->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection