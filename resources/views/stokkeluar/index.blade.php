@extends('layouts.main')

@section('title')
Data Stok Keluar
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Stok Keluar</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm()" class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i
                        class="fa fa-plus-circle"></i>Tambah</button>
            </div>

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
@includeIf('stokkeluar.tambah')
@endsection

@push('scripts')
    <script>
        let table;

        $(function () {
            table = $('.table').DataTable({});
        }); 

        function addForm(url) {
            $('#modal-tambah').modal('show')
            $('#modal-tambah .modal-title').text('Tambah Stok Keluar');
        }
        

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    alert(
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Supplier berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        })                       
                    );
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert(
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Supplier gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                    );
                    return;
                });
            }
        }
    </script>
@endpush