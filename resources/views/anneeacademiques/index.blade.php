@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Annee Academique</li>
                </ol>
              </nav>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="card">
                <div class="card-body">
                  <div id="save_errorList" class="alert alert-warning d-none"></div>
                      <form method="POST" id="add_annee_form">
                        <div class="row">
                        @csrf
                        <div class="col-md-4">
                          <label for="exampleFormControlInput1" class="form-label">Code</label>
                          <input type="text" class="form-control" name="code" id="code" placeholder="">
                       </div>

                        <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Date Debut</label>
                                <input type="date" class="form-control" name="date_debut" id="date_debut" placeholder="">
                        </div>

                        <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Date Fin</label>
                                <input type="date" class="form-control" name="date_fin" id="date_fin" placeholder="">
                        </div>

                        <div class="col-md-3 mt-2">
                                <button type="submit" class="btn btn-primary" id="add_employee_btn">Enregistrer</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                  
                      </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="card mt-3">
            <div class="card-body" id="show_all_annee_academique">
                <h1 class="text-center text-secondary my-5">Chargement...</h1>
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
            <div class="col-md-12">
              <label for="inputEmail4" class="form-label">Code</label>
              <input type="text" name="code" id="code" class="form-control">
            </div>
  
            <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Date Debut</label>
              <input type="date" name="date_debut" id="date_debut" class="form-control">
            </div>
  
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Date Fin</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control">
            </div>

            <div class="col-md-12">
              <label for="inputState" class="form-label">Status <span class="bage bg-info" id="status_actuele"></span></label>
              <select id="status" name="status" class="form-select">
                <option selected id="old_selected"></option>
                <option id="1">Ouvert</option>
                <option id="0">Fermer</option>
              </select>
            </div>
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

{{-- edit employee modal end --}}
<script>
    $(document).ready(function () {
    $('#tableAnnee').DataTable();


});
</script>
<script>
  $(function() {

    // add new academique
    $("#add_annee_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_employee_btn").text('Enregistrement...');
      $.ajax({
        url: '{{ route('store_annee_academique') }}',
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
              'Annee Academique Added Successfully!',
              'success'
            )
            fetchAllEmployees();

            $("#add_employee_btn").text('Enregistrer Nouveau');
            $("#add_annee_form")[0].reset();
            //$("#AddAcademiqueModal").modal('hide');
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
        url: '{{ route('fetchAll_annee_academique') }}',
        method: 'get',
        success: function(response) {
          $("#show_all_annee_academique").html(response);
          $("table").DataTable({
            order: [0, 'desc']
          });
        }
      });
    }
  });
</script>
@endsection