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
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>0</h3>

                        <p>Total Produk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bag-shopping"></i>
                    </div>
                    <a href="/produk" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>0</h3>

                        <p>Total Transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>0</h3>

                        <p>Total Supplier</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <a href="/supplier" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>0</h3>

                        <p>Total Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <a href="/users" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
    </div><!-- /.container-fluid -->
</section>
@endsection