@extends('layouts.main')

@section('title')
Pengaturan
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
<div>
    <section class="content">
        <div class="row mx-3">
            <div class="col-md-7" style="background-color: white">
                <div class="box">
                    <div class="box-body mx-3 my-3">
                        <form action="" method="post">
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-3 col-form-label">Nama Toko</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputName">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAddress" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputAddress">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputTelp" class="col-sm-3 col-form-label">No. Telp</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputTelp">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="formFile" class="col-sm-3 col-form-label">Logo</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="file" id="formFileLg">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="">
                                    <img src="/images/img.jpg" width="100" style="border-radius: 50%" alt="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPB" class="col-sm-3 col-form-label">Prefix Barcode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputPB">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-info" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection