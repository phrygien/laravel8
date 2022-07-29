@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
                </ol>
              </nav>
        </div>
    </div>

    <div class="justify-content-center mt-3">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <a class="btn btn-primary mb-2" href="{{ route('users.create') }}">Ajouter Nouveau</a>
        <div class="card">
            <div class="card-header">Utilisateur
            </div>
            <div class="card-body">
                <table id="example" class="table table-hover" style="width:100%">
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
                                        <label class="badge bg-dark">{{ $val }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ route('users.show',$user->id) }}">Voir</a>
                                @can('user-edit')
                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Editer</a>
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
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th width="280px">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
@endsection