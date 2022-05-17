@extends('layouts.main')

@section('title')
Pengaturan Toko
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')

<div class="row mx-3">
    <div class="col-md-8 p-3 mb-3" style="background-color: white">
        <div class="box">
            <form action="{{ route('setting.update') }}" method="post" class="form-setting" data-toggle="validator"
                enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group row">
                        <label for="Nama_Perusahaan" class="col-sm-3 control-label">Nama Perusahaan</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_perusahaan" class="form-control" id="Nama_Perusahaan" required
                                autofocus>
                            <span class="help-block with-errors"></span>
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
                            <input type="text" name="telepon" class="form-control" id="No_Telepon" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Logo_Perusahaan" class="col-sm-3 control-label">Logo Perusahaan</label>
                        <div class="col-sm-5">
                            <input type="file" name="path_logo" class="form-control" id="Logo_Perusahaan">
                            <span class="help-block with-errors"></span>
                            <div class="tampil-logo"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tipe_nota" class="col-sm-3 control-label">Tipe Nota</label>
                        <div class="col-sm-4">
                            <select name="tipe_nota" class="form-control" id="tipe_nota" required>
                                <option value="1">Nota Kecil</option>
                                <option value="2">Nota Besar</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Barcode" class="col-sm-3 control-label">Barcode</label>
                        <div class="col-sm-9">
                            <input type="text" name="barcode" class="form-control" id="Barcode" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-circle-check"></i>
                        Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
