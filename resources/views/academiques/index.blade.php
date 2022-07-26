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
          <button type="button" class="btn btn-success mb-3">
            Export CSV
          </button>
        <div class="card">
            <div class="card-header">Utilisateur
            </div>
            <div class="card-body" id="show_all_employees">
              <h1 class="text-center text-secondary my-5">Chargement...</h1>
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
            <div id="save_errorList" class="alert alert-warning d-none"></div>
            <form class="row g-3" id="add_employee_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">Nom</label>
                  <input type="text" name="name" class="form-control" id="inputEmail4">
                  <span class="text-danger error-text name_error"></span>
                </div>

                <div class="col-md-6">
                  <label for="inputPassword4" class="form-label">Code</label>
                  <input type="text" name="code" class="form-control" id="inputPassword4">
                  <span class="text-danger error-text code_error"></span>
                </div>

                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Telephone</label>
                    <input type="text" name="telephone" class="form-control" id="inputEmail4">
                </div>

                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="inputPassword4">
                </div>

                <div class="col-12">
                  <label for="inputAddress" class="form-label">Logo</label>
                  <input type="file" name="logo" class="form-control" placeholder="1234 Main St">
                </div>
                <div class="col-12">
                  <label for="inputAddress2" class="form-label">Ville</label>
                  <input type="text" name="ville" class="form-control" id="inputAddress2" placeholder="">
                </div>
                <div class="col-md-6">
                  <label for="inputCity" class="form-label">Adresse</label>
                  <input type="text" name="adresse" class="form-control" id="inputCity">
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Notes</label>
                    <input type="text" name="notes" class="form-control" id="inputCity">
                  </div>
                <div class="col-md-12">
                    <label for="inputCity" class="form-label">Responsable</label>
                    <input type="text" name="responsable" class="form-control" id="inputCity">
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
          <button type="submit" id="edit_employee_btn" class="btn btn-primary">Enregistrer</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  {{-- edit academique modal start --}}
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Modification Academique</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="academique_id" id="academique_id">
      <input type="hidden" name="logo" id="academique_logo">
      <div class="modal-body p-4 bg-light">
        <div class="row">
          <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Nom</label>
            <input type="text" name="name" id="name" class="form-control">
          </div>

          <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Code</label>
            <input type="text" name="code" id="code" class="form-control">
          </div>

          <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Telephone</label>
              <input type="text" name="telephone" id="telephone" class="form-control">
          </div>

          <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control">
          </div>

          <div class="col-12">
            <label for="inputAddress" class="form-label">Logo</label>
            <input type="file" name="logo" class="form-control" placeholder="1234 Main St">
          </div>
          
          <div class="col-12">
            <label for="inputAddress2" class="form-label">Ville</label>
            <input type="text" name="ville" id="ville" class="form-control" placeholder="">
          </div>
          <div class="col-md-6">
            <label for="inputCity" class="form-label">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="form-control">
          </div>
          <div class="col-md-6">
              <label for="inputCity" class="form-label">Notes</label>
              <input type="text" name="notes" id="notes" class="form-control">
            </div>
          <div class="col-md-12">
              <label for="inputCity" class="form-label">Responsable</label>
              <input type="text" name="responsable" id="responsable" class="form-control">
            </div>
          <div class="col-md-12">
            <label for="inputState" class="form-label">Status <span class="bage bg-info" id="status_actuele"></span></label>
            <select id="inputState" name="status" class="form-select">
              <option selected id="old_selected"></option>
              <option id="1">Ouvert</option>
              <option id="0">Fermer</option>
            </select>
          </div>
        </div>
        <div class="mt-2" id="avatar">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" id="edit_employee_btn" class="btn btn-success">Enregistrer Modification</button>
      </div>
    </form>
  </div>
</div>
</div>
{{-- edit employee modal end --}}
<script>
    $(document).ready(function () {
    $('#example').DataTable();


});
</script>
<script>
  $(function() {

    // add new academique
    $("#add_employee_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_employee_btn").text('Enregistrement...');
      $.ajax({
        url: '{{ route('store_academique') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if(response.status == 400){
            $('#save_errorList').html("");
            $('#save_errorList').removeClass('d-none');
            $.each(response.errors, function (key, err_value) { 
               $('#save_errorList').append('<li>'+err_value+'</li>');
            });
          }
          else if (response.status == 200) {
            Swal.fire(
              'Added!',
              'Academique Added Successfully!',
              'success'
            )
            fetchAllEmployees();

            $("#add_employee_btn").text('Add Academique');
            $("#add_employee_form")[0].reset();
            $("#AddAcademiqueModal").modal('hide');
          }
        }
      });
    });

    // edit employee ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: '{{ route('edit_academique') }}',
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#name").val(response.name);
          $("#code").val(response.code);
          $("#email").val(response.email);
          $("#telephone").val(response.telephone);
          $("#ville").val(response.ville);
          $("#adresse").val(response.adresse);
          $("#notes").val(response.notes);
          $("#responsable").val(response.responsable);
          $("#old_selected").val(response.status);
          $("#status_actuele").val(response.status);
          $("#avatar").html(
            `<img src="storage/logos/${response.logo}" width="100" class="img-fluid img-thumbnail">`);
          $("#academique_id").val(response.id);
          $("#academique_logo").val(response.logo);
        }
      });
    });

    // update employee ajax request
    $("#edit_employee_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#edit_employee_btn").text('Mise a jour...');
      $.ajax({
        url: '{{ route('update_academique') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            Swal.fire(
              'Updated!',
              'Academique Updated Successfully!',
              'success'
            )
            fetchAllEmployees();
          }
          $("#edit_employee_btn").text('Update Academique');
          $("#edit_employee_form")[0].reset();
          $("#editEmployeeModal").modal('hide');
        }
      });
    });

    // delete employee ajax request
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimez-le !'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '{{ route('delete_academique') }}',
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              Swal.fire(
                'Supprimé !',
                'Votre fichier a été supprimé.',
                'success'
              )
              fetchAllEmployees();
            }
          });
        }
      })
    });

    // fetch all employees ajax request
    fetchAllEmployees();

    function fetchAllEmployees() {
      $.ajax({
        url: '{{ route('fetchAll_academique') }}',
        method: 'get',
        success: function(response) {
          $("#show_all_employees").html(response);
          $("table").DataTable({
            order: [0, 'desc']
          });
        }
      });
    }
  });
</script>
@endsection