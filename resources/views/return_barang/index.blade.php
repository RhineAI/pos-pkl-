@extends('layouts.main')

@section('title')
Data Kategori Produk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="6%">No</th>
                        <th width="9%">Tanggal</th>
                        <th width="12%">Invoice</th>
                        <th width="12%" class="text-center">Produk</th>
                        <th width="13%" class="text-center">Barcode</th>
                        <th width="13%" class="text-center">Jumlah Awal</th>
                        <th width="13%" class="text-center">Jumlah Diretur</th>
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
            table = $('.table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('return_barang.data') }}',
                },
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'tanggal'},
                   {data:'invoice'},
                   {data:'nama_produk'},
                   {data:'barcode'},
                   {data:'jumlah_awal'},
                   {data:'jumlah_retur'},
                ]
            });

        })

    </script>
@endpush