@extends('layouts.main')

@section('title')
Update Profile
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pengaturan</li>
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
                                autofocus value="{{ $profile->name }}">
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
                            autofocus value="{{ $profile->username }}">
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
                    $('.tampil-foto').html(`<img src="{{ url('/') }}${response.foto}" width="200">`);
                    $('.images-profile').attr('src', `{{ url('/') }}/${response.foto}`);
                    $('.alert').fadeIn();
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                })
                .fail(errors => {
                    if (errors.status == 422) {
                        alert(errors.responseJSON); 
                    } else {
                        alert('Tidak dapat menyimpan data');
                    }
                    return;
                });
            }
        });
    });
</script>
{{-- <script>
    $(function () {
        showData();
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
                    // showData();
                    $('[name=name]').val(response.name);
                    $('[name=username]').val(response.username);
                    $('[name=email]').val(response.email);
                    $('.tampil-foto').html(`<img src="{{ url('/') }}${response.foto}" width="200">`);

                    $('.alert').fadeIn();
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
            }
        });
    });
    // function showData() {
    //     $.get('{{ route('setting.show') }}')
    //         .done(response => {
    //             $('[name=nama_perusahaan]').val(response.nama_perusahaan);
    //             $('[name=telepon]').val(response.telepon);
    //             $('[name=alamat]').val(response.alamat);
    //             $('title').text(response.nama_perusahaan + ' | Pengaturan');
                
    //             let words = response.nama_perusahaan.split(' ');
    //             let word  = '';
    //             words.forEach(w => {
    //                 word += w.charAt(0);
    //             });
    //             $('.logo-mini').text(word);
    //             $('.logo-lg').text(response.nama_perusahaan);
    //             $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="200">`);
    //             $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
    //         })
    //         .fail(errors => {
    //             alert('Tidak dapat menampilkan data');
    //             return;
    //         });
    // }
</script> --}}
@endpush
