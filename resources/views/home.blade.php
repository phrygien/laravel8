@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-card"><span class="badge bg-info">14</span> Nouveau demande</p>
                            <table class="table table-bordered">
                                <thead>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Ville</th>
                                    <th>Adresse</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#123-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                    </tr>

                                    <tr>
                                        <td>#678-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                    </tr>

                                    <tr>
                                        <td>#908-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                    </tr>

                                    <tr>
                                        <td>#660-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <p class="text-card"><span class="badge bg-secondary">1400</span> Academique Status</p>
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Ville</th>
                                    <th>Adresse</th>
                                    <th>Etat</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#123-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                        <th><span for="" class="badge bg-success">Enable</span></th>
                                    </tr>

                                    <tr class="alert alert-warning">
                                        <td>#678-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                        <th><span for="" class="badge bg-warning">2 Mois reste</span></th>
                                    </tr>

                                    <tr class="alert alert-danger">
                                        <td>#908-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                        <th><span for="" class="badge bg-danger">Disabled</span></th>
                                    </tr>

                                    <tr>
                                        <td>#660-BG</td>
                                        <td>Academique One</td>
                                        <td>Manakara</td>
                                        <td>Fokontany -Anranovato-Oeust</td>
                                        <th><span for="" class="badge bg-success">Enable</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2 text-center" >
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Roles <span class="badge bg-success">12</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Utilisateur <span class="badge bg-warning">30</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Permissions <span class="badge bg-info">12</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Etablissement <span class="badge bg-primary">1400</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Enseignant <span class="badge bg-danger">120</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Cours <span class="badge bg-secondary">34</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Etudiant <span class="badge bg-dark">34</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-card">Admission <span class="badge bg-info">200</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
