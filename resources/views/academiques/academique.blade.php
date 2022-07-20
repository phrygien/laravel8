@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Etablissements</li>
                </ol>
              </nav>
        </div>
    </div>

    <div class="justify-content-center mt-3">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('save.academique')}}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Academique Name</label>
                                <input type="text" name="name" class="form-control"  placeholder="">
                                <span class="text-danger error-text name_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" placeholder="">
                                <span class="text-danger error-text code_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Telephone</label>
                                <input type="text" name="telephone" class="form-control" placeholder="">
                                <span class="text-danger error-text telephone_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" placeholder="">
                                <span class="text-danger error-text email_error"></span>
                            </div>

                              <div class="form-group">
                                  <label for="">Logo</label>
                                  <input type="file" name="logo" class="form-control">
                                  <span class="text-danger error-text logo_error"></span>
                              </div>
                              <div class="img-holder"></div>

                              <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Ville</label>
                                <input type="text" name="ville" class="form-control" placeholder="">
                                <span class="text-danger error-text ville_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Adresse</label>
                                <input type="text" name="adresse" class="form-control" placeholder="">
                                <span class="text-danger error-text adresse_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Notes</label>
                                <input type="text" name="notes" class="form-control" placeholder="">
                                <span class="text-danger error-text notes_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Responsable</label>
                                <input type="text" name="responsable" class="form-control" placeholder="">
                                <span class="text-danger error-text responsable_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Status</label>
                                <input type="text" name="status" class="form-control" placeholder="">
                                <span class="text-danger error-text status_error"></span>
                            </div>

                              
                              <button type="submit" class="btn btn-primary">Save Product</button>
                          </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body" id="AllAcademiques">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(function(){
        $('#form').on('submit', function(e){
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
                        $.each(data.error, function(prefix,val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $(form)[0].reset();
                        // alert(data.msg);
                        fetchAllAcademiques();
                    }
                }
            });
        });
        //Reset input file
        $('input[type="file"][name="logo"]').val('');
        //Image preview
        $('input[type="file"][name="logo"]').on('change', function(){
            var img_path = $(this)[0].value;
            var img_holder = $('.img-holder');
            var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
            if(extension == 'jpeg' || extension == 'jpg' || extension == 'png'){
                 if(typeof(FileReader) != 'undefined'){
                      img_holder.empty();
                      var reader = new FileReader();
                      reader.onload = function(e){
                          $('<img/>',{'src':e.target.result,'class':'img-fluid','style':'max-width:100px;margin-bottom:10px;'}).appendTo(img_holder);
                      }
                      img_holder.show();
                      reader.readAsDataURL($(this)[0].files[0]);
                 }else{
                     $(img_holder).html('This browser does not support FileReader');
                 }
            }else{
                $(img_holder).empty();
            }
        });
        //Fetch all academiques
        fetchAllAcademiques();
        function fetchAllAcademiques(){
            $.get('{{route("fetch.academiques")}}',{}, function(data){
                 $('#AllAcademiques').html(data.result);
            },'json');
        }

    })
</script>
@endsection