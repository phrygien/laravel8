@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('users.index')}}">Utilisateurs</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Voir</li>
                </ol>
              </nav>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{asset('avatar/user.png')}}" style="width: 100%" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="lead">
                            <strong>Name:</strong>
                            {{ $user->name }}
                        </div>
                        <div class="lead">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                        <div class="lead">
                            <strong>Password:</strong>
                            ********
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card" hidden>
            <div class="card-header">User
                @can('role-create')
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                <div class="lead">
                    <strong>Name:</strong>
                    {{ $user->name }}
                </div>
                <div class="lead">
                    <strong>Email:</strong>
                    {{ $user->email }}
                </div>
                <div class="lead">
                    <strong>Password:</strong>
                    ********
                </div>
            </div>
        </div>
    </div>
</div>
@endsection