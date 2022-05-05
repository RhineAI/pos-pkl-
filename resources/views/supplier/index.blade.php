@extends('layouts.main')

@section('title')
Data Supplier
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('supplier.store') }}')" class="btn btn-sm btn-flat btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="6%">No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th width="7%">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
</div>
@includeIf('supplier.form')
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
                            alert(
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: 'Supplier baru berhasil ditambahkan',
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
                                    text: 'Supplier baru gagal ditambahkan',
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
            $('#modal-form .modal-title').text('Tambah Supplier');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }
        
        function editForm(url) {
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
            if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    alert(
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Supplier berhasil dihapus',
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
                            text: 'Supplier gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                    );
                    return;
                });
            }
        }
    </script>
@endpush