@extends('layouts.main')

@section('title')
Pengembalian Barang
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pengembalian Barang</li>
@endsection

@section('content')


<div class="row mx-3">
    <div class="col-md-12 p-2 mb-3" style="background-color: white">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('pengembalianBarang.store') }}')"
                    class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i>
                    Tambah</button>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th width="10%" class="text-center">Tanggal</th>
                        <th width="10%" class="text-center">Barcode</th>
                        <th class="text-center">Produk</th>
                        <th width="13%" class="text-center">Jumlah (Stok)</th>
                        <th  width="10%" class="text-center">Refund</th>
                        <th class="text-center">Supplier</th>
                        <th width="10%" class="text-center">Keterangan</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('pengembalianBarang.form')
@endsection

@push('scripts')
    <script>
        let table;

        $(function () {
            $('body').addClass('sidebar-collapse');
            table = $('.table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('pengembalian_barang.data') }}',
                },
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'tanggal'},
                   {data:'barcode'},
                   {data:'nama_produk'},
                   {data:'jumlah'},
                   {data:'harga'},
                   {data:'nama'},
                   {data:'keterangan'},
                   {data:'aksi', searchable: false, sortable: false},
                ]
            });

            $('#modal-form').validator().on('submit', function (e) {
                if (! e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            if(response.status == true) {
                                $('#modal-form').modal('hide');
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'Lanjut',
                                    confirmButtonColor: '#28A745'
                                })
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terdapat Kesalahan',
                                    icon: 'error',
                                    confirmButtonText: 'Kembali',
                                    confirmButtonColor: '#DC3545'
                                })
                                table.ajax.reload();
                
                                return;
                            }
                        })
                }
            });
        }); 

        function addForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Pengembalian Barang');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_produk]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=id_produk]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=id_produk]').val(response.id_produk);
                    $('#modal-form [name=jumlah]').val(response.jumlah);
                    $('#modal-form [name=id_supplier]').val(response.id_supplier);
                    $('#modal-form [name=keterangan]').val(response.keterangan);
                })
                .fail((errors) => {
                    alert('Gagal mengubah data!');
                    return;
                });
        }
        function deleteForm(url) {
            Swal.fire({
                title: 'Hapus Data Pengembalian Barang yang dipilih?',
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
                            text: 'Data Pengembalian Barang berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data Pengembalian Barang gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Data Pengembalian Barang batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }

    </script>
@endpush