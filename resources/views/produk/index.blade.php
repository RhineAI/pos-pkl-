@extends('layouts.main')

@section('title')
Data Semua Produk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addData('{{ route('produk.store') }}')"
                    class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah
                </button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="6%">No</th>
                        <th>Barcode</th>
                        <th width="20%">Nama Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th>Stok</th>
                        <th width="8%">Aksi</th>
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
                    // {data:'select_all', searchable: false, sortable: false},
                    {data:'DT_RowIndex', searchable: false, sortable: false},
                    {data:'barcode'},
                    {data:'nama_produk'},
                    {data:'nama_kategori'},
                    {data:'nama_satuan'},
                    {data:'harga_beli'},
                    {data:'harga_jual'},
                    {data:'diskon'},
                    {data:'stok'},
                    {data:'ud', searchable: false, sortable: false},
                ]
            });

            $('#modal-form').validator().on('submit', function (e) {
                if (! e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data Produk baru berhasil ditambahkan',
                                icon: 'success',
                                confirmButtonText: 'Lanjut',
                                confirmButtonColor: '#28A745'
                            })
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Data Produk yang diinput sudah ada',
                                icon: 'error',
                                confirmButtonText: 'Kembali',
                                confirmButtonColor: '#DC3545'
                            })
                            table.ajax.reload();
            
                            return;
                        });
                }
            });

                $('[name=select_all]').on('click', function() {
                $(':checkbox').prop('checked', this.checked);                              
            });
        }); 

        // function formatRupiah(angka, prefix){
        //     var number_string   = angka.replace(/[^,\d]/g, '').toString(),
        //     split               = number_string.split(','),
        //     sisa                = split[0].length % 3,
        //     rupiah              = split[0].substr(0, sisa),
        //     ribuan              = split[0].substr(sisa).match(/\d{3}/gi);

        //     if(ribuan){
        //         separator = sisa ? '.' : '';
        //         rupiah += separator + ribuan.join('.');
        //     }

        //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        //     return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        // }

        // function generateRupiah(elemValue) {
        //     return $(elemValue).val(formatRupiah($(elemValue).val(), 'Rp. '))
        // }

        //     $(document).on('keyup', '#harga_beli', function(e){
        //         generateRupiah(this);
        //     })
        //     $(document).on('keyup', '#harga_beli_ins', function(e){
        //         generateRupiah(this);
        //     })

        //     $(document).on('keyup', '#harga_jual', function(e){
        //         generateRupiah(this);
        //     })
        //     $(document).on('keyup', '#harga_jual_ins', function(e){
        //         generateRupiah(this);
        //         $(this).val(formatRupiah($(this).val(), 'Rp.'))
        //         $("#harga_jual_ins").val(parseInt($(this).val().split('.').join('')))
        //     })
                
            


        function addData(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Data Produk Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_produk]').focus();
        }

        // $(document).on('click', '.edit', function (event) {
        //         let nama_produk = $(this).data('produk')
        //         let nama_kategori = $(this).data('produk')
        //         let nama_satuan = $(this).data('produk')
        //         let harga_beli = $(this).data('produk')
        //         let harga_jual = $(this).data('produk')
        //         let diskon = $(this).data('produk')
        //         let stok = $(this).data('produk')
        //         let url = $(this).data('route')

        //         let data = {
        //             nama_produk: nama_produk,
        //             nama_kategori: nama_kategori,
        //             nama_satuan: nama_satuan,
        //             harga_beli: harga_beli,
        //             harga_jual: harga_jual,
        //             diskon: diskon,
        //             stok: stok,
        //             url: url
        //         }

        //         editForm(data)
        // })

        // function editForm(data) {
        //         $('#modal-form').modal('show')
        //         $('#modal-form .modal-title').text('Edit Data Produk');

        //         $('#modal-form form')[0].reset();
        //         $('#modal-form form').attr('action', data.url);
        //         $('#modal-form [name=_method]').val('put');
        //         $('#modal-form [name=nama_produk]').focus();
        //         $('#modal-form [name=nama_kategori]').focus();
        //         $('#modal-form [name=nama_satuan]').focus();
        //         $('#modal-form [name=harga_beli]').focus();
        //         $('#modal-form [name=harga_jual]').focus();
        //         $('#modal-form [name=diskon]').focus();
        //         $('#modal-form [name=stok]').focus();

        //         $('#modal-form [name=nama_produk]').val(data.nama_produk);
        //         $('#modal-form [name=nama_kategori]').val(data.nama_kategori);
        //         $('#modal-form [name=nama_satuan]').val(data.nama_satuan);
        //         $('#modal-form [name=harga_beli]').val(data.harga_beli);
        //         $('#modal-form [name=harga_jual]').val(data.harga_jual);
        //         $('#modal-form [name=diskon]').val(data.diskon);
        //         $('#modal-form [name=stok]').val(data.stok);
        // }
        
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
                    alert('Gagal mengubah data!');
                    return;
                });
        }

        function deleteForm(url) {
            Swal.fire({
                title: 'Hapus Data Produk yang dipilih?',
                icon: 'question',
                iconColor: '#DC3545',
                showDenyButton: true,
                denyButtonColor: '#838383',
                denyButtonText: 'Batal',
                confirmButtonText: 'Hapus',
                confirmButtonColor: '#DC3545'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data Produk berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data Produk gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Data Produk batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }

        // function deleteForm(url) {
        //     if (confirm('Hapus Data Produk yang dipilih?')) {
        //     $.post(url, {
        //             '_token': $('[name=csrf-token]').attr('content'),
        //             '_method': 'delete'
        //         })
        //         .done((response) => {
        //             Swal.fire({
        //                 title: 'Sukses!',
        //                 text: 'Data Produk berhasil dihapus',
        //                 icon: 'success',
        //                 confirmButtonText: 'Lanjut',
        //                 confirmButtonColor: '#28A745'
        //             })                       
        //             table.ajax.reload();
        //         })
        //         .fail((errors) => {
        //             Swal.fire({
        //                 title: 'Gagal!',
        //                 text: 'Data Produk gagal dihapus',
        //                 icon: 'error',
        //                 confirmButtonText: 'Kembali',
        //                 confirmButtonColor: '#DC3545'
        //             })                       
        //             return;
        //         });
        //     }
        // }
    </script>
@endpush