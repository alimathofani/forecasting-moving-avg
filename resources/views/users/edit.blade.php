@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-black-800">Edit User</h1>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name User" value="{{ $user->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email User" value="{{ $user->email }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="password"> <strong>Password </strong></label>
                        <input id="password" type="password" class="form-control form-control-user  @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="password"> <strong>Confirm Password </strong></label>
                        <input id="password-confirm" type="password" class="form-control form-control-user" placeholder="{{ __('Confirm Password') }}"  name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="roles">Roles </label>
                        <select class="form-control" id="roles" multiple name="roles[]">
                            @foreach($roles as $key => $item)
                                <option @if (in_array($item, $userRole)) selected="selected" @endif value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection