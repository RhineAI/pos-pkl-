@extends('layouts.main')

@section('title')
Pengaturan
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')

        <div class="row mx-3">
            <div class="col-md-7" style="background-color: white">
                <div class="box">
                    <form action="{{ route('settings.update') }}" method="post" data-toogle="validator" enctype="multipart/form-data">
                        @csrf 
                        
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="storeName" class="col-sm-3 col-lg-offset-1 col-form-label">Nama Toko</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="storeName name="storeName required autofocus>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-lg-offset-1 col-form-label">Alamat</label>
                                <div class="col-lg-9">
                                    <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control" required></textarea>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telp" class="col-sm-3 col-lg-offset-1 col-form-label">No. Telp</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="telp" name="telp">
                                    <span class="help-block with-errors"></span>
                                </div> 
                            </div>

                            <div class="form-group row">
                                <label for="logo" class="col-sm-3 col-lg-offset-1 col-form-label">Logo</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="file" id="logo" name="logo" >
                                    <span class="help-block with-errors"></span>
                                    
                                    <div class="tampil-logo">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="">
                                    <img src="/images/img.jpg" width="100" style="border-radius: 50%" alt="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPB" class="col-sm-3 col-lg-offset-1 col-form-label">Prefix Barcode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputPB" name="inputPB">
                                </div>
                            </div>   
                        </div>
                        <br>

                        <div class="box-footer">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>

@endsection