@extends('layouts.v1.app')
@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Utilisateur</h3>
                <p class="text-subtitle text-muted">Creation nouveau utilisateur</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('users.index')}}">{{__('Utilisateur')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Creation utilisateur')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

        @if (\Session::has('success'))
            <div class="alert alert-danger">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif

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

    <section id="basic-horizontal-layouts">
        <div class="row match-height">
        {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="bi bi-person-circle"></i> Information personnel</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Nom et Prenom</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            {!! Form::text('name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            {!! Form::text('email', null, array('placeholder' => '','type' => 'email', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-4">
                                            <label>Academique</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                        @if(Auth::user()->is_admin ==1)
                                           <select class="form-control" name="academique_id">
                                                    @foreach($academiques as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                           </select>
                                        @else
                                            <input type="text" hidden name="academique_id" value="{{Auth::user()->academique_id}}" class="form-control">
                                        @endif
                                        </div>
                                         <input type="text" hidden name="anneeacademique_id" value="{{Auth::user()->anneeacademique_id}}" class="form-control">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="bi bi-key"></i> Roles & Mot de passe</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Mot de passe</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            {!! Form::password('password', array('placeholder' => '','class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-4">
                                            <label>Confirmer mot de passe</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            {!! Form::password('password_confirmation', array('placeholder' => '','class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-4">
                                            <label>Roles</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 d-flex justify-content-end mt-4">
                <button type="submit"
                    class="btn btn-primary me-1 mb-1">{{__('Enregistrer')}}</button>
                <button type="reset"
                    class="btn btn-light-secondary me-1 mb-1">{{__('Reset')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
</div>
@endsection