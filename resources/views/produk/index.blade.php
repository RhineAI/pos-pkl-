@extends('layouts.main')

@section('title')
Data Produk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Data Produk</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addData('{{ route('produk.store') }}')"
                    class="btn btn-sm btn-flat btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="7%">No</th>
                        <th>Barcode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th width="4%">Satuan</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th>Stok</th>
                        <th>Total</th>
                        <th width="7%">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('produk.form')
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
                    url: '{{ route('produk.data') }}',
                },          
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'barcode'},
                   {data:'nama_produk'},
                   {data:'nama_kategori'},
                   {data:'nama_satuan'},
                   {data:'harga_beli'},
                   {data:'harga_jual'},
                   {data:'diskon'},
                   {data:'stok'},
                   {data:'total'},
                   {data:'ud', searchable: false, sortable: false},
                ]
            });

            $('#modal-form').validator().on('submit', function (e) {
                if (! e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            // alert('berhasil');
                            alert(
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Data Produk berhasil ditambahkan',
                                    icon: 'success',
                                    confirmButtonText: 'Lanjut'
                                })
                            );
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            alert(
                                Swal.fire({
                                    title:'Error!',
                                    text: 'Data Produk gagal ditambahkan',
                                    icon: 'error',
                                    confirmButtonText: 'Kembali'
                                })
                            );
                            table.ajax.reload();
            
                            return;
                        });
                }
            });
        }); 

        function addData(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_produk]').focus();
        }
        
        function editData(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_produk]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama_produk]').val(response.nama_produk);
                    $('#modal-form [name=id_kategori]').val(response.id_kategori);
                    $('#modal-form [name=id_satuan]').val(response.id_satuan);
                    $('#modal-form [name=harga_beli]').val(response.harga_beli);
                    $('#modal-form [name=harga_jual]').val(response.harga_jual);
                    $('#modal-form [name=diskon]').val(response.diskon);
                    $('#modal-form [name=stok]').val(response.stok);
                    
                })
                .fail((errors) => {
                    alert(
                        Swal.fire({
                            title: 'Error!',
                            text: 'Ada yang salah keknya nich?',
                            icon: 'error',
                            confirmButtonText: 'Dahlah males'
                        })
                    );
                    return;
                });
        }

        function deleteForm(url) {
            $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'delete'
            })
            Swal.fire({
                title: 'Hapus data produk yang dipilih?',               
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Iya',                
                })
                .then((response) => {
                /* Read more about isConfirmed, isDenied below */
                if (response.isConfirmed) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Data Produk berhasil dihapus',
                        icon: 'success',
                        confirmButtonText: 'Lanjut'
                    })
                    table.ajax.reload();
                }
            });  
        }
    </script>
@endpush