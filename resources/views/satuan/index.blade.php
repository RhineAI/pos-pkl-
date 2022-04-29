@extends('layouts.main')

@section('title')
Data Satuan Produk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Data Satuan Produk</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="add('{{ route('satuan.store') }}')"
                    class="btn btn-sm btn-flat btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah</button>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="8%">No</th>
                        <th>Satuan</th>
                        <th width="12%">Aksi</th>
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
                            alert(
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Satuan berhasil ditambahkan',
                                    icon: 'success',
                                    confirmButtonText: 'Lanjut'
                                })
                            );
                            table.ajax.reload();
                        })

                        .fail((errors) => {
                            alert(
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Satuan gagal ditambahkan',
                                    icon: 'error',
                                    confirmButtonText: 'Kembali'
                                })
                            );
                            table.ajax.reload();
            
                            return;
                        });
                }
        })
    });

    function add(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Satuan');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_satuan]').focus();
    }

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
            if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    alert(
                        Swal.fire({
                            title: 'Success!',
                            text: 'Kategori berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut'
                        })                       
                    );
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert(
                        Swal.fire({
                            title: 'Failed!',
                            text: 'Kategori gagal dihapus',
                            icon: 'warning',
                            confirmButtonText: 'next'
                        })                       
                    );
                    return;
                });
            }
        }
        // function deleteData(url) {
        //     $.post(url, {
        //         '_token': $('[name=csrf-token]').attr('content'),
        //         '_method': 'delete'
        //     })
        //     Swal.fire({
        //         title: 'Hapus satuan yang dipilih?',               
        //         showCancelButton: true,
        //         cancelButtonText: 'Tidak',
        //         confirmButtonText: 'Iya',                
        //         })
        //         .then((response) => {
        //         /* Read more about isConfirmed, isDenied below */
        //         if (response.isConfirmed) {
        //             Swal.fire({
        //                 title: 'Success!',
        //                 text: 'Satuan berhasil dihapus',
        //                 icon: 'success',
        //                 confirmButtonText: 'Lanjut'
        //             })
        //             table.ajax.reload();
        //         } 
        //     });
        // }
    </script>
@endpush