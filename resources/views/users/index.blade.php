@extends('layouts.main')

@section('title')
Data Semua Pengguna
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('content')


<div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addData('{{ route('users.store') }}')" class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="6%">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Posisi</th>
                            <th width="13%" class="text-center">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
</div>
@includeIf('users.form')
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
                    url: '{{ route('users.data') }}',
                },          
                columns: [
                    {data:'DT_RowIndex', searchable: false, sortable: false},
                    {data:'name'},
                    {data:'username'},
                    {data:'email'},
                    {data:'level'},
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
                                text: 'Pengguna yang diinput sudah ada',
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

        function addData(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Pengguna Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();

            $('#password , #password_confirmation').attr('required', true);
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
        
        function editData(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Pengguna');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=name]').focus();

            $('#password, #password_confirmation').attr('required', false);

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=name]').val(response.name);
                    $('#modal-form [name=username]').val(response.username);
                    $('#modal-form [name=email]').val(response.email);   
                    $('#modal-form [name=level]').val(response.level);                                  
                })
                .fail((errors) => {
                    alert('Gagal mengubah data!');
                    return;
                });
        }

        function deleteForm(url) {
            Swal.fire({
                title: 'Hapus Pengguna yang dipilih?',
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
                            text: 'Pengguna berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Pengguna gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Pengguna batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }

        // function deleteForm(url) {
        //     if (confirm('Hapus Pengguna yang dipilih?')) {
        //     $.post(url, {
        //             '_token': $('[name=csrf-token]').attr('content'),
        //             '_method': 'delete'
        //         })
        //         .done((response) => {
        //             alert(
        //                 Swal.fire({
        //                     title: 'Sukses!',
        //                     text: 'Pengguna berhasil dihapus',
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
        //                     text: 'Pengguna gagal dihapus',
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