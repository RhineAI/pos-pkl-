@extends('layouts.main')

@section('title')
Transaksi Penjualan
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Transaksi Penjualan</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
    <div class="col-md-12 my-3">
        <div class="box">
            <div class="box-body table-responsive">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label for="Barcode" class="col-md-2">Barcode</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="barcode" id="Barcode">
                                    <span class="input-group-btn">
                                        <button onclick="TampilProduk()" class="btn btn-primary btn-flat"
                                            type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Jumlah" class="col-md-2">Jumlah</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="" id="Jumlah">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Satuan" class="col-md-2">Satuan</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="" id="Satuan">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <button onclick="" class="btn btn-sm btn-flat btn-primary btn-flat"><i
                                    class="fa fa-plus-circle"></i>
                                Tambah</button>&nbsp;&nbsp;&nbsp;

                            <button onclick="" class="btn btn-sm btn-flat btn-warning btn-flat"><i
                                    class="fa fa-hand"></i>
                                Simpan</button>&nbsp;&nbsp;&nbsp;

                            <button onclick="TampilSimpan()" class="btn btn-sm btn-flat btn-default btn-flat"><i
                                    class="fa fa-list"></i>
                                List Simpan</button>&nbsp;&nbsp;&nbsp;

                            <button onclick="TampilBayar()" class="btn btn-sm btn-flat btn-success btn-flat"><i
                                    class="fa fa-money-bill"></i>
                                Bayar</button>&nbsp;&nbsp;&nbsp;

                            <button onclick="addForm()" class="btn btn-sm btn-flat btn-info btn-flat"><i
                                    class="fa fa-file"></i>
                                Transaksi Baru</button>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div style="display: flex; justify-content: end;">
                            <label for="" class="mx-3 mt-2">Total Bayar</label>
                        </div>
                        <p style="font-size: 40px; display: flex; justify-content: end;" class="mx-3"><b>Rp. </b><b id="totalPrice">
                                0</b></p>
                        <input type="hidden" id="total_bayar">
                    </div>

                </div>

                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="6%">No</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Diskon</th>
                        <th>Total Harga</th>
                        <th width="%">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('penjualan.produk')
@includeIf('penjualan.bayar')
@includeIf('penjualan.simpan')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({});
    });

    function TampilProduk() {
        $('#modal-produk').modal('show')
        $('#modal-produk .modal-title').text('Pilih Produk');
    }

    function TampilBayar() {
        $('#modal-bayar').modal('show')
        $('#modal-bayar .modal-title').text('Form Bayar')
    }

    function TampilSimpan() {
        $('#modal-simpan').modal('show')
        $('#modal-simpan .modal-title').text('Daftar Transaksi Disimpan')
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