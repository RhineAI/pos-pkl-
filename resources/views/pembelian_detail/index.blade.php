@extends('layouts.main')

@section('title')
Transaksi Pembelian
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
        color: grey;
    }
    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }
    .table-pembelian tbody tr:last-child {
        display: none;
    }
    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
    #simpanTransaksi {
        float: right;
        margin-top: 15px;
    }
</style>
@endpush

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Transaksi Pembelian</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
                <table class="my-3">
                    <tr>
                        <td>Supplier</td>
                        <td>: {{ $supplier->nama }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $supplier->alamat }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $supplier->telepon }}</td>
                    </tr>
                </table>
            </div>

<<<<<<< HEAD
            <div class="box-body">
                    
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                <span class="input-group-btn">
                                    <button onclick="TampilProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
=======
            <div class="box-body table-responsive">

                <div class="form-group row">
                    <label for="barcode" class="col-lg-2">Kode Produk</label>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="barcode" id="barcode">
                            <span class="input-group-btn">
                                <button onclick="TampilProduk()" class="btn btn-primary btn-flat" type="button"><i
                                        class="fa fa-search"></i></button>
                            </span>
>>>>>>> 183abb61be4bbd732a6392952cf9f02bb7ca8c26
                        </div>
                    </div>
                </form>

                <table class="table table-stiped table-bordered table-pembelian">
                    <thead>
                        <th width="5%">No</th>
                        <th>Barcode</th>
                        <th width="18%">Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Subtotal</th>
                        <th width="9%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="mt-5"></div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-default mb-3">RP. 0</div>
                        <div class="tampil-terbilang">Nol Rupiah</div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                            @csrf
                            <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer mb-3" id="simpanTransaksi">
                <button name="simpanTransaksi" type="submit" class="btn btn-primary btn-sm btn-flat btn-simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
            </div>

        </div>
    </div>
</div>

@includeIf('pembelian_detail.produk')
@endsection

@push('scripts')
<script>
    let table, table2;

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-pembelian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            stripeClasses: false,
            ajax: {
                url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'barcode'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false,
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
        });

        table2 = $('.table-produk').DataTable();
        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());

            if (jumlah < 1) {
                $(this).val(1);
                alert(
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Tentukan Jumlahnya !!',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#e80c29'
                    })                       
                );
                return;
            }
            if (jumlah > 10000) {
                $(this).val(10000);
                alert(
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Jumlahnya Tidak Boleh Lebih dari 10k !!',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#e80c29'
                    })                       
                );
                return;
            }
        $(function () {
            table = $('.table').DataTable({});
        }); 

        function TampilProduk() {
            $('#modal-produk').modal('show')
            $('#modal-produk .modal-title').text('Pilih Produk');
        }
        
        function editForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Supplier');

            $.post(`{{ url('/pembelian_detail') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    });
                })
                .fail(errors => {
                    alert(
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'gada diskon neh??',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#e80c29'
                    })                       
                );
                    return;
                });
        });

        $(document).on('input', '#diskon', function() {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        $('.btn-simpan').on('click', function() {
            $('.form-pembelian').submit();
        });

    });

    function TampilProduk() {
        $('#modal-produk').modal('show');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
        $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        hideProduk();
        tambahProduk();
    }

    function tambahProduk() {
        $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
            .done(response => {
                $('#kode_produk').focus();
                table.ajax.reload(() => loadForm($('#diskon').val()));
            })
            .fail(errors => {
                alert(
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Gagal simpan data',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#e80c29'
                    })                       
                );
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
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    alert(
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Tidak bisa menghapus data',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#e80c29'
                    })                       
                );
                    return;
                });
        }
    }

    function loadForm(diskon = 0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());
        $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#bayarrp').val('Rp. '+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);
            })
            .fail(errors => {
                alert(
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Tidak dapat menampilkan data',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#e80c29'
                    })                       
                );;
                return;
            })
    }
</script>
@endpush