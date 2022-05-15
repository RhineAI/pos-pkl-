@extends('layouts.main')

@section('title')
Data Stok Masuk
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Stok Masuk</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('stokmasuk.store') }}')"
                    class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-stokmasuk">
                    <thead>
                        <th width="6%">No</th>
                        <th>Tanggal</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Jumlah (Stok)</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@includeIf('stokmasuk.form')

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
                url: '{{ route('stokmasuk.data') }}',
            },
            columns: [
               {data:'DT_RowIndex', searchable: false, sortable: false},
               {data:'tanggal'},
               {data:'barcode'},
               {data:'nama_produk'},
               {data:'jumlah'},
               {data:'keterangan'},
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
                                text: 'Stok baru berhasil ditambahkan',
                                icon: 'success',
                                confirmButtonText: 'Lanjut',
                                confirmButtonColor: '#28A745'
                            })
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Stok baru gagal ditambahkan',
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
        $('#modal-form .modal-title').text('Tambah Stok Baru');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
    }
    
    
    function deleteForm(url) {
        Swal.fire({
            title: 'Hapus Kategori yang dipilih?',
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
                        text: 'Data Stok berhasil dihapus',
                        icon: 'success',
                        confirmButtonText: 'Lanjut',
                        confirmButtonColor: '#28A745'
                    }) 
                    table.ajax.reload();
                })
                .fail((errors) => {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Data Stok gagal dihapus',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#DC3545'
                    })                       
                    return;
                });
            } else if (result.isDenied) {
                Swal.fire({
                    title: 'Data Stok batal dihapus',
                    icon: 'warning',
                })
            }
        })
    }
    </script>
@endpush