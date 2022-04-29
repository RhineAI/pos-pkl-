@extends('layouts.main')

@section('title')
Data Pengguna
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Data Pengguna</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addData('{{ route('users.store') }}')" class="btn btn-sm btn-flat btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="6%">No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Aksi</th>
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
                    {data:'aksi', searchable: false, sortable: false},
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
                                    text: 'Data Produk baru berhasil ditambahkan',
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
                                    text: 'Data Produk baru gagal ditambahkan',
                                    icon: 'error',
                                    confirmButtonText: 'Kembali'
                                })
                            );
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
            $('#modal-form .modal-title').text('Tambah User');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();

            $('#password , #password_confirmation').attr('required', true);
        }
        
        function editData(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Data User');

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
    </script>
@endpush