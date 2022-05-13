@extends('layouts.main')

@section('title')
Daftar Pembelian
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Daftar Pembelian</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm()" class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i> Tambah Transaksi</button>

                @empty(! session('id_pembelian'))
                    <a href="{{ route('pembelian_detail.index') }}" class="btn btn-flat btn-info btn-sm mx-2 my-3"><i class="fa fa-pencil"></i> Transaksi Aktif</a>
                @endempty
                    
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-pembelian">
                    <thead>
                        <th width="6%">No</th>
                        <th>Tanggal</th>
                        <th width="20%">Nama Supplier</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Diskon</th>
                        <th>Total Bayar</th>
                        <th width="12%">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts')
    <script>
        let table, table1;

        $(function () {
            table = $('.table-pembelian').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('pembelian.data') }}',
                },
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'tanggal'},
                   {data:'supplier'},
                   {data:'total_item'},
                   {data:'total_harga'},
                   {data:'diskon'},
                   {data:'bayar'},
                   {data:'aksi', searchable: false, sortable: false},
                ]
            });
            
            $('.table-supplier').DataTable();
            table1 = $('.table-detail').DataTable({
                processing: true,
                bSort: false,
                dom: 'Brt',
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'barcode'},
                   {data:'nama_produk'},
                   {data:'harga_beli'},
                   {data:'jumlah'},
                   {data:'subtotal'},
                ]
            })
        }); 

        function addForm(url) {
            $('#modal-supplier').modal('show')
            $('#modal-supplier .modal-title').text('Pilih Supplier');

            // $('#modal-form form')[0].reset();
            // $('#modal-form form').attr('action', url);
            // $('#modal-form [name=_method]').val('post');
            // $('#modal-form [name=nama]').focus();
        }
        
        function showDetail(url) {
            $('#modal-detail').modal('show');

            table1.ajax.url(url);
            table1.ajax.reload();
        }

        function deleteForm(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Tidak bisa menghapus data',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#e80c29'
                        })                       
                        return;
                    });
            }
        }
    </script>
@endpush