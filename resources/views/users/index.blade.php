@extends('layouts.v1.app')
@section('content')
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>{{__('Utilisateur')}}</h3>
                            <p class="text-subtitle text-muted">Liste utilisateur</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('Liste')}}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                    </div>
                @endif
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('users.create')}}" class="btn rounded-pill btn-primary"><i class="bi bi-plus"></i> {{__('Ajouter nouveau')}}</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom et prenom</th>
                                        <th>Adresse email</th>
                                        <th>Roles</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $key => $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $val)
                                                    <label class="badge bg-success">{{ $val }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('users.show',$user->id) }}"><i class="bi bi-eye"></i></a>
                                            @can('user-edit')
                                                <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}"><i class="bi bi-pen"></i></a>
                                            @endcan
                                            @can('user-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('Supprimer', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
            </div>

    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

@endsection