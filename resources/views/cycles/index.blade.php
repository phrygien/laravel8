@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Cycles</li>
                </ol>
              </nav>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.cycle') }}" method="post" id="add-cycle-form" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label for="exampleFormControlInput1" class="form-label">code</label>
                            <input type="text" class="form-control" name="code" id="code" placeholder="">
                            <span class="text-danger error-text code_error"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-condensed table-bordered" id="counties-table">
                        <thead>
                            <th><input type="checkbox" name="main_checkbox"><label></label></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Actions <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Supprimer Tous</button></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function(){

           //ADD NEW COUNTRY
           $('#add-cycle-form').on('submit', function(e){
               e.preventDefault();
               var form = this;
               $.ajax({
                   url:$(form).attr('action'),
                   method:$(form).attr('method'),
                   data:new FormData(form),
                   processData:false,
                   dataType:'json',
                   contentType:false,
                   beforeSend:function(){
                        $(form).find('span.error-text').text('');
                   },
                   success:function(data){
                        if(data.code == 0){
                              $.each(data.error, function(prefix, val){
                                  $(form).find('span.'+prefix+'_error').text(val[0]);
                              });
                        }else{
                            $(form)[0].reset();
                           //  alert(data.msg);
                           Swal.fire(
                                'Saved!',
                                'Cycle Saved Successfully!',
                                'success'
                                )
                           $('#counties-table').DataTable().ajax.reload(null, false);
                           //toastr.success(data.msg);
                        }
                   }
               });
           });

           //GET ALL COUNTRIES
          var table =  $('#counties-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.cycles.list') }}",
                "pageLength":10,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"Tous"]],
                columns:[
                   //  {data:'id', name:'id'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'name', name:'name'},
                    {data:'code', name:'code'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
           }).on('draw', function(){
               $('input[name="country_checkbox"]').each(function(){this.checked = false;});
               $('input[name="main_checkbox"]').prop('checked', false);
               $('button#deleteAllBtn').addClass('d-none');
           });

           $(document).on('click','#editCountryBtn', function(){
               var country_id = $(this).data('id');
               $('.editCountry').find('form')[0].reset();
               $('.editCountry').find('span.error-text').text('');
               $.post('<?= route("get.cycle.details") ?>',{country_id:country_id}, function(data){
                   //  alert(data.details.country_name);
                   $('.editCountry').find('input[name="cid"]').val(data.details.id);
                   $('.editCountry').find('input[name="country_name"]').val(data.details.country_name);
                   $('.editCountry').find('input[name="capital_city"]').val(data.details.capital_city);
                   $('.editCountry').modal('show');
               },'json');
           });


           //UPDATE COUNTRY DETAILS
           $('#update-country-form').on('submit', function(e){
               e.preventDefault();
               var form = this;
               $.ajax({
                   url:$(form).attr('action'),
                   method:$(form).attr('method'),
                   data:new FormData(form),
                   processData:false,
                   dataType:'json',
                   contentType:false,
                   beforeSend: function(){
                        $(form).find('span.error-text').text('');
                   },
                   success: function(data){
                         if(data.code == 0){
                             $.each(data.error, function(prefix, val){
                                 $(form).find('span.'+prefix+'_error').text(val[0]);
                             });
                         }else{
                             $('#counties-table').DataTable().ajax.reload(null, false);
                             $('.editCountry').modal('hide');
                             $('.editCountry').find('form')[0].reset();
                             //toastr.success(data.msg);
                             Swal.fire(
                                'Saved!',
                                'Cycle Saved Successfully!',
                                'success'
                                )
                         }
                   }
               });
           });

           //DELETE COUNTRY RECORD
           $(document).on('click','#deleteCountryBtn', function(){
               var country_id = $(this).data('id');
               var url = '<?= route("delete.cycle") ?>';

               swal.fire({
                    title:'Are you sure?',
                    html:'You want to <b>delete</b> this country',
                    showCancelButton:true,
                    showCloseButton:true,
                    cancelButtonText:'Cancel',
                    confirmButtonText:'Yes, Delete',
                    cancelButtonColor:'#d33',
                    confirmButtonColor:'#556ee6',
                    width:300,
                    allowOutsideClick:false
               }).then(function(result){
                     if(result.value){
                         $.post(url,{country_id:country_id}, function(data){
                              if(data.code == 1){
                                  $('#counties-table').DataTable().ajax.reload(null, false);
                                  toastr.success(data.msg);
                              }else{
                                  toastr.error(data.msg);
                              }
                         },'json');
                     }
               });

           });




      $(document).on('click','input[name="main_checkbox"]', function(){
             if(this.checked){
               $('input[name="country_checkbox"]').each(function(){
                   this.checked = true;
               });
             }else{
                $('input[name="country_checkbox"]').each(function(){
                    this.checked = false;
                });
             }
             toggledeleteAllBtn();
      });

      $(document).on('change','input[name="country_checkbox"]', function(){

          if( $('input[name="country_checkbox"]').length == $('input[name="country_checkbox"]:checked').length ){
              $('input[name="main_checkbox"]').prop('checked', true);
          }else{
              $('input[name="main_checkbox"]').prop('checked', false);
          }
          toggledeleteAllBtn();
      });


      function toggledeleteAllBtn(){
          if( $('input[name="country_checkbox"]:checked').length > 0 ){
              $('button#deleteAllBtn').text('Suupprimer ('+$('input[name="country_checkbox"]:checked').length+')').removeClass('d-none');
          }else{
              $('button#deleteAllBtn').addClass('d-none');
          }
      }


      $(document).on('click','button#deleteAllBtn', function(){
          var checkedCountries = [];
          $('input[name="country_checkbox"]:checked').each(function(){
              checkedCountries.push($(this).data('id'));
          });

          var url = '{{ route("delete.selected.cycles") }}';
          if(checkedCountries.length > 0){
              swal.fire({
                  title:'Are you sure?',
                  html:'You want to delete <b>('+checkedCountries.length+')</b> countries',
                  showCancelButton:true,
                  showCloseButton:true,
                  confirmButtonText:'Yes, Delete',
                  cancelButtonText:'Cancel',
                  confirmButtonColor:'#556ee6',
                  cancelButtonColor:'#d33',
                  width:300,
                  allowOutsideClick:false
              }).then(function(result){
                  if(result.value){
                      $.post(url,{cycles_id:checkedCountries},function(data){
                         if(data.code == 1){
                             $('#counties-table').DataTable().ajax.reload(null, true);
                             //toastr.success(data.msg);
                             Swal.fire(
                                'Deleted',
                                'Cycle Deleted Successfully!',
                                'success'
                                )
                         }
                      },'json');
                  }
              })
          }
      });
   



    });

</script>
@endsection