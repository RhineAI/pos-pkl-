@extends('layouts.main')

@section('title')
Pengaturan Toko
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pengaturan Toko</li>
@endsection

@section('content')

<div class="row mx-3">
    <div class="col-md-8 p-3 mb-3" style="background-color: white">
        <div class="box">
            <form action="{{ route('setting.update') }}" method="post" class="form-setting" data-toggle="validator"
                enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="alert alert-success alert-dismissible" style="display: none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <i class="fa fa-circle-check"></i>
                            Pengaturan Toko berhasil diupdate
                    </div>
                    <div class="form-group row">
                        <label for="Nama_Perusahaan" class="col-sm-3 control-label">Nama Perusahaan</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" id="Nama_Perusahaan" required
                                autofocus minlength="3" maxlength="15" placeholder="3-15 Characters required">
                                <p class="placeholder-glow">
                                    <span class="placeholder col-12" style="font-style: italic">3-15 Characters required</span>
                                </p>
                                @error('nama_perusahaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror              
                            {{-- <span class="help-block with-errors"></span> --}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Alamat" class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea name="alamat" class="form-control" id="Alamat" rows="3" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="No_Telepon" class="col-sm-3 control-label">No. Telepon</label>
                        <div class="col-sm-9">
                            <input type="text" name="telepon" class="form-control" id="No_Telepon" required maxlength="13" minlength="10" placeholder="10-13 Numbers required" >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Logo_Perusahaan" class="col-sm-3 control-label">Logo Perusahaan</label>
                        <div class="col-sm-5">
                            <input type="file" name="path_logo" class="form-control" id="Logo_Perusahaan"
                                onchange="preview('.tampil-logo', this.files[0])">
                            <span class="help-block with-errors"></span>
                            <div class="tampil-logo mt-3"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tipe_nota" class="col-sm-3 control-label">Tipe Nota</label>
                        <div class="col-sm-4">
                            <select name="tipe_nota" class="form-control" id="tipe_nota" required>
                                <option value="1">Nota Kecil</option>
                                {{-- <option value="2">Nota Besar</option> --}}
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-success btn-flat btn-sm"><i class="fa fa-circle-check"></i>
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
        showData();
        $('.form-setting').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-setting').attr('action'),
                    type: $('.form-setting').attr('method'),
                    data: new FormData($('.form-setting')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    showData();
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
    function showData() {
        $.get('{{ route('setting.show') }}')
            .done(response => {
                $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                $('[name=telepon]').val(response.telepon);
                $('[name=alamat]').val(response.alamat);
                $('title').text(response.nama_perusahaan + ' | Pengaturan');
                
                let words = response.nama_perusahaan.split(' ');
                let word  = '';
                words.forEach(w => {
                    word += w.charAt(0);
                });
                $('.logo-mini').text(word);
                $('.logo-lg').text(response.nama_perusahaan);
                $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="100">`);
                $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
</script>
@endpush
