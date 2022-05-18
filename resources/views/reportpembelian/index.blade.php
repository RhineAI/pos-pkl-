@extends('layouts.main')

@section('title')
Laporan Pembelian
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Laporan Pembelian</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-3 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Tanggal :</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control flatpickr" autocomplete="off" name="date"
                                        id="date" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group-row">
                            <label for="" class="col-md-2 col-form-label">s/d</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control flatpickr" autocomplete="off" name="date"
                                        id="date" value="">
                                </div>
                            </div>
                            <button onclick="TampilProduk()" class="btn btn-primary btn-flat" type="button"><i
                                class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr role="row">
                                    <th width="4%" colspan="1" rowspan="2">No</th>
                                    <th colspan="3" rowspan="1">INFORMASI PEMBELIAN</th>
                                    <th colspan="3" rowspan="1">TOTAL HARGA</th> 
                                    <th colspan="2" rowspan="1">KETERANGAN</th> 
                                </tr>
                                <tr role="row">
                                    <th colspan="1">Tanggal</th>
                                    <th width="20%" colspan="1">Nama Supplier</th>
                                    <th width="20%" colspan="1">Nama Produk</th>
                                    <th width="15%" colspan="1">Harga</th>
                                    <th width="15%" colspan="1">Diskon</th>
                                    <th width="15%" colspan="1">Total Harga</th>
                                    <th colspan="1">Kasir</th>
                                    <th width="13%" colspan="1">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@includeIf('reportpenjualan.form')
@endsection

@push('scripts')
    <script>

        $(".flatpickr").flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y H:i",
        });

        let table;

        $(function () {
            table = $('.table').DataTable({});
        }); 

        // function addForm(url) {
        //     $('#modal-tambah').modal('show')
        //     $('#modal-tambah .modal-title').text('Tambah Stok Masuk');
        // }
        
        // function editForm(url) {
        //     $('#modal-form').modal('show')
        //     $('#modal-form .modal-title').text('Edit Supplier');

        //     $('#modal-form form')[0].reset();
        //     $('#modal-form form').attr('action', url);
        //     $('#modal-form [name=_method]').val('put');
        //     $('#modal-form [name=nama]').focus();

        //     $.get(url)
        //         .done((response) => {
        //             $('#modal-form [name=nama]').val(response.nama);
        //             $('#modal-form [name=alamat]').val(response.alamat);
        //             $('#modal-form [name=telepon]').val(response.telepon);
        //         })
        //         .fail((errors) => {
        //             alert('Gagal mengubah data!');
        //             return;
        //         });
        // }

        // function deleteData(url) {
        //     if (confirm('Yakin ingin menghapus data terpilih?')) {
        //     $.post(url, {
        //             '_token': $('[name=csrf-token]').attr('content'),
        //             '_method': 'delete'
        //         })
        //         .done((response) => {
        //             alert(
        //                 Swal.fire({
        //                     title: 'Sukses!',
        //                     text: 'Supplier berhasil dihapus',
        //                     icon: 'success',
        //                     confirmButtonText: 'Lanjut',
        //                     confirmButtonColor: '#28A745'
        //                 })                       
        //             );
        //             table.ajax.reload();
        //         })
        //         .fail((errors) => {
        //             alert(
        //                 Swal.fire({
        //                     title: 'Gagal!',
        //                     text: 'Supplier gagal dihapus',
        //                     icon: 'error',
        //                     confirmButtonText: 'Kembali',
        //                     confirmButtonColor: '#DC3545'
        //                 })                       
        //             );
        //             return;
        //         });
        //     }
        // }
    </script>
@endpush