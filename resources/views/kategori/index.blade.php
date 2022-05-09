@extends('layouts.main')

@section('title')
Data Kategori Produk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('kategori.store') }}')"
                    class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah</button>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="6%">No</th>
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
                                    title: 'Sukses!',
                                    text: 'Kategori baru berhasil ditambahkan',
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
                                    text: 'Kategori baru gagal ditambahkan',
                                    icon: 'error',
                                    confirmButtonText: 'Kembali',
                                    confirmButtonColor: '#DC3545'
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
            $('#modal-form .modal-title').text('Tambah Kategori Baru');

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
            if (confirm('Hapus Kategori yang dipilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    alert(
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Kategori berhasil dihapus',
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
                            text: 'Kategori gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                    );
                    return;
                });
            }
        }

          //    $('.delete').click( function() {
        //         var kategori = $(this).attr('action');
        //         Swal.fire({
        //         title: 'Do you want to save the changes?',
        //         showDenyButton: true,
        //         confirmButtonText: 'Hapus',
        //         denyButtonText: `Gajadi`,
        //         }).then((result) => {
        //         /* Read more about isConfirmed, isDenied below */
        //             if (result.isConfirmed) {
        //                 Swal.fire('Saved!', '', 'success')
        //                 table.ajax.reload();
        //             } else{
        //                 Swal.fire('Changes are not saved', '', 'info')
        //             }
        //         })
        //    });
          
      
       

        
    </script>
@endpush