@extends('layouts.main')

@section('title')
Daftar Pembelian
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Daftar Pembelian</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm()" class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i
                        class="fa fa-plus-circle"></i> Tambah Transaksi</button>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
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
@endsection

@push('scripts')
    <script>
        let table;

        $(function () {
            table = $('.table').DataTable({});
        }); 

        function addForm(url) {
            $('#modal-supplier').modal('show')
            $('#modal-supplier .modal-title').text('Pilih Supplier');
        }
        
        function editForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Supplier');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama]').val(response.nama);
                    $('#modal-form [name=alamat]').val(response.alamat);
                    $('#modal-form [name=telepon]').val(response.telepon);
                })
                .fail((errors) => {
                    alert('Gagal mengubah data!');
                    return;
                });
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