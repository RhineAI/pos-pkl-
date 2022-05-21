@extends('layouts.main')

@section('title')
Data Semua Supplier
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')


<div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('supplier.store') }}')" class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="6%">No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th width="12%">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
</div>
@includeIf('supplier.form')
@includeIf('supplier.produk')
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
                    url: '{{ route('supplier.data') }}',
                },
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'nama'},
                   {data:'alamat'},
                   {data:'telepon'},
                   {data:'aksi', searchable: false, sortable: false},
                ]
            });

            $('#modal-form').validator().on('submit', function (e) {
                if (! e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            Swal.fire({
                                title: 'Sukses!',
                                text: response,
                                icon: 'success',
                                confirmButtonText: 'Lanjut',
                                confirmButtonColor: '#28A745'
                            })
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Supplier yang diinput sudah ada',
                                icon: 'error',
                                confirmButtonText: 'Kembali',
                                confirmButtonColor: '#DC3545'
                            })
                            table.ajax.reload();
            
                            return;
                        });
                }
            });
        }); 

        function addForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Tambah Supplier Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        function tambahProduk(url) {
            $('#modal-produk').modal('show')
            $('#modal-produk .modal-title').text('Tambah Produk');

            $('#modal-produk form')[0].reset();
            $('#modal-produk form').attr('action', url);
            $('#modal-produk [name=_method]').val('post');
            $('#modal-produk [name=name]').focus();

        }

        function hideProduk() {
            $('#modal-produk').modal('hide');
        }

        function pilihProduk() {
            hideProduk();
            tambahkanProduk();
        }

        function tambahkanProduk() {
        $.post('{{ route('supplier.tambah') }}', $('.form-produk').serialize())
            .done(response => {
                alert('sucess');
            })
            .fail(errors => {
                alert('Tidak dapat menyimpan data');
                return;
            });
    }

        // $(document).on('click', '.edit', function (event) {
        //         let nama = $(this).data('supplier')
        //         let alamat = $(this).data('supplier')
        //         let telepon = $(this).data('supplier')
        //         let url = $(this).data('route')

        //         let data = {
        //             nama: nama,
        //             alamat: alamat ,
        //             telepon: telepon,
        //             url: url
        //         }

        //         editForm(data)
        // })

        // function editForm(data) {
        //         $('#modal-form').modal('show')
        //         $('#modal-form .modal-title').text('Edit Supplier');

        //         $('#modal-form form')[0].reset();
        //         $('#modal-form form').attr('action', data.url);
        //         $('#modal-form [name=_method]').val('put');
        //         $('#modal-form [name=nama]').focus();

        //         $('#modal-form [name=nama]').val(data.nama);
        // }
        
        function editData(url) {
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
            Swal.fire({
                title: 'Hapus Supplier yang dipilih?',
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
                            text: 'Supplier berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Supplier gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Supplier batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }

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