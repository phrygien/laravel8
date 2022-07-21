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
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#AddAcademiqueModal">
            Ajouter Academique
          </button>
        <div class="card">
            <div class="card-header">Utilisateur
            </div>
            <div class="card-body">
                <table id="example" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>Notes</th>
                            <th>Responsable</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>Notes</th>
                            <th>Responsable</th>
                            <th width="280px">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="AddAcademiqueModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Creation Academique</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul id="save_errorList"></ul>
            <form class="row g-3" id="AddAcademiqueForm" method="POST" enctype="multipart/form-data">
                
                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Nom</label>
                  <input type="text" name="name" id="name" class="form-control" id="inputEmail4">
                </div>

                <div class="col-md-6">
                  <label for="inputPassword4" class="form-label">Code</label>
                  <input type="text" name="code" id="code" class="form-control" id="inputPassword4">
                </div>

                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Telephone</label>
                    <input type="text" name="telephone" id="telephone" class="form-control" id="inputEmail4">
                </div>

                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" id="inputPassword4">
                </div>

                <div class="col-12">
                  <label for="inputAddress" class="form-label">Logo</label>
                  <input type="file" name="logo" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="col-12">
                  <label for="inputAddress2" class="form-label">Ville</label>
                  <input type="text" name="ville" id="ville" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                </div>
                <div class="col-md-6">
                  <label for="inputCity" class="form-label">Adresse</label>
                  <input type="text" name="adresse" id="adresse" class="form-control" id="inputCity">
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Notes</label>
                    <input type="text" name="notes" id="notes" class="form-control" id="inputCity">
                  </div>
                <div class="col-md-12">
                    <label for="inputCity" class="form-label">Responsable</label>
                    <input type="text" name="responsable" id="responsable" class="form-control" id="inputCity">
                  </div>
                <div class="col-md-12">
                  <label for="inputState" class="form-label">Status</label>
                  <select id="inputState" name="status" class="form-select">
                    <option selected>Choisir...</option>
                    <option id="1">Ouvert</option>
                    <option id="0">Fermer</option>
                  </select>
                </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function () {
    $('#example').DataTable();

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

fetchAcademique();
// fetch academique
function fetchAcademique()
{
    $.ajax({
        type: "GET",
        url: "/fetch-academique",
        dataType: "json",
        success: function (response) {
            //console.log(response.academique);
            $('tbody').html("");
            $.each(response.academique, function (key, item) { 
                 $('tbody').append('<tr>\
                 <td>'+item.code+'</td>\
                 <td>'+item.name+'</td>\
                 <td>'+item.telephone+'</td>\
                 <td>'+item.email+'</td>\ 
                 <td><img src="uploads/logos/'+item.logo+'" width="35px" height="35px"></td>\ 
                 <td>'+item.ville+'</td>\
                 <td>'+item.adresse+'</td>\ 
                 <td>'+item.notes+'</td>\ 
                 <td>'+item.responsable+'</td>\ 
                 <td><button class="btn btn-primary btn-sm">Editer</button> <button class="btn btn-danger btn-sm">Supprimer</button></td>\ 
                </tr>');

            });
        }
    });
}

// add academique
$(document).on('submit','#AddAcademiqueForm', function(e){
    e.preventDefault();
    let formData = new FormData($('#AddAcademiqueForm')[0]);

    $.ajax({
        type: "POST",
        url: "academique",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if(response.status == 400)
            {
                $('#save_errorList').html();
                $('#save_errorList').removeClass('d-none');
                $.each(response.errors, function (key, err_value) { 
                     $('#save_errorList').append('<li class="text-danger">'+err_value+'</li>');
                });
            }
            else if(response.status == 200)
            {
                $('#save_errorList').html("");
                $('#save_errorList').addClass('d-none');

                $('#AddAcademiqueForm').find('input').val('');
                $('#AddAcademiqueForm').modal('hide');

                alertify.alert(response.message).set({'pinnable': false, 'modal':true});
            }
        }
    });
});

});
</script>
@endsection