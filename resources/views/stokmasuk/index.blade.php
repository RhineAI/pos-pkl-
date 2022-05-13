@extends('layouts.main')

@section('title')
Data Stok Masuk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Stok Masuk</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="6%">No</th>
                        <th>Tanggal</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Keterangan</th>
                        <th>Jumlah (Stok)</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        let table;

        $(function () {
            table = $('.table').DataTable({});
        }); 
    </script>
@endpush