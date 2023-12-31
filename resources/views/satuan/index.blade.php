@extends('layouts.main')

@section('title')
Data Satuan Produk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Satuan</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="add('{{ route('satuan.store') }}')"
                    class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah</button>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="6%">No</th>
                        <th class="text-center">Satuan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('satuan.form')
@endsection

@push('scripts')
    <script>
        let table; 

        $(function () {
            table = $('.table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('satuan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_satuan'},
                {data: 'act', searchable: false, sortable: false},
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
                                text: 'Satuan yang diinput sudah ada',
                                icon: 'error',
                                confirmButtonText: 'Kembali',
                                confirmButtonColor: '#DC3545'
                            })
                            table.ajax.reload();
            
                            return;
                        });
                }
        })
    });

    function add(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Satuan Baru');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_satuan]').focus();
    }

    // $(document).on('click', '.edit', function (event) {
    //         let nama_kategori = $(this).data('kategori')
    //         let url = $(this).data('route')

    //         let data = {
    //             nama_kategori: nama_kategori,
    //             url: url
    //         }

    //         editForm(data)
    // })

    // function editForm(data) {
    //         $('#modal-form').modal('show')
    //         $('#modal-form .modal-title').text('Edit Kategori');

    //         $('#modal-form form')[0].reset();
    //         $('#modal-form form').attr('action', data.url);
    //         $('#modal-form [name=_method]').val('put');
    //         $('#modal-form [name=nama_kategori]').focus();

    //         $('#modal-form [name=nama_kategori]').val(data.nama_kategori);
    // }

    function edit(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Satuan');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_satuan]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_satuan]').val(response.nama_satuan);
                    table.ajax.reload();
                })

                .fail((errors) => {
                    alert(
                        Swal.fire({
                        title: 'Error!',
                        text: 'Satuan gagal diupdate',
                        icon: 'error',
                        confirmButtonText: 'Kembali'
                        })
                    );
                    table.ajax.reload();
            
                    return;
                });
        }

        function deleteData(url) {
            Swal.fire({
                title: 'Hapus Satuan yang dipilih?',
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
                            text: 'Data Satuan berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data Satuan gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Satuan batal dihapus',
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