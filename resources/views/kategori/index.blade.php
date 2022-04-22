@extends('layouts.main')

@section('title')
Data Kategori Produk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Data Kategori Produk</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('kategori.store') }}')"
                    class="btn btn-sm btn-flat btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah</button>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="8%">No</th>
                        <th>Kategori</th>
                        <th width="12%">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('kategori.form')
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
                    url: '{{ route('kategori.data') }}',
                },
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'nama_kategori'},
                   {data:'aksi', searchable: false, sortable: false},
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
                                    text: 'Kategori berhasil ditambahkan',
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
                                    text: 'Kategori gagal ditambahkan',
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

        function addForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Tambah Kategori');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_kategori]').focus();
        }
        
        function editForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Kategori');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_kategori]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
                })
                .fail((errors) => {
                    alert('Gagal mengubah kategori!');
                    return;
                });
        }

        function deleteData(url) {
            $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'delete'
            })
            Swal.fire({
                title: 'Hapus kategori yang dipilih?',               
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Iya',                
                })
                .then((response) => {
                /* Read more about isConfirmed, isDenied below */
                if (response.isConfirmed) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Kategori berhasil dihapus',
                        icon: 'success',
                        confirmButtonText: 'Lanjut'
                    })
                    table.ajax.reload();
                }
            });  
        }
    </script>
@endpush