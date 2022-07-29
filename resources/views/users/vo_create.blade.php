@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('users.index')}}">Utilisateurs</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Creation utilisateur</li>
                </ol>
              </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="justify-content-center mt-3">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nom et prenom</label>
                            {!! Form::text('name', null, array('placeholder' => '','class' => 'form-control')) !!}
                          </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            {!! Form::text('email', null, array('placeholder' => '','type' => 'email', 'class' => 'form-control')) !!}
                          </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Mot de passe</label>
                            {!! Form::password('password', array('placeholder' => '','class' => 'form-control')) !!}
                          </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Confirmer mot de passe</label>
                            {!! Form::password('password_confirmation', array('placeholder' => '','class' => 'form-control')) !!}
                          </div>
                    </div>


                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Roles</label>
                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                          </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection