@extends('layouts.main')

@section('title')
Data Pengguna
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Data Pengguna</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-sm btn-flat btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Posisi</th>
                            <th>Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
</div>
@endsection