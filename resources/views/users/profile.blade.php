@extends('layouts.main')

@section('title')
Update Profile
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Update Profile</li>
@endsection

@section('content')

<div class="row mx-3">
    <div class="col-md-8 p-3 mb-3" style="background-color: white">
        <div class="box">
            <form action="{{ route('user.update_profile') }}" method="post" class="form-profile" data-toggle="validator"
                enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="alert alert-success alert-dismissible" style="display: none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <i class="fa fa-circle-check"></i>
                            Profile berhasil diupdate
                    </div>
                    <div class="form-group row">
                        <label for="Nama" class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" id="Nama" required
                                autofocus value="{{ $profile->name }}" maxlength="15" minlength="3">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Poto" class="col-sm-3 control-label">Foto</label>
                        <div class="col-sm-5">
                            <input type="file" name="foto" class="form-control" id="Poto"
                                onchange="preview('.tampil-foto', this.files[0])">
                            <span class="help-block with-errors"></span>
                            <div class="tampil-foto mt-3">
                                <img src="{{ asset('images/'.Auth::user()->foto) }}" width="100">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Username" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" id="Username" required
                            autofocus value="{{ $profile->username }}" maxlength="15" minlength="3">
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control" id="email" required
                            autofocus value="{{ $profile->email }}">
                        </div>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group row">
                        <label for="old_password" class="col-sm-3 control-label">Password Lama</label>
                        <div class="col-sm-9">
                            <input type="password" name="old_password" class="form-control" id="old_password"  
                            minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-3 control-label">Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="password"  
                            minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-3 control-label">Konfirmasi Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"  
                                data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-success btn-flat btn-sm"><i class="fa fa-pen-to-square"></i>
                        Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#old_password').on('keyup', function () {
            if ($(this).val() != "") $('#password, #password_confirmation').attr('required', true);
            else $('#password, #password_confirmation').attr('required', false);
        });
        $('.form-profile').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-profile').attr('action'),
                    type: $('.form-profile').attr('method'),
                    data: new FormData($('.form-profile')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    $('[name=name]').val(response.name);
                    $('[name=username]').val(response.username);
                    $('[name=email]').val(response.email);
                    $('.tampil-foto').html(`<img src="{{ url('/') }}${response.foto}" width="100">`);
                    $('.images-profile').attr('src', `{{ url('/') }}/${response.foto}`);
                    Swal.fire({
                            title: 'Sukses!',
                            text: 'Update Profile berhasil! ',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }).then(function(){
                            location.reload('/dashboard');
                        })                       
                        // return; 
                })
                .fail(errors => {
                    if (errors.status == 422) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Konfirmasi password tidak sesuai',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return; 
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Password lama tidak sesuai',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })   
                    }
                    return;
                });
            }
        });
    });
</script>
@endpush
