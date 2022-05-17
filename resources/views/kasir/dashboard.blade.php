@extends('layouts.main')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="col-12" style="background-color: white">
            <div class="box">
                <div class="box-body text-center">
                    <br> 
                    <h1>Selamat Datang</h1>
                    <h5>Anda login sebagai KASIR</h5>
                    <br> 
                    <a href="{{ route('penjualan.index') }}" class="btn btn-success btn-flat btn-md">Transaksi Baru</a>
                    <br> <br>
                </div>
            </div>
        </div>
    </div>
@endsection
